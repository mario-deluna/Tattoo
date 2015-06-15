<?php namespace Tattoo\Tests;

/**
 * Tattoo Parser test
 **
 *
 * @package         Tattoo
 * @copyright         Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Parser
 * @group Tattoo_Parser_ShortTag
 */

class Parser_ShortTag_Test extends Parser_Test
{
    /**
     * tests Parser
     */
    public function testSimple()
    {
        $node = $this->parse("span => 'Hello World'");
        $this->assertInstanceOf('Tattoo\\Node\\Tag', $node);

        $this->assertEquals(1, count($node->children));

        $child = reset($node->children);

        $this->assertInstanceOf('Tattoo\\Node\\Text', $child);
        $this->assertInstanceOf('Tattoo\\Node\\Value', $child->getContent());
        $this->assertEquals('Hello World', $child->getContent()->getValue());
        $this->assertEquals('string', $child->getContent()->getType());
    }
}
