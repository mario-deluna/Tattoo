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
 * @group Tattoo_Parser_Array
 */

use Tattoo\Node\Arr as ArrNode;

class Parser_Arr_Test extends Parser_Test
{  
    /**
     * Asserts an tattoo array with a given array
     * 
     * @param array             $expected
     * @param string            $code 
     * @return void
     */
    protected function assertArrayValues(array $expected, $code)
    {
        $tattooArray = $this->convertTattooNodeWithArray($this->parse($code));
        $this->assertEquals($expected, $tattooArray);
    }
    
    /**
     * Compares a tattoo array node with an php array
     * 
     * @param array             $expected
     * @param ArrNode           $node
     * @return void
     */
    protected function convertTattooNodeWithArray(ArrNode $node)
    {
        $convertedArray = array();

        foreach($node->getItems() as $item)
        {
            list($key, $value) = $item;

            if ($value instanceof ArrNode)
            {
                $value = $this->convertTattooNodeWithArray($value);
            } else {
                $value = $value->getValue();
            }

            if (is_null($key = $key->getValue()))
            {
                $convertedArray[] = $value;
            } else {
                $convertedArray[$key->getValue()] = $value;
            }
        }

        return $convertedArray;
    }

    /**
     * tests Parser
     */
    public function testConstruct()
    {
        $this->assertInstanceOf('Tattoo\\Node\\Arr', $this->parse('"a", "b"'));
    }

    /**
     * tests Parser
     */
    public function testNormalArray()
    {
        $this->assertArrayValues(array('a', 'b'), '"a", "b"');
    }

    /**
     * tests Parser
     */
    public function testNumberArray()
    {
        $this->assertArrayValues(array(1,2,3), '1, 2 ,3');
    }

    /**
     * tests Parser
     */
    public function testNormalAssocArray()
    {
        $this->assertArrayValues(array('foo' => 'bar', 'bar' => 'foo'), 'foo: "bar", bar: "foo"');
    }

    /**
     * tests Parser
     */
    public function testMixedArray()
    {
        $this->assertArrayValues(array('bar', true, false, 'bar' => 'foo'), '"bar", yes, no, bar: "foo"');
    }

     /**
     * tests Parser
     */
    public function testMultipleDimensions()
    {
        $this->assertArrayValues(array(array('foo')), '{ "foo" }');

        // more more more
        $this->assertArrayValues(array(array('foo'), array('foo')), '{ "foo" }, { "foo" }');

        // more complexity
        $this->assertArrayValues(array(
            42,
            array('foo', 'bar', array('batz')),
            true
        ), '42, { "foo", "bar", { "batz" } }, yes');
    }
}
