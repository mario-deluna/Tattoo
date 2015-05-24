<?php namespace Tattoo\Tests;
/**
 * Tattoo Parser test
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Compiler
 */

use Tattoo\Node;
use Tattoo\Compiler\Scope;

class Compiler_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Parse some tattoo code and return the nodes
	 */
	protected function compile( Node $node )
	{
		$class = substr( get_called_class(), strrpos( get_called_class(), "\\" )+1, -5 );
		$class = "Tattoo\\".str_replace('_', "\\", $class);
		
		$compiler = new $class( $node );
		return trim( $compiler->compile() );
	}
	
	/**
	 * The holder of the string samples
	 *
	 * @var array[string]
	 */
	protected $_samples = null;
	
	/**
	 * Assert a compiled string with a sample by key
	 *
	 * @param string 			$sampleKey
	 * @param string 			$compiledString
	 * @return void 
	 */
	protected function assertWithSampleFile( $sampleKey, $compiledString )
	{
		if ( is_null( $this->_samples ) )
		{
			$samples = explode( '@--- ', file_get_contents( __DIR__ . '/samples/compiler.tt' ) );
			
			foreach( $samples as $string )
			{
				$key = trim( substr($string, 0, strpos($string, "\n")) );
				$this->_samples[$key] = trim( substr( $string, strpos($string, "\n") ) );
			}
			
			$this->_samples = array_filter( $this->_samples );
		}
		
		$this->assertEquals( $this->_samples[$sampleKey], $compiledString );
	}

	/**
	 * tests Parser
	 */
	public function testConsturct()
	{	
		$compiler = new Scope( new Node );
		$this->assertInstanceOf( 'Tattoo\\Compiler\\Scope', $compiler );
	}
}