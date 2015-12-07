<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Scope as ScopeNode;
use Tattoo\Node\Append as AppendNode;
use Tattoo\Parser;

class Scope extends Parser
{
    /**
     * The current scope node
     *
     * @var Tattoo\Node\Scope
     */
    protected $scope = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->scope = new ScopeNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->scope;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

        // we can skip linebreaks
        if ($token->type === 'linebreak')
        {
            $this->skipToken();
        }

        // check for appending commands
        elseif ($token->type === 'append')
        {
            $this->scope->addChild($this->parseChild('Append'));
        }

        // only short tags start with an identifier
        // we automatically add the append node 
        elseif ($token->type === 'identifier') 
        {
            $appendingNode = new AppendNode;
            $appendingNode->setNode($this->parseChild('ShortTag'));
            // add the child to the scope
            $this->scope->addChild($appendingNode);
        }

        // obviously when tag opens we parse a tag
        elseif ($token->type === 'tagOpen')
        {
            $appendingNode = new AppendNode;
            $appendingNode->setNode($this->parseChild('Tag'));
            // add the child to the scope
            $this->scope->addChild($appendingNode);
        }
        
        // loops
        elseif (in_array($token->type, array('foreach', 'loop')))
        {
            $loopTokens = $this->getRemainingTokens();

            if ($token->type === 'foreach')
            {
                $loopParser = new Loop\Each($loopTokens);
            }

            $loopNode = $loopParser->parse();

            $this->scope->addChild($loopNode);

            $scopeNode = $this->scope;

            $loopNode->onReciveContext(function($context) use($scopeNode, $loopNode) {
                // because the loop itself has no real context
                // we have to forward the context of the current scope
                $loopNode->setChildContext($context);
            });

            $this->skipToken($loopParser->getIndex());
        }

        // variable declarations
        elseif ($token->type === 'variable')
        {
            $this->scope->addChild($this->parseChild('VarDeclaration'));
        }

        // otherwise throw an exception
        else
        {
             throw $this->errorUnexpectedToken($token);
        }
    }
}
