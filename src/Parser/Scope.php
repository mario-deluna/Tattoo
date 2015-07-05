<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Scope as ScopeNode;
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

        // only short tags start with an identifier
        elseif ($token->type === 'identifier') 
        {
            $shortTagParser = new ShortTag($this->getTokensUntilLinebreak());
            $this->skipToken();
            $this->scope->addChild($shortTagParser->parse());
        }

        // obviously when tag opens we parse a tag
        elseif ($token->type === 'tagOpen')
        {
            $this->skipToken();

            $tagTokens = $this->getTokensUntil('tagClose');
            $this->skipToken();
            $tagTokens = array_merge($tagTokens, $this->getTokensUntilLinebreak());

            // skip additional linebreaks
            $this->skipTokensOfType('linebreak');

            // if the next token is an open scope we get all 
            // tokens until the scope closes again
            if ($this->currentToken() && $this->currentToken()->type === 'scopeOpen')   
            {
                $tagTokens = array_merge($tagTokens, $this->getTokensUntilClosingScope(true));
                $this->skipToken();
             }

            $tagParser = new Tag($tagTokens);
            $this->scope->addChild($tagParser->parse());
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
