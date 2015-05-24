<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Compiler;

class Scope extends Compiler
{	
	/**
	 * Compile the current node to text
	 *
	 * @return string
	 */
	public function compile()
	{
		$buffer = '';
		
		foreach( $this->node->children as $child )
		{			
			// the compiler class equals the node just with a diffrent namespace
			$compilerClass = str_replace( "\\Node\\", "\\Compiler\\", get_class( $child ) );
			
			$compiler = new $compilerClass( $child );
			
			$buffer .= $compiler->compile();
		}
		
		return $this->wrapScopeContents( $buffer );
	}
	
	/**
	 * Wrap the plain scope contents
	 *
	 * @param string 			$content
	 * @return string
	 */
	protected function wrapScopeContents( $content )
	{	
		$buffer = "if ( !isset( ".$this->variableVarHolder()." ) ) {\n\t";
		
		$buffer .= $this->variableVarHolder() .' = ' .$this->exportArray(array()). ";\n}\n";
		
		return $buffer . $content;
	}
}