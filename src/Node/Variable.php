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