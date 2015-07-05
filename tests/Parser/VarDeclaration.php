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
 * @group Tattoo_Parser_VarDeclaration
 */

class Parser_VarDeclaration_Test extends Parser_Test
{
    /**
     * tests Parser
     */
    public function testSimple()
    {
        $node = $this->parse("@foo = 'bar'");
        $this->assertInstanceOf('Tattoo\\Node\\VarDeclaration', $node);

        // check if the variable
        $this->assertInstanceOf('Tattoo\\Node\\Variable', $node->getVariable());
        $this->assertEquals('foo', $node->getVariable()->getName());

        // and the value
        $this->assertEquals('string', $node->getValue()->getType());
        $this->assertEquals('bar', $node->getValue()->getValue());
    }

    /**
     * tests Parser
     * @expectedException Exception
     */
    public function testInvalidVariable()
    {
        $this->parse("'foo' = 'bar'");
    }
}
