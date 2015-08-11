<?php namespace Tattoo\Tests;

/**
 * Tattoo Compiler tests
 **
 *
 * @package         Tattoo
 * @copyright         Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Compiler
 * @group Tattoo_Compiler_Tag
 */

use Tattoo\Node\Tag;

class Compiler_Tag_Test extends Compiler_Test
{
    /**
     * tests Parser
     */
    public function testTag()
    {
        $tag = new Tag;
        $tag->setName('hr');
        $tag = $this->compile($tag);

        $this->assertContains("echo new Tattoo\\Engine\\Tag('hr', array(), function(\$__tattoo_tag) use(\$__tattoo_vars)", $tag);
    }

    /**
     * tests Parser
     */
    public function testTagWithAttributes()
    {
        $tag = new Tag;
        $tag->setName('input');
        $tag->attributes = array(
            'name' => 'username',
            'type' => 'text',
        );
        $tag = $this->compile($tag);

        $this->assertContains("array('name' => 'username', 'type' => 'text')", $tag);
    }
}
