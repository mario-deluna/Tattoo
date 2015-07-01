<?php namespace Tattoo\Tests;
/**
 * Tattoo Lexer test
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Lexer
 */

use Tattoo\Lexer;

class Lexer_Test extends \PHPUnit_Framework_TestCase
{		
	/**
	 * Asserts an string of code to an array of expected tokens
	 *
	 * @param string 			$code
	 * @param array 			$tokens
	 * @return void
	 */
	protected function assertTokenTypes( $code, array $tokenTypes )
	{
		$lexer = new Lexer( $code );
		
		$tokens = array_filter( $lexer->tokens(), function( $token ) 
		{
			return !( $token->type === 'whitespace' || $token->type === 'linebreak' );
		});
		
		foreach( array_values( $tokens ) as $key => $token )
		{	
			if ( !isset( $tokenTypes[$key] ) )
			{
				throw new Exception('Invalid number of tokens missing for: '.$token->value );
			}
			
			$this->assertEquals( $tokenTypes[$key], $token->type );
		}
	}
	
	/**
	 * tests Lexer
	 */
	public function testConsturct()
	{	
		$lexer = new Lexer( 'foo' );
		
		$this->assertInstanceOf( 'Tattoo\\Lexer', $lexer );
		$this->assertEquals( 3, $lexer->length() );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenString()
	{	
		// string
		$this->assertTokenTypes( '"hello world"', array( 'string' ) );
		
		// string singlequotes
		$this->assertTokenTypes( "'hello world'", array( 'string' ) );
		
		// string singlequotes escaped
		$this->assertTokenTypes( "'hello \'world'", array( 'string' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenNumber()
	{	
		// int
		$this->assertTokenTypes( '124', array( 'number' ) );
		
		// float
		$this->assertTokenTypes( '12.31231', array( 'number' ) );
		
		// float in string
		$this->assertTokenTypes( "'12.31'", array( 'string' ) );
		
		// 10 made me an error earlier
		$this->assertTokenTypes( "10", array( 'number' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenBool()
	{	
		$this->assertTokenTypes( 'yes no', array( 'boolTrue', 'boolFalse' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenNull()
	{	
		$this->assertTokenTypes( 'null @null', array( 'null', 'variable' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenVariables()
	{	
		$this->assertTokenTypes( '@foo = @bar', array( 'variable', 'equal', 'variable' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenComments()
	{	
		$this->assertTokenTypes( '// fo bar bat doesnt matter', array( 'comment' ) );
		
		// with break
		$this->assertTokenTypes( "// this is a comment\n@thisNot", array( 'comment', 'variable' ) );
		
		// comment after something
		$this->assertTokenTypes( "@foo // nope", array( 'variable', 'comment' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenAssignText()
	{	
		$this->assertTokenTypes( 'span => "Hi"', array( 'identifier', 'assignText', 'string' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenEquals()
	{	
		$this->assertTokenTypes( '@active = yes', array( 'variable', 'equal', 'boolTrue' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenIf()
	{	
		$this->assertTokenTypes( 'if @active {} elseif @hover {} else {}', array( 
			'if', 
			'variable',
			'scopeOpen',
			'scopeClose',
			'elseif',
			'variable',
			'scopeOpen',
			'scopeClose',
			'else',
			'scopeOpen',
			'scopeClose',
		));
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenEach()
	{	
		$this->assertTokenTypes( 'each @post in @posts', array( 
			'foreach', 
			'variable', 
			'in', 
			'variable' 
		));
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenLoop()
	{	
		$this->assertTokenTypes( 'loop 10', array( 'loop', 'number' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenConcat()
	{	
		$this->assertTokenTypes( '@foo % " - foo"', array( 'variable', 'concat', 'string' ) );
	}
	
	/**
	 * tests Lexer
	 */
	public function testTokenExtend()
	{	
		$this->assertTokenTypes( 
		'extend input 
		{ 
			@this.class.add( "foo" ) 
		}', 
		array( 
			'extend', 
			'identifier',
			'scopeOpen',
			'variable',
			'accessor',
			'identifier',
			'accessor',
			'identifier',
			'braceOpen',
			'string',
			'braceClose',
			'scopeClose',
		));
	}
	
	/**
	 * tests Lexer
	 */
	public function testArray()
	{	
		$this->assertTokenTypes( '@myArray = { foo: "bar", @nope: @jop }', array( 
			'variable', 
			'equal',
			'scopeOpen',
			'identifier',
			'assign',
			'string',
			'comma',
			'variable',
			'assign',
			'variable',
			'scopeClose'
		));
	}
	
	/**
	 * tests Lexer
	 */
	public function testTag()
	{	
		$this->assertTokenTypes( '[a .foo, #bar, href: "/notes/save/"]', array( 
			'tagOpen',
			'identifier',
			'accessor',
			'identifier',
			'comma',
			'anchor',
			'identifier',
			'comma',
			'identifier',
			'assign',
			'string',
			'tagClose',
		));
	}

	/**
	 * tests Lexer
	 */
	public function testDoublicatedLinebreaks()
	{
		$lexer = new Lexer( "yes\n\n\nno" );
		$this->assertEquals(3, count($lexer->tokens()));
	}

	/**
	 * tests Lexer error
	 *
	 * @expectedException \Tattoo\Lexer\Exception
	 */
	public function test_unknownToken()
	{	
		$lexer = new Lexer( "*" ); $lexer->tokens();
	}
}