<?php namespace Tattoo;

/**
 * Tattoo code compiler
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

abstract class Compiler
{
	/**
	 * The current node to be compiled
	 *
	 * @var Node
	 */
	protected $node = null;
	
	/**
	 * Construct a compiler with the given node
	 *
	 * @param array 				$nodes
	 * @return void
	 */
	public function __construct( Node $node )
	{
		$this->node = $node;
	}
	
	/**
	 * Compile the current node to text
	 *
	 * @return string
	 */
	abstract public function compile();
	
	/**
	 * Variablfy a name
	 * 
	 * @param string 				$name
	 * @return string
	 */
	protected function variable( $name )
	{
		return '$' . str_replace( '-', '_', $name );
	}
	
	/**
	 * Tag holder variable
	 * 
	 * @param string 				$name
	 * @return string
	 */
	protected function variableTagHolder()
	{
		return $this->variable( '__tattoo_tag' );
	}
	
	/**
	 * Variable holder variable
	 * 
	 * @param string 				$name
	 * @return string
	 */
	protected function variableVarHolder()
	{
		return $this->variable( '__tattoo_vars' );
	}
	
	/**
	 * Build php array string
	 *
	 * @return string
	 */
	protected function createArray( $array )
	{
		return str_replace( 'array (', 'array(', var_export( $array, true ) );
	}
}