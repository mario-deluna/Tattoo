<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */


class Tag extends Scope
{	
	/**
	 * Wrap the plain scope contents
	 *
	 * @param string 			$content
	 * @return string
	 */
	protected function wrapScopeContents( $content )
	{	
		$buffer = "new Tattoo\Engine\Tag( '".$this->node->name."', ";
		
		// add the attributes
		$buffer .= $this->createArray( $this->node->attributes ) . ", ";
		
		// add the callback
		$buffer .= "function( ".$this->variableTagHolder()." ) use( ".$this->variableVarHolder()." )\n";
		
		// add the content;
		$buffer .= "{\n".$content."\n});\n";
		
		return $buffer;
	}
}