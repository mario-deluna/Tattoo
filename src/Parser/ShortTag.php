<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Tag as TagNode;
use Tattoo\Node\Text as TextNode;
use Tattoo\Node\Arr as ArrNode;
use Tattoo\Parser;
use Tattoo\Token;

class ShortTag extends Parser
{
    /**
     * The current scope node
     *
     * @var Tattoo\Node\Tag
     */
    protected $tag = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->tag = new TagNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->tag;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

        // current token has to be an identifier
        if ($token->type !== 'identifier') 
        {
            throw $this->errorUnexpectedToken($token);
        }

        $this->tag->setName($token->getValue());
        $this->skipToken();

        // we use all tokens until a linebreak in the short tag
        $tokens = $this->getTokensUntilLinebreak();

        $attributeTokens = array();

        // retrieve all attribute tokens
        foreach ($tokens as $key => $token) 
        {
            if ($token->type === 'assignText')
            {
                break;
            }

            $attributeTokens[] = $token; 
            unset($tokens[$key]);
        }

        // now lets parse the attributes
        $this->tag->setAttributes($this->parseAttributeTokens($attributeTokens));

        // reset the token array keys
        $tokens = array_values($tokens);
        
        if (!empty($tokens) && $tokens[0]->type === 'assignText')
        {
            unset($tokens[0]);

            $this->tag->addChild(new TextNode($this->parseChild('Expression', $tokens, false)));
        }

        // return the result
        return $this->node();
    }

    /**
     * Parse attribute tokens
     *
     * @param array[Tattoo\Token]             $tokens
     * @return array
     */
    public function parseAttributeTokens(array $tokens)
    {
        if (empty($tokens)) 
        {
            return new ArrNode;
        }

        $firstToken = reset($tokens);
        $classAndIdAttrTokens = array();

        // check if the first token is an anchor or accessor
        if ($firstToken->type === 'accessor' || $firstToken->type === 'anchor') 
        {
            foreach ($tokens as $key => $token) 
            {
                if ($token->type === 'comma') 
                {
                    unset($tokens[$key]); break;
                }

                $classAndIdAttrTokens[] = $token;unset($tokens[$key]);
            }
        }

        // start with a scope open token
        $attributeTokens = array(new Token(array('scopeOpen', null, $firstToken->line)));

        // add the parsed tokens
        if (is_array($tokens))
        {
            $attributeTokens = array_merge($attributeTokens, $tokens);
        }

        // add a closing attribute token
        $attributeTokens = array_merge($attributeTokens, array(new Token(array('scopeClose', null, $firstToken->line))));

        return $attributesArray = $this->parseChild('Arr', $attributeTokens, false);

        // retrive the attributes an normalize them
        $attributes = $this->parseIdAndClassTokens($classAndIdAttrTokens);
        return array_merge_recursive($attributes, $this->fixAttributesArray($attributesArray->convertToNative()));
    }

    /**
     * Fixes an array of attributes with attribute speical cases
     * 
     * @param array             $array
     * @return array
     */
    public function fixAttributesArray(array $array)
    {
        // fix classes given as string
        if (isset($array['class']) && is_string($array['class']))
        {
            $array['class'] = explode(' ', $array['class']);
        }

        return $array;
    }

    /**
     * Parses id and class tokens and build an attribute array
     *
     * @param array[Tattoo\Token]            $tokens
     * @return array
     */
    public function parseIdAndClassTokens(array $tokens)
    {
        $attributes = array();

        $preparedTokens = array();
        $tokenPreperationIndex = 0;

        // we have to merge tilde classes before
        while(isset($tokens[$tokenPreperationIndex]))
        {
            $preparedTokens[] = $token = $tokens[$tokenPreperationIndex];

            if ($token->type === 'tilde') 
            {
                array_pop($preparedTokens);

                if ((!isset($tokens[$tokenPreperationIndex - 1])) || $tokens[$tokenPreperationIndex - 1]->type !== 'identifier')
                {
                    throw $this->errorUnexpectedToken($token);
                }

                $basePrefix = $tokens[$tokenPreperationIndex - 1]->getValue();

                while(isset($tokens[$tokenPreperationIndex]) && $tokens[$tokenPreperationIndex]->type === 'tilde')
                {
                    if ((!isset($tokens[$tokenPreperationIndex + 1])) || $tokens[$tokenPreperationIndex + 1]->type !== 'identifier')
                    {
                        throw $this->errorUnexpectedToken($token);
                    }

                    $nextToken = $tokens[$tokenPreperationIndex + 1];

                    $preparedTokens[] = new Token(array('accessor', '.', $nextToken->line));
                    $preparedTokens[] = new Token(array('identifier', $basePrefix . '-' . $nextToken->getValue(), $nextToken->line));

                    $tokenPreperationIndex += 2;
                }

                $tokenPreperationIndex++;
            }

            $tokenPreperationIndex++;
        }

        // finally parse the attributes
        foreach (array_chunk($preparedTokens, 2) as $chunk) 
        {
            if (count($chunk) !== 2) 
            {
                throw new Exception('Invalid number of attributes given at line ' . reset($chunk)->line);
            }

            list($describer, $identifier) = $chunk;

            if ($describer->type === 'accessor') 
            {
                $attributes['class'][] = $identifier->getValue();
            }
            elseif ($describer->type === 'anchor') 
            {
                if (isset($attributes['id'])) 
                {
                    throw new Exception('Id has already been set, cannot set twice at line ' . $describer->line);
                }

                $attributes['id'] = $identifier->getValue();
            }
        }

        return $attributes;
    }
}
