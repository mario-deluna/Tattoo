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
	 * The value type
	 *
	 * @var Node
	 */
	protected $type = null;
	
	/**
	 * The value value >.>
	 *
	 * @var Node
	 */
	protected $value = null;

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
}