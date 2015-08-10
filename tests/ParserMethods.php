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
 * @group Tattoo_Parser_Methods
 */

use Tattoo\Lexer;
use Tattoo\Parser;
use Tattoo\Parser\Scope;

class ParserMethods_Test extends \PHPUnit_Framework_TestCase
{
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
     * tests getTokensUntilClosingScope
     */
    public function testGetTokensUntilClosingScope()
    {
        $lexer = new Lexer("{ foo => 'bar' \n { next => 'level' } }");
        $parser = new Parser_Dummy($lexer->tokens());
        $this->assertEquals(9, count($parser->getTokensUntilClosingScope()));

        // also check of the parser is done
        $this->assertTrue($parser->parserIsDone());

        // include the scope
        $lexer = new Lexer("{ foo => 'bar' \n { next => 'level' } } '123'");
        $parser = new Parser_Dummy($lexer->tokens());
        $this->assertEquals(11, count($parser->getTokensUntilClosingScope(true)));

        // parser should not be done
        $this->assertFalse($parser->parserIsDone());

        // validate the current token
        $this->assertEquals('123', $parser->currentToken()->getValue());
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
    public function testClassAndIDAttributeTokens()
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

    /**
     * tests Parser
     */
    public function testOtherAttribtes()
    {
        // simple
        $this->assertAttributesArray(array('src' => 'img/logo.png'), 'src: "img/logo.png"');

        // multiple
        $this->assertAttributesArray(array('src' => 'img/logo.png', 'title' => 'Foo'), 'src: "img/logo.png", title: "Foo"');

        // with id
        $this->assertAttributesArray(array(
            'id' => 'main',
            'src' => 'img/logo.png', 
            'title' => 'Bar'
        ), '#main, src: "img/logo.png", title: "Bar"');

        // with id and class 
        $this->assertAttributesArray(array(
            'id' => 'main',
            'class' => array('image'),
            'src' => 'img/logo.png', 
            'title' => 'Bar'
        ), '.image #main, src: "img/logo.png", title: "Bar"');
    }

    /**
     * tests Parser
     */
    public function testClassSpecialCase()
    {
        $this->assertAttributesArray(array(
            'id' => 'main',
            'class' => array('container', 'white-box', 'bordered'),
        ), '#main.container, class: "white-box bordered"');

        $this->assertAttributesArray(array(
            'id' => 'main',
            'class' => array('container', 'strong', 'uppercase'),
        ), '#main.container, class: {"strong", "uppercase"}');
    }

    /**
     * tests Parser
	 * 
	 * @expectedException Exception
     */
    public function testAttributeTokensDoubleId()
    {
    	$this->assertAttributesArray(array(), '#phpunit.main.foo.bar#fooid');
    }

    /**
     * tests Parser
	 * 
	 * @expectedException Exception
     */
    public function testAttributeTokensInvalid()
    {
    	$this->assertAttributesArray(array(), '#phpunit.main.foo..ba');
    }
}

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