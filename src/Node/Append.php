<?php namespace Tattoo\Node;

/**
 * Tattoo Appender node
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Append extends Node
{
	/**
	 * The to appending node
	 *
	 * @var Node
	 */
	protected $node = null;
}