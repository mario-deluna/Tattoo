<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Value extends Node
{
	/**
     * Create a new array key with an value
     * 
     * @param mixed 			$value
     * @param strign 			$type
     * @return void
     */
    public function __construct($value = null, $type = null)
    {
    	$this->value = $value;
    	$this->type = $type;
    }

	/**
	 * The value type
	 *
	 * @var Node
	 */
	public $type = null;
	
	/**
	 * The value value >.>
	 *
	 * @var Node
	 */
	public $value = null;
}