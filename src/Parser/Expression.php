<?php namespace Tattoo\Parser;

/**
 * Tattoo Expression Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Value as ValueNode;
use Tattoo\Node\Concat as ConcatNode;
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

        $initiator = null;

        // the initiator could be a primitive value
        if ($token->isValue())
        {
            $initiator = new ValueNode($token->getValue(), $token->type); $this->skipToken();
        }
        // we also might have a variable
        elseif($token->type === 'variable')
        {
            $initiator = $this->parseChild('Variable');
        }
        // scope open means an array
        elseif ($token->type === 'scopeOpen')
        {
            return $this->parseChild('Arr');
        }
        // and of course everything else is an syntax error
        else
        {
            throw $this->errorUnexpectedToken($token);
        }

        // check for string concat or math functions 
        if ($this->currentToken() && $this->currentToken()->type === 'concat')
        {
            // skip the concat
            $this->skipToken();
            
            $nextExpression = $this->parseChild('Expression');

            $concat = new ConcatNode();
            $concat->addNode($initiator);

            // if next expression is already a concat add the child nodes
            if ($nextExpression instanceof ConcatNode)
            {
                foreach($nextExpression->getNodes() as $node)
                {
                    $concat->addNode($node);
                }
            }
            // otherwise add the next expression itself
            else
            {
               $concat->addNode($nextExpression); 
            }

            return $concat;
        }

        return $initiator;
    }
}
