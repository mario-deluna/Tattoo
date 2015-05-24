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
		$tag->name = 'hr';
		
		$this->assertEquals( "echo '<hr />';", $this->compile( $tag ) );
	}
	
	/**
	 * tests Parser
	 */
	public function testTagWithAttributes()
	{	
		$tag = new Tag;
		$tag->name = 'input';
		$tag->attributes = array(
			'name' => 'username',
			'type' => 'text',
		);
		
		$this->assertEquals( "echo '<input name=\"username\" type=\"text\" />';", $this->compile( $tag ) );
	}
	
	/**
	 * tests Parser
	 */
	public function testTagInsideTag()
	{	
		$tag = new Tag;
		$tag->name = 'a';
		
		$span = new Tag;
		$span->name = 'span';
		
		$tag->addChild( $span );
		
		$this->assertWithSampleFile( "tag.inside.tag", $this->compile( $tag ) );
	}
}