<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Variable as VariableNode;
use Tattoo\Parser;

class Variable extends Parser
{
    /**
     * The current declaration node
     *
     * @var \Tattoo\Node\VariableNode
     */
    protected $variable = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->variable = new VariableNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->variable;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

        if ($token->type !== 'variable')
        {
           throw $this->errorUnexpectedToken($token);
        }

        $this->skipToken();
        $this->variable->setName($token->getValue());

        return $this->node();
    }
}
