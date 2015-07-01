<?php namespace Tattoo\Tests;

/**
 * Tattoo token test
 **
 *
 * @package             Tattoo
 * @copyright           Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Token
 */

use Tattoo\Token;

class Token_Test extends \PHPUnit_Framework_TestCase
{
    protected function createToken($type, $value)
    {
        return new Token(array($type, $value, 42));
    }

    /**
     * tests token
     */
    public function testConsturct()
    {
        $token = $this->createToken('null', 'nullvalue');

        $this->assertInstanceOf('Tattoo\\Token', $token);

        $this->assertEquals('null', $token->type);
        $this->assertEquals('nullvalue', $token->value);
        $this->assertEquals(42, $token->line);
    }

    /**
     * tests token
     * 
     * @expectedException Exception
     */
    public function testConsturctInvalidConstructArray()
    {
        $token = new Token(array('invalid'));
    }

    /**
     * Tests if a given token is a value type
     */
    public function testIsValue()
    {
        $this->assertTrue($this->createToken('null', 'nullvalue')->isValue());
        $this->assertTrue($this->createToken('boolTrue', 'yes')->isValue());
        $this->assertTrue($this->createToken('boolFalse', 'no')->isValue());
        $this->assertTrue($this->createToken('number', 123)->isValue());
        $this->assertTrue($this->createToken('string', '"foo"')->isValue());

        // nope
        $this->assertFalse($this->createToken('linebreak', '\n')->isValue());
        $this->assertFalse($this->createToken('loop', 'loop ')->isValue());
    }

    /**
     * Check if correct value is returned
     */
    public function testGetValueString()
    {
        $this->assertEquals('foo', $this->createToken('string', '"foo"')->getValue());
        $this->assertEquals('foo', $this->createToken('string', "'foo'")->getValue());
    }

    /**
     * Check if correct value is returned
     */
    public function testGetValueBool()
    {
        $this->assertTrue($this->createToken('boolTrue', 'yes')->getValue());
        $this->assertFalse($this->createToken('boolFalse', 'no')->getValue());
    }

    /**
     * Check if correct value is returned
     */
    public function testGetValueNumber()
    {
        $this->assertEquals(0, $this->createToken('number', '0')->getValue());
        $this->assertEquals(1, $this->createToken('number', '1')->getValue());
        $this->assertEquals(3.14, $this->createToken('number', '3.14')->getValue());
        $this->assertEquals(-42, $this->createToken('number', '-42')->getValue());
    }

    /**
     * Check if correct value is returned
     */
    public function testGetValueNull()
    {
        $this->assertEquals(null, $this->createToken('null', 'null')->getValue());
    }
}