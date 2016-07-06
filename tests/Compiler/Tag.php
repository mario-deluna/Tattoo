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
use Tattoo\Node\Variable;

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

        $this->assertContains("new Tattoo\\Engine\\Tag('hr', array(), null)", $tag);
    }

    /**
     * tests Parser
     */
    public function testTagWithAttributes()
    {
        $tag = new Tag;
        $tag->setName('input');
        $tag->setAttributes = array(
            'name' => 'username',
            'type' => 'text',
        );
        $tag = $this->compile($tag);

        $this->assertContains("array('name' => 'username', 'type' => 'text')", $tag);
    }

    /**
     * tests Parser
     */
    public function testTagWithAttributesEscaping()
    {
        $tag = new Tag;
        $tag->setName('input');
        $tag->setAttributes = array(
            'name' => new Variable('name'),
            'type' => 'text',
        );

        // assert with auto escaping
        $tagCompiled = $this->compile($tag, array('autoEscapeVariables' => true));
        $this->assertContains("array('name' => \$__tattoo_vars['name'], 'type' => 'text')", $tagCompiled);

        // assert without
        $tagCompiled = $this->compile($tag, array('autoEscapeVariables' => false));
        $this->assertContains("array('name' => \$__tattoo_vars['name'], 'type' => 'text')", $tagCompiled);
    }
}
