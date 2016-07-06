<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Tag as TagNode;
use Tattoo\Node\Text as TextNode;
use Tattoo\Node\Append as AppendNode;
use Tattoo\Parser;

class Tag extends Parser
{
    /**
     * The current scope node
     *
     * @var Tattoo\Node\Tag
     */
    protected $tag = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->tag = new TagNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->tag;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        // check that a tag is being opend
        if ($this->currentToken()->type !== 'tagOpen') 
        {
            throw $this->errorUnexpectedToken($this->currentToken());
        }

        // the normal tag is baiscally a short tag with out the 
        // tag tokens so we simply strip them
        $this->skipToken();

        // get all tokens until tag close
        $tokens = $this->getTokensUntil('tagClose'); 
        $this->skipToken();

        // we might have tag recursion
        if ($this->currentToken() && $this->currentToken()->type === 'tagOpen')
        {
            $this->tag = $this->parseChild('ShortTag', $tokens, false);

            $appendingNode = new AppendNode;
            $appendingNode->setNode($this->parseChild('Tag'));
            
            // add the child to the scope
            $this->tag->addChild($appendingNode);

            return $this->node();
        }

        // and add the tokens until linebreak
        $tokens = array_merge($tokens, $this->getTokensUntil(array('linebreak', 'scopeOpen')));

        // parse the short tag as base
        $this->tag = $this->parseChild('ShortTag', $tokens, false);

        // we might have some linebreak
        $this->skipTokensOfType('linebreak');

        // is there a following scope
        if ($this->currentToken() && $this->currentToken()->type === 'scopeOpen')
        {
            // now parse the rest of the scope
            if ($scopeTokens = $this->getTokensUntilClosingScope())
            {
                $scopeParse = new Scope($scopeTokens);

                // assign the parsed children to the current tag
                foreach($scopeParse->parse()->getChildren() as $child)
                {
                    $this->tag->addChild($child);
                }
            }
        }

        return $this->node();
    }
}
