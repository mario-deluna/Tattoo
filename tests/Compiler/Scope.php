<?php namespace Tattoo\Tests;
/**
 * Tattoo Compiler tests
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Compiler
 * @group Tattoo_Compiler_Scope
 */

use Tattoo\Node\Scope;
use Tattoo\Node\Tag;

class Compiler_Scope_Test extends Compiler_Test
{
	/**
	 * tests Parser
	 */
	public function testBasic()
	{	
		$node = new Scope;
		
		$tag = new Tag;
		$tag->setName('button');
		$node->addChild($tag);

		$node = $this->compile($node);
		
		$this->assertContains("if (!isset(\$__tattoo_vars)) {", $node);
		$this->assertContains("\$__tattoo_vars = array();", $node);
	}
}