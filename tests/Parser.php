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
}