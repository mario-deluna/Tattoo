<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Tag as TagNode;
use Tattoo\Node\Text as TextNode;
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
        if ($this->currentToken()->type === 'linebreak')
        {
            return $this->skipToken();
        }

        // current token has to be an identifier
        if ($this->currentToken()->type !== 'identifier') 
        {
            throw $this->errorUnexpectedToken($this->currentToken());
        }

        // use the shortag parser as base parser 
        $baseTagParser = new ShortTag($this->getTokensUntil(array('linebreak', 'scopeOpen')));
        $this->tag = $baseTagParser->parse();

        $this->skipTokensOfType('linebreak');

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

                $this->skipToken();
            }
        }
    }
}
