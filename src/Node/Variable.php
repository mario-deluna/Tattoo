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
    	$this->name = $this->setName($name);
    }

    /**
     * Set the curent name and remove @ prefix
     * 
     * @param string            $name
     * @return void
     */
    protected function setName($name)
    {
        if (substr($name, 0, 1) === '@')
        {
            $name = substr($name, 1);
        }
        
        return $name;
    }
}