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
 */

use Tattoo\Lexer;
use Tattoo\Parser;
use Tattoo\Parser\Scope;

class Parser_Dummy extends Parser
{
    protected function prepare()  {}

    protected function node() {}

    protected function next()  {}

    /**
     * Forward calls
     * This allows us to test protected methods on their own.
     * Probably not best practice but works..
     */
    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) 
        {
            return call_user_func_array(array($this, $method), $arguments);
        }
    }
}

class Parser_Test extends \PHPUnit_Framework_TestCase
{
    /**
     * Parse some tattoo code and return the nodes
     */
    protected function parse($code)
    {
        $class = substr(get_called_class(), strrpos(get_called_class(), "\\") + 1, -5);
        $class = "Tattoo\\" . str_replace('_', "\\", $class);

        $lexer = new Lexer($code);
        $parser = new $class($lexer->tokens());

        return $parser->parse();
    }

    /**
     * tests Parser
     */
    public function testConsturct()
    {
        $lexer = new Lexer('foo');
        $parser = new Scope($lexer->tokens());
        $this->assertInstanceOf('Tattoo\\Parser', $parser);
    }

    /**
     * parse attributes string and assert the results
     */
    protected function assertAttributesArray(array $expected, $code)
    {
    	$lexer = new Lexer($code);
        $parser = new Parser_Dummy($lexer->tokens());

        foreach($parser->parseAttributeTokens($parser->getTokens()) as $key => $values)
        {
        	$this->assertEquals($expected[$key], $values);
        }
    }

    /**
     * tests Parser
     */
    public function testAttributeTokens()
    {
    	// simple
    	$this->assertAttributesArray(array(
    		'id' => 'phpunit',
    		'class' => array('main', 'foo', 'bar')
    	), '#phpunit.main.foo.bar');

    	// one class
    	$this->assertAttributesArray(array(
    		'class' => array('container')
    	), '.container');

    	// multiple classes
    	$this->assertAttributesArray(array(
    		'class' => array('container', 'main-container')
    	), '.container.main-container');

    	// just id
    	$this->assertAttributesArray(array(
    		'id' => 'phpunit',
    	), '#phpunit');

    	// with spaces n shit
    	$this->assertAttributesArray(array(
    		'id' => 'phpunit',
    		'class' => array('main', 'foo', 'bar')
    	), ' #phpunit .main . foo.bar');

    	// id after class
    	$this->assertAttributesArray(array(
    		'id' => 'maninthemiddle',
    		'class' => array('main', 'foo', 'bar')
    	), '.main.foo#maninthemiddle.bar');
    }

}
