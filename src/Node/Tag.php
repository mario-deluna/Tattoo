<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;
use Tattoo\Node\Arr;


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
	 * @var Arr
	 */
	protected $attributes = array();

	/**
	 * Set the tag attributes 
	 *
	 * @param Arr 			$attributes
	 * @return Arr
	 */
	protected function setAttributes(Arr $attributesArray)
	{
		// set a inherited property to the node tree
        // that allows us to identify that array as tag attributes
        $attributesArray->setInheritProperty('tagAttribute', true);

        // return the attributes
        return $attributesArray;
	}
}