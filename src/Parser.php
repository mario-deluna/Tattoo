<?php namespace Tattoo;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Parser\Exception;
 
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
	 * @return Tattoo\Node
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
	 * @return Tattoo\Node|false
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
	 * Get all tokens until the next linebreak
	 *
	 * @return array
	 */
	protected function getTokensUntilLinebreak()
	{
		$tokens = array();
		
		while( !$this->parserIsDone() && $this->currentToken()->type !== 'linebreak' )
		{
			$tokens[] = $this->currentToken(); $this->skipToken();
		}
		
		return $tokens;
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
	 * Create new unexpected token exception
	 *
	 * @param Tattoo\Node 				$token
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
			$this->next();
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