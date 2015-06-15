<?php namespace Tattoo\Parser;

/**
 * Tattoo Expression Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Value as ValueNode;
use Tattoo\Parser;

class Expression extends Parser
{
    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare() {}

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        throw new Exception('Cannot build node from empty expression.');
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

        // if we only have one token return it as value
        if ($this->tokenCount === 1) 
        {
            return new ValueNode($token->getValue(), $token->type);
        }

        $this->skipToken();
        // first we need to identify the what kind of expression we have
    }
}
