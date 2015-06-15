<?php namespace Tattoo\Tests;
/**
 * Tattoo Node test
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Node
 */

use Tattoo\Node;

class Node_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Returns dummy nodes
	 */
	public function dummyNodeProvider()
	{
		return array(array(new Node_Dummy));
	}

	/**
	 * tests Node
	 * 
	 * @dataProvider dummyNodeProvider
	 */
	public function testConstruct($node)
	{
		$this->assertInstanceOf('Tattoo\\Node', $node);
	}

	/**
	 * tests Node
	 * 
	 * @dataProvider dummyNodeProvider
	 */
	public function testVirtualGetter($node)
	{
		$this->assertEquals('Unknown', $node->getName());
	}

	/**
	 * tests Node
	 * 
	 * @dataProvider dummyNodeProvider
	 */
	public function testVirtualSetter($node)
	{
		$node->setName('phpunit');
		$this->assertEquals('phpunit', $node->getName());
	}

	/**
	 * tests Node
	 * 
	 * @dataProvider dummyNodeProvider
	 */
	public function testOverwrittenGetter($node)
	{
		$node->setValue('foo');
		$this->assertEquals('FOO', $node->getValue());
	}

	/**
	 * tests Node
	 * 
	 * @dataProvider dummyNodeProvider
	 */
	public function testOverwrittenSetter($node)
	{
		$node->setText('BAR');
		$this->assertEquals('bar', $node->getText());
	}
}

/**
 * Node dummy class
 */
class Node_Dummy extends Node
{
	protected $value;
	protected $name = 'Unknown';
	public $text;

	protected function setText($value)
	{
		return strtolower($value);
	}

	protected function getValue($value)
	{
		return strtoupper($value);
	}
}