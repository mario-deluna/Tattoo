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
	public function testConsturct()
	{	
		$node = new Scope;
		
		$tag = new Tag;
		$tag->name = 'button';
		
		$node->addChild( $tag );
		
		var_dump( $this->compile( $node  ) );
	}
}