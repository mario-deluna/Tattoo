<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package           Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Append as AppendNode;
use Tattoo\Parser;

class Append extends Parser
{
    /**
     * The current node
     *
     * @var AppendNode
     */
    protected $append = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->append = new AppendNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->append;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();
        $this->skipToken();

        if ($token->type !== 'append')
        {
           throw $this->errorUnexpectedToken($token);
        }

        // a variable or a tag can follow on the append command
        // only short tags start with an identifier
        elseif ($this->currentToken()->type === 'identifier') 
        {
            $this->append->setNode($this->parseChild('ShortTag'));
        }

        // obviously when tag opens we parse a tag
        elseif ($this->currentToken()->type === 'tagOpen')
        {
             $this->append->setNode($this->parseChild('Tag'));
        }

        // Otherwise we just handle to coming stuff as an expression
        else
        {
            $this->append->setNode($this->parseChild('Expression'));
        }

        return $this->node();
    }
}
