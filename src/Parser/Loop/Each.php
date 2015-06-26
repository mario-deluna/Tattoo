<?php namespace Tattoo\Parser\Loop;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Variable as VariableNode;
use Tattoo\Node\Loop\Each as EachNode;
use Tattoo\Parser;

class Each extends Parser
{
    /**
     * The current loop node
     *
     * @var Tattoo\Node\Loop\Each
     */
    protected $loop = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->loop = new EachNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->loop;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

        if ($token->type !== 'foreach')
        {
            throw $this->errorUnexpectedToken($token);
        }

        $this->skipToken();

        // If the next key is a comma we have to assign both key and value
        if ($this->nextToken()->type === 'comma')
        {
            $this->loop->setKeyVariable($this->parseVariable());

            // skip the comma
            $this->skipToken();
        }

        $this->loop->setValueVariable($this->parseVariable());

        var_dump($this->loop); die;
    }
}
