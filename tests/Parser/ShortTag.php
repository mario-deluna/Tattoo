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
 * @group Tattoo_Parser_ShortTag
 */

use Tattoo\Lexer;
use Tattoo\Parser\Scope;

class Parser_ShortTag_Test extends Parser_Test
{
	/**
	 * tests Parser
	 */
	public function testConsturct()
	{	
		//var_dump( $this->parse( "span #main-text .strong.bigger => 'Hello World'" ) ); die;
	}
}