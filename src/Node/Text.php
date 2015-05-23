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
}