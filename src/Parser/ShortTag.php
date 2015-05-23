<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Parser;
use Tattoo\Node\Tag as TagNode;

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
		if ( $token->type !== 'identifier' )
		{
			$this->errorUnexpectedToken( $token );
		}
		
		$this->tag->name = $token->getValue();

		var_dump( $this->tag );die;
	}
}