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
use Tattoo\Parser\Expression;
use Tattoo\Parser\Scope;

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
            $this->loop->setKeyVariable($this->parseChild('Variable'));

            // skip the comma
            $this->skipToken();
        }

        $this->loop->setValueVariable($this->parseChild('Variable'));

        // skip so that we can parse the upcoming array or variable
        $this->skipToken();

        // parse the upcoming expresssion
        $collection = $this->parseChild('Expression');
        
        
        $expressionTokens = $this->getTokensUntilLinebreak();

        // if the last token was an scope open we go that token
        // back for the loop parser and remove it from the expression tokens
        if ($this->nextToken(-1)->type === 'scopeOpen')
        {
            $this->skipToken(-1);
            $expressionTokens = array_slice($expressionTokens, 0, -1);
        }

        // skip linebreaks
        $this->skipTokensOfType('linebreak');

        // parse the expression and assign the resutl to the loop collection
        $expression = new Expression($expressionTokens);

        $this->loop->setCollection($expression->parse());

        // the current token now has to be a scope open so lets parse that scope
        if ($this->currentToken()->type !== 'scopeOpen')
        {
            throw $this->errorUnexpectedToken($this->currentToken());
        } 

        // now parse the rest of the scope
        if ($scopeTokens = $this->getTokensUntilClosingScope())
        {
            $scopeParser = new Scope($scopeTokens);

            // assign the parsed children to the current tag
            foreach($scopeParser->parse()->getChildren() as $child)
            {
                $this->loop->addChild($child);
            }

            $this->skipToken();
        }

        return $this->loop;
    }
}
