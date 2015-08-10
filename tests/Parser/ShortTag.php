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

    /**
     * tests Parser
     */
    public function testWithAttributes()
    {
        $node = $this->parse("img src: 'foo.png'");
        $this->assertEquals(array('src' => 'foo.png'), $node->getAttributes());
    }

    /**
     * tests Parser
     */
    public function testWithArrayAttributes()
    {
        $node = $this->parse("img class: {'foo', 'bar'}");
        $this->assertEquals(array('class' => array('foo', 'bar')), $node->getAttributes());
    }

    /**
     * tests Parser
     */
    public function testWithSpecialAttributes()
    {
        $node = $this->parse("span #foo .bar => 'Hello World'");
        $this->assertEquals(array('id' => 'foo', 'class' => array('bar')), $node->getAttributes());
    }

    /**
     * tests Parser
     */
    public function testWithAttributeMerging()
    {
        $node = $this->parse("img .yeah, class: {'foo', 'bar'}");
        $this->assertEquals(array('class' => array('yeah', 'foo', 'bar')), $node->getAttributes());
    }

    /**
     * tests Parser
     */
    public function testWithAssignText()
    {
        $children = $this->parse("span => 'Test'")->getChildren();
        
        $text = reset($children);

        $this->assertEquals('Test', $text->getContent()->getValue());
    }

    /**
     * tests Parser
     */
    public function testWithAssignTextConcat()
    {
        $children = $this->parse("span => 'Foo' % ' - ' % 'Bar'")->getChildren();
        
        $concat = reset($children);

        $this->assertCount(3, $concat->getContent()->getNodes());
    }

    /**
     * tests Parser
     */
    public function testWithAssignTextVar()
    {
        $children = $this->parse("span => @text")->getChildren();
        
        $text = reset($children);

        $this->assertEquals('text', $text->getContent()->getName());
    }
}
