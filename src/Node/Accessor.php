<?php namespace Tattoo\Node;

/**
 * Tattoo Appender node
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Accessor extends Node
{
	/**
	 * The node that is being accessed 
	 *
	 * @var Node
	 */
	protected $node = null;

	/**
	 * The key being used to access node
	 * 
	 * @var Node
	 */
	protected $key = null;
}