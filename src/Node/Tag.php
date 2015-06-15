<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Tag extends Scope
{
	/**
	 * The tags name
	 *
	 * @var string
	 */
	protected $name;
	
	/**
	 * The tags attributes
	 *
	 * @var array
	 */
	public $attributes = array();
}