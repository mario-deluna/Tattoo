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
 * @group Tattoo_Parser_Scope
 */

use Tattoo\Lexer;
use Tattoo\Parser\Scope;

class Parser_Scope_Test extends Parser_Test
{
	/**
	 * tests Parser
	 */
	public function testConsturct()
	{	
		var_dump( $this->parse( 'span => "Hello World"' ) );
	}
}