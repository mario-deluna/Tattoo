<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Value as ValueNode;
use Tattoo\Node\Arr as ArrNode;
use Tattoo\Node\Arr\AutoKey;
use Tattoo\Node\Arr\NumericKey;
use Tattoo\Node\Arr\AssocKey;
use Tattoo\Parser;

class Arr extends Parser
{
    /**
     * The current scope node
     *
     * @var Tattoo\Node\Scope
     */
    protected $arr = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->arr = new ArrNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->arr;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();
        $currentKey = new AutoKey;
        $currentValue = null;

        // try to get the key if there is one
        if ($this->nextToken() && $this->nextToken()->type === 'assign')
        {
            if ($token->type !== 'identifier' && $token->type !== 'variable')
            {
                throw new Exception('Cannot use token of type: ' . $token->type . ' as array key at line: ' . $token->line);
            }

            // handle assoc keys
            if ($token->type === 'identifier')
            {
                $currentKey = new AssocKey(new ValueNode($token->getValue(), 'string'));
            }

            $this->skipToken(2);
        }

        // handle recursion
        if ($token->type === 'scopeOpen')
        {
            $this->skipToken();

            $currentLevel = 0;
            $subTokens = array();

            while($this->currentToken() && !($this->currentToken()->type === 'scopeClose' && $currentLevel === 0))
            {
                if ($this->currentToken()->type === 'scopeOpen')
                {
                    $currentLevel++;
                }

                if ($this->currentToken()->type === 'scopeClose')
                {
                    $currentLevel--;
                }

                $subTokens[] = $this->currentToken();
                $this->skipToken();
            }

            // skip the closing scope
            $this->skipToken();

            $currentValue = $this->parseArrayTokens($subTokens);
        }
        else
        {
            $currentValue = new Expression($this->getTokensUntil('comma'));
            $currentValue = $currentValue->parse();
        }

        $this->arr->addItem($currentKey, $currentValue);
    }
}
