<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Engine\Tag as EngineTag;

class Tag extends Scope
{	
	/**
	 * Compile the current node to text
	 *
	 * @return string
	 */
	public function compile()
	{
		// if the contents are empty we can directly return the rendered tag
		if ( empty( $this->node->children ) )
		{
			$tag = new EngineTag( $this->node->name, $this->node->attributes );
			return $this->getScopeAssignPrefix() . $this->export( $tag->render() ).';';
		}
		
		return parent::compile();
	}
	
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
		$buffer .= $this->exportArray( $this->node->attributes ) . ", ";
		
		// add the callback
		$buffer .= "function( ".$this->variableTagHolder()." ) use( ".$this->variableVarHolder()." )\n";
		
		// add the content;
		$buffer .= "{\n".$content."\n});\n";
		
		return $buffer;
	}
}