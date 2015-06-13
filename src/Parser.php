<?php namespace Tattoo;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */
 
abstract class Parser
{	
	/**
	 * The tokens in this code segment
	 *
	 * @var array[Token]
	 */
	protected $tokens = array();
	
	/**
	 * The current index while parsing trough the tokens
	 * 
	 * @var int
	 */
	protected $index = 0;
	
	/**
	 * The number of tokens to parse
	 * 
	 * @var int
	 */
	protected $tokenCount = 0;
	
	
	/**
	 * The constructor
	 * You have to initialize the Parser with an array of lexed tokens.
	 *
	 * @var array[Token] 			$tokens
	 * @return void
	 */
	public function __construct( array $tokens )
	{	
		foreach( $tokens as $key => $token )
		{
			// remove all comments and whitespaces
			if ( $token->type === 'comment' || $token->type === 'whitespace' )
			{
				unset( $tokens[$key] );
			}
		}
		
		// reset the keys
		$this->tokens = array_values( $tokens );
		
		// count the real number of tokens
		$this->tokenCount = count( $this->tokens );
		
		// prepare the parser
		$this->prepare();
	}
	
	/**
	 * Prepare the parser 
	 *
	 * @return void
	 */
	abstract protected function prepare();
	
	/**
	 * Retrives the current token based on the index
	 *
	 * @return Tattoo\Token
	 */
	protected function currentToken()
	{
		return $this->tokens[ $this->index ];
	}
	
	/**
	 * Get the next token based on the current index
	 * If the token does not exist because its off index "false" is returend.
	 *
	 * @param int 			$i
	 * @return Tattoo\Token|false
	 */
	protected function nextToken( $i = 1 )
	{
		if ( !isset( $this->tokens[ $this->index + $i ] ) )
		{
			return false;
		}
		
		return $this->tokens[ $this->index + $i ];
	}
	
	/**
	 * Skip the next parser token by updating the index.
	 *
	 * @param int			$times
	 * @return void
	 */
	protected function skipToken( $times = 1 )
	{
		$this->index += $times;
	}

	/**
	 * Check if all tokens have been parsed trough
	 *
	 * @return bool
	 */
	protected function parserIsDone()
	{
		return $this->index >= $this->tokenCount;
	}
	
	/**
	 * Get all tokens until the next token with given type
	 * 
	 * @param string 			$type
	 * @return array[Tattoo\Token]
	 */
	protected function getTokensUntil( $type )
	{
		$tokens = array();
		
		while( !$this->parserIsDone() && $this->currentToken()->type !== $type )
		{
			$tokens[] = $this->currentToken(); $this->skipToken();
		}
		
		$this->skipToken();
		
		return $tokens;
	}
	
	/**
	 * Get all tokens until the next linebreak
	 *
	 * @return array[Tattoo\Token]
	 */
	protected function getTokensUntilLinebreak()
	{
		return $this->getTokensUntil( 'linebreak' );
	}

	/**
	 * Check if the current token is the end of a expression
	 *
	 * @return bool
	 */
	protected function isEndOfExpression()
	{
		return $this->parserIsDone() || $this->currentToken()->type === 'linebreak';
	}
	
	/**
	 * Check if the current parser contains a token of given type
	 *
	 * @param string 				$type
	 * @return bool
	 */
	protected function containsTokenOfType( $type )
	{
		$found = false;
		
		foreach ( $this->tokens as $token )
		{
			if ( !$found && $token->type === $type )
			{
				$found = true;
			}
		}
		
		return $found;
	}
	
	/**
	 * Parse attribute tokens
	 *
	 * @param array[Tattoo\Token] 			$tokens
	 * @return array
	 */
	protected function parseAttributeTokens( array $tokens )
	{
		if ( empty( $tokens ) )
		{
			return array();
		}

		$firstToken = reset( $tokens );
		$classAndIdAttrTokens = array();

		// check if the first token is an anchor or accessor
		if ( $firstToken->type === 'accessor' || $firstToken->type === 'anchor' )
		{
			foreach( $tokens as $key => $token )
			{
				if ( $token->type === 'comma' )
				{
					break;
				}

				$classAndIdAttrTokens[] = $token; unset( $tokens[$key] );
			}
		}

		return $attributes = $this->parseIdAndClassTokens( $classAndIdAttrTokens );
		return array_merge_recursive( $attributes, $this->fixAttributesArray( $this->parseArray( $tokens ) ) );
	}

	/**
	 * Parses id and class tokens and build an attribute array
	 *
	 * @param array[Tattoo\Token]			$tokens
	 * @return array
	 */
	protected function parseIdAndClassTokens( array $tokens )
	{
		$attributes = array();

		foreach( array_chunk( $tokens, 2 ) as $chunk )
		{
			if ( count( $chunk ) !== 2 )
			{
				throw new Exception( 'Invalid number of attributes given at line '.$token->line );
			}

			list( $describer, $identifier ) = $chunk;

			if ( $describer->type === 'accessor' )
			{
				$attributes['class'][] = $identifier->getValue();
			} 
			elseif ( $describer->type === 'anchor' )
			{
				if ( isset( $attributes['id'] ) )
				{
					throw new Exception( 'Id has already been set, cannot set twice at line '.$token->line );
				}

				$attributes['id'] = $identifier->getValue();
			}
		} 

		return $attributes;
	}

	/**
	 * Create new unexpected token exception
	 *
	 * @param Tattoo\Token 				$token
	 * @return Tattoo\Parser\Exception;
	 */
	protected function errorUnexpectedToken( $token )
	{
		return new Exception( 'unexpected "'.$token->type.'" given at line '.$token->line );
	}
	
	/**
	 * Start the code parser and return the result  
	 * 
	 * @return array
	 */
	public function parse()
	{		
		// reset the result
		$this->result = array();	
	
		// start parsing trought the tokens
		while( !$this->parserIsDone() )
		{
			$specialNode = $this->next();
			
			if ( $specialNode instanceof Node )
			{
				return $specialNode;
			}
		}
		
		// return the result after the loop is done
		return $this->node();
	}
	
	/**
	 * Return the node that got parsed
	 *
	 * @return void
	 */
	abstract protected function node();
	
	/**
	 * Parse the next token
	 *
	 * @return void
	 */
	abstract protected function next();
}