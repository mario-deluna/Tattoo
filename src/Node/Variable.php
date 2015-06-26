<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Variable extends Node
{
	/**
	 * The variable name
	 *
	 * @var Node
	 */
	protected $name = null;

	/**
     * Create a new variable node with given name
     * 
     * @param string			$name
     */
    public function __construct($name)
    {
    	$this->name = $name;
    }
}