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
 * @group Tattoo_Compiler_Tag
 */

use Tattoo\Node\Scope;
use Tattoo\Node\Tag;
use Tattoo\Node\Text;

class Compiler_Tag_Test extends Compiler_Test
{
	/**
	 * tests Parser
	 */
	public function testConsturct()
	{	
		$tag = new Tag;
		$tag->name = 'button';

		var_dump( $this->compile( $tag ) );
	}
}