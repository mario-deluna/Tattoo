<?php namespace Tattoo\Node\Arr;

/**
 * Tattoo array key
 **
 * @package         Tattoo
 * @copyright       2015 Mario Döring
 */

use Tattoo\Node;
use Tattoo\Node\Value;

class ArrKey extends Node
{
    /**
     * The value of the current array key
     *
     * @var Node
     */
    protected $value = null;

    /**
     * Set the value to only accept instance of type value
     * 
     * @param Tattoo\Node\Value 			$value
     */
    protected function setValue(Value $value)
    {
    	return $value;
    }
}
