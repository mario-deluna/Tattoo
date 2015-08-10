<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Concat extends Node
{
	/**
	 * The variable name
	 *
	 * @var array[Node]
	 */
	protected $nodes = array();

    /**
     * Adds a node to the current concat
     * 
     * @param string            $node
     * @return void
     */
    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }
}