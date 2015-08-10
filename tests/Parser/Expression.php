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
 * @group Tattoo_Parser_Expression
 */

class Parser_Expression_Test extends Parser_Test
{
    /**
     * tests Parser
     */
    public function testSingleValueString()
    {
        $node = $this->parse("'foo'");
        $this->assertInstanceOf('Tattoo\\Node\\Value', $node);
        $this->assertEquals('string', $node->getType());
        $this->assertEquals('foo', $node->getValue());
    }

    /**
     * tests Parser
     */
    public function testStringValueConcat()
    {
        $node = $this->parse("'foo' % '-' % 'bar'");
        $this->assertInstanceOf('Tattoo\\Node\\Concat', $node);

        $nodes = $node->getNodes();

        $this->assertCount(3, $nodes);

        foreach (array('foo', '-', 'bar') as $key => $value)
        {
            $this->assertEquals($value, $nodes[$key]->getValue());
        }
    }

    /**
     * tests Parser
     */
    public function testSingleValueNumber()
    {
        $node = $this->parse("123");
        $this->assertInstanceOf('Tattoo\\Node\\Value', $node);
        $this->assertEquals('number', $node->getType());
        $this->assertEquals('123', $node->getValue());
    }

    /**
     * tests Parser
     */
    public function testSingleValueBool()
    {
        $node = $this->parse("yes");
        $this->assertInstanceOf('Tattoo\\Node\\Value', $node);
        $this->assertEquals('boolTrue', $node->getType());
        $this->assertEquals(true, $node->getValue());
    }

    /**
     * tests Parser
     */
    public function testArray()
    {
        $node = $this->parse("{1, 2, 3}");
        $this->assertInstanceOf('Tattoo\\Node\\Arr', $node);
        $this->assertEquals(array(1,2,3), $node->convertToNative());
    }
}
