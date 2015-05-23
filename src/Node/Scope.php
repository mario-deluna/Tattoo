<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Scope extends Node
{
	/**
	 * The scopes parent scope
	 *
	 * @var Node
	 */
	public $parent = null;
	
	/**
	 * The scopes children nodes
	 *
	 * @var array[Node]
	 */
	public $children = array();
	
	/**
	 * Add a new child node to the scope
	 *
	 * @param Node 			$node
	 * @return void
	 */
	public function addChild( Node $node )
	{
		if ( property_exists($node, 'parent') )
		{
			$node->parent = $this;
		}
		
		$this->children[] = $node;
	}
}