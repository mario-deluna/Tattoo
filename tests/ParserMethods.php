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