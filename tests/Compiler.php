<?php namespace Tattoo\Tests;
/**
 * Tattoo Parser test
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Compiler
 */

use Tattoo\Node;
use Tattoo\Compiler\Scope;

class Compiler_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Parse some tattoo code and return the nodes
	 */
	protected function compile(Node $node)
	{
		$class = substr( get_called_class(), strrpos( get_called_class(), "\\" )+1, -5 );
		$class = "Tattoo\\".str_replace('_', "\\", $class);
		
		$compiler = new $class( $node );
		return trim($compiler->compile());
	}

	/**
	 * tests Parser
	 */
	public function testConsturct()
	{	
		$compiler = new Scope(new Node);
		$this->assertInstanceOf( 'Tattoo\\Compiler\\Scope', $compiler );
	}
}