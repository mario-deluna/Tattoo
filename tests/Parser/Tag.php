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
 * @group Tattoo_Parser_Tag
 */

class Parser_Tag_Test extends Parser_Test
{
    /**
     * tests Parser
     */
    public function testSimple()
    {
        $node = $this->parse("[span] => 'Hello World' {}");
        $this->assertInstanceOf('Tattoo\\Node\\Tag', $node);

        $this->assertEquals(1, count($node->children));

        $child = reset($node->children);

        $this->assertInstanceOf('Tattoo\\Node\\Text', $child);
        $this->assertInstanceOf('Tattoo\\Node\\Value', $child->getContent());
        $this->assertEquals('Hello World', $child->getContent()->getValue());
        $this->assertEquals('string', $child->getContent()->getType());
    }

    /**
     * tests Parser
     */
    public function testTagRecusion()
    {
        $node = $this->parse("[div][ul][li][a.phpunit]");

        $this->assertEquals('div', $node->getName());

        // go deeper to ul
        $children = $node->getChildren();
        $node = reset($children);

        $this->assertEquals('ul', $node->getName());

        // go deeper to li
        $children = $node->getChildren();
        $node = reset($children);

        $this->assertEquals('li', $node->getName());

        // go deeper to a
        $children = $node->getChildren();
        $node = reset($children);

        $this->assertEquals('a', $node->getName());
    }

    /**
     * tests Parser
     */
    public function testScopeContents()
    {
        $node = $this->parse("[div] { span => 'Hello' }");
    }
}
