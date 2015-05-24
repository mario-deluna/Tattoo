<?php namespace Tattoo;

/**
 * Tattoo main interface
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */
class Tattoo
{	
	/**
	 * Parse tattoo code
	 *
	 * @throws Tattoo\Exception
	 *
	 * @param string			$code
	 * @return array
	 */
	public static function parse( $code )
	{
		$lexer = new Lexer( $code );
		$parser = new Parser( $lexer->tokens() );
		
		return $parser->parse();
	}
}