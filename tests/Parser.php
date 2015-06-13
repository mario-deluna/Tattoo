<?php namespace Tattoo\Tests;
/**
 * Tattoo Parser test
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Parser
 */

use Tattoo\Lexer;
use Tattoo\Parser\Scope;
use Tattoo\Parser;

/**
 * Dummy Parser
 */
class Parser_Dummy extends Parser
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
		return;
	} 
}

class Parser_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Parse some tattoo code and return the nodes
	 */
	protected function parse( $code )
	{
		$lexer = new Lexer( $code );
		$parser = new Scope( $lexer->tokens() );
		
		return $parser->parse();
	}
	
	/**
	 * tests Parser
	 */
	public function testConsturct()
	{	
		$lexer = new Lexer( 'foo' );
		$parser = new Scope( $lexer->tokens() );
		$this->assertInstanceOf( 'Tattoo\\Parser', $parser );
	}
}