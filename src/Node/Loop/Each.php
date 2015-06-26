<?php namespace Tattoo\Node\Loop;

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
	 * The loops key variable to be assigned
	 *
	 * @var string
	 */
	protected $keyVariable;

	/**
	 * The loops value variable to be assigned
	 *
	 * @var string
	 */
	protected $valueVariable;
	
	/**
	 * The collection that gets looped through
	 *
	 * @var string
	 */
	protected $collection;
}