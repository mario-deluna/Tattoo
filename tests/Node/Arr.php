<?php namespace Tattoo\Tests;

/**
 * Tattoo Node test
 **
 *
 * @package         Tattoo
 * @copyright         Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Node
 * @group Tattoo_Node_Array
 */

use Tattoo\Node\Arr as ArrNode;
use Tattoo\Node\Arr\AssocKey;
use Tattoo\Node\Arr\AutoKey;

use Tattoo\Node\Value as ValueNode;

class Node_Arr_Test extends \PHPUnit_Framework_TestCase
{  
    /**
     * Asserts an tattoo array with a given array
     * 
     * @param array             $expected
     * @param string            $code 
     * @return void
     */
    protected function assertArrayValues(array $expected, ArrNode $array)
    {  
        $this->assertEquals($expected, $array->convertToNative());
    }

    /**
     * tests Node
     */
    public function testConstruct()
    {
        $this->assertInstanceOf('Tattoo\\Node\\Arr', new ArrNode);
    }

    /**
     * Test array has
     */
    public function testHas()
    {
        $array = new ArrNode;

        $this->assertFalse($array->has(0));
        $this->assertFalse($array->has(1));
        $this->assertFalse($array->has('foo'));

        // now add the keys
        $array->addItem(new AutoKey, new ValueNode('yeah'));
        $this->assertTrue($array->has(0));

        // add another one
        $array->addItem(new AutoKey, new ValueNode('Whooo'));
        $this->assertTrue($array->has(1));

        // test has with sting key
        $array->addItem(new AssocKey(new ValueNode('foo')), new ValueNode('Whooo'));
        $this->assertTrue($array->has('foo'));
    }

    /**
     * tests Node
     */
    public function testAddItem()
    {
        $array = new ArrNode;

        // add single auto key item
        $array->addItem(new AutoKey, new ValueNode('foo', 'string'));
        $this->assertArrayValues(array('foo'), $array);

        // add an assoc item
        $array->addItem(new AssocKey(new ValueNode('bar', 'string')), new ValueNode('foo', 'string'));
        $this->assertArrayValues(array('foo', 'bar' => 'foo'), $array);

        // now check if the pointer increses
        $array->addItem(new AutoKey, new ValueNode('yeah', 'string'));
        $this->assertArrayValues(array('foo', 'bar' => 'foo', 'yeah'), $array);
    }
}
