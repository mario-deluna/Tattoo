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

        // we only neeed the tokens until the closing scope
        $this->setTokens($this->getTokensUntilClosingScope());
    }

    /**
     * We always cut the opening and closing scope so we have to tell the 
     * the parent parser that we skipped them outside the index
     * 
     * @return int
     */
    public function getParsedTokensCount()
    {
        return $this->getIndex() + 2;
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
        if ($this->currentToken()->type === 'scopeOpen')
        {
            $currentValue = $this->parseChild('Arr');
        }
        else
        {
            $currentValue = $this->parseChild('Expression', $this->getTokensUntil('comma'));
        }

        $this->arr->addItem($currentKey, $currentValue);
    }
}
