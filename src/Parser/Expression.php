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
        throw new Exception('Cannot build node from empty expression on line: ' . $this->currentToken()->line);
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
            // when entered here there is no come back so
            // we can skip the current token safely
            $this->skipToken();

            // if the current token is a simple value create
            // a value node and return
            if ($token->isValue())
            {
                return new ValueNode($token->getValue(), $token->type);
            }  
            // we also might have a variable
            elseif($token->type === 'variable')
            {
                return $this->parseVariable();
            }

            // when nothing matches erörrr
            else
            {
                throw $this->errorUnexpectedToken($token);
            }
        }

        // scope open means an array
        elseif ($token->type === 'scopeOpen')
        {
            return $this->parseChild('Arr', $this->getTokensUntilClosingScope());
        }

        // and of course everything else is an syntax error
        else
        {
            throw $this->errorUnexpectedToken($token);
        }
    }
}
