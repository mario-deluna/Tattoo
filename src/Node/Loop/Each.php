<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node\Scope;

class Each extends Scope
{
	/**
	 * The tags name
	 *
	 * @var string
	 */
	protected $condition;
	
	/**
	 * The tags attributes
	 *
	 * @var array
	 */
	public $attributes = array();
}