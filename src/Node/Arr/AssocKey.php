<?php namespace Tattoo\Node\Arr;

/**
 * Tattoo array key
 **
 * @package         Tattoo
 * @copyright       2015 Mario Döring
 */

use Tattoo\Node\Value;

class AssocKey extends ArrKey
{
	/**
     * Create a new array key with an value
     * 
     * @param Tattoo\Node\Value 			$value
     */
    public function __construct(Value $value)
    {
    	$this->value = $value;
    }
}
