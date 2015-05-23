<?php namespace Tattoo\Parser;

/**
 * Tattoo Expression Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Parser;
use Tattoo\Node\Value as ValueNode;

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
		throw new Exception( 'Cannot build node from empty expression.' );
	}

	/**
	 * Parse the next token
	 *
	 * @return void
	 */
	protected function next()
	{
		$token = $this->currentToken();
		
		// if we only have one token return it as value
		if ( $this->tokenCount === 1 )
		{
			$value = new ValueNode;
			$value->value = $token->getValue();
			$value->type = $token->type;
			
			return $value;
		}
		
		// first we need to identify the what kind of expression we have
	}
}