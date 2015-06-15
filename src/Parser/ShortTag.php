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
            $this->errorUnexpectedToken($token);
        }

        $this->tag->setName( $token->getValue() );

        // now lets parse the attributes
        $this->skipToken();
        $this->tag->attributes = $this->parseAttributeTokens($this->getTokensUntil('assignText'));

        // and the value for the text
        $expression = new Expression($this->getTokensUntilLinebreak());

        // create new text node containing the value
        $text = new TextNode($expression->parse());

        // append that node to the current tag
        $this->tag->addChild($text);
    }
}
