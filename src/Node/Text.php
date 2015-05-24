<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Text extends Node
{
	/**
	 * The value type
	 *
	 * @var Node
	 */
	public $content = null;
	
	/**
	 * A text does have a parent but no children
	 *
	 * @var Node
	 */
	public $parent = null;
}