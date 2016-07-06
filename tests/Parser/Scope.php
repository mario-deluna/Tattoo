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
	public function testOne()
	{	
		$scope = $this->parse('span => "foo"');
		$this->assertInstanceOf('Tattoo\\Node\\Scope', $scope);
		$this->assertEquals(1, count( $scope->children));
	}

	/**
	 * tests Parser
	 */
	public function testEmpty()
	{	
		$scope = $this->parse('');
		$this->assertInstanceOf('Tattoo\\Node\\Scope', $scope);
		$this->assertEquals(0, count( $scope->children));
	}

	/**
	 * tests Parser
	 */
	public function testMany()
	{	
		$scope = $this->parse("a => 'b'\na => 'b'\na => 'b'\n");
		$this->assertInstanceOf('Tattoo\\Node\\Scope', $scope);
		$this->assertEquals(3, count( $scope->children));
	}

	/**
	 * tests Parser
	 */
	public function testContextAssignment()
	{	
		$scope = $this->parse("span => 'test'");
	}
}