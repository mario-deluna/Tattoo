<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Parser;
use Tattoo\Node\Scope as ScopeNode;

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
		
		// only short tags start with an identifier
		if ( $token->type === 'identifier' )
		{	
			$shortTagParser = new ShortTag( $this->getTokensUntilLinebreak() );
			$this->scope->addChild( $shortTagParser->parse() );
		}
	}
}