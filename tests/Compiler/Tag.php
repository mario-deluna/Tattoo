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
	public function testTag()
	{	
		$tag = new Tag;
		$tag->name = 'button';
		
		$this->assertWithSampleFile( 'tag.simple', $this->compile( $tag ) );
	}
	
	/**
	 * tests Parser
	 */
	public function testTagWithAttributes()
	{	
		$tag = new Tag;
		$tag->name = 'button';
		$tag->attributes = array(
			'class' => array( 'btn', 'btn-lg' ),
		);
		
		$this->assertWithSampleFile( 'tag.attributes', $this->compile( $tag ) );
	}
}