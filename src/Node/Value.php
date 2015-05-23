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
	public $type = null;
	
	/**
	 * The value value >.>
	 *
	 * @var Node
	 */
	public $value = null;
}