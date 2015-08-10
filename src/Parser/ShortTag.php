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

class ShortTag extends Parser
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
        $token = $this->currentToken();

        // current token has to be an identifier
        if ($token->type !== 'identifier') 
        {
            throw $this->errorUnexpectedToken($token);
        }

        $this->tag->setName($token->getValue());
        $this->skipToken();

        // we use all tokens until a linebreak in the short tag
        $tokens = $this->getTokensUntilLinebreak();

        $attributeTokens = array();

        // retrieve all attribute tokens
        foreach ($tokens as &$token) 
        {
            if ($token->type === 'assignText')
            {
                break;
            }

            $attributeTokens[] = $token; unset($token);
        }

        // now lets parse the attributes
        $this->tag->attributes = $this->parseAttributeTokens($attributeTokens);

        // reset the token array keys
        $tokens = array_values($tokens);

        if (!empty($tokens) && $tokens[0]->type === 'assignText')
        {
            unset($tokens[0]);

            $this->tag->addChild(new TextNode($this->parseChild('Expression', $tokens)));
        }

        // return the result
        return $this->node();
    }
}
