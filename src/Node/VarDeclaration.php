<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class VarDeclaration extends Node
{
	/**
	 * The variable to be declared
	 *
	 * @var string
	 */
	protected $variable;

	/**
	 * The assigned value or expression
	 *
	 * @var string
	 */
	protected $value;
}