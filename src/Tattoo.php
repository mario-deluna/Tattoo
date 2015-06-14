<?php namespace Tattoo;

/**
 * Tattoo main interface
 **
 * @package         	Tattoo
 * @copyright       	2015 Mario Döring
 */

use Tattoo\Compiler\Scope as ScopeCompiler;
use Tattoo\Parser\Scope as ScopeParser;

class Tattoo
{
    /**
     * Parse tattoo code
     *
     * @throws Tattoo\Exception
     *
     * @param string            $code
     * @return array
     */
    public static function parse($code)
    {
        $lexer = new Lexer($code);
        $parser = new ScopeParser($lexer->tokens());

        return $parser->parse();
    }

    /**
     * Compile tattoo code to php
     *
     * @throws Tattoo\Exception
     *
     * @param string            $code
     * @return array
     */
    public static function compile($code)
    {
        $compiler = new ScopeCompiler(static::parse($code));

        return $compiler->compile();
    }
}
