<?php namespace Tattoo\Node\Arr;

/**
 * Tattoo array key
 **
 * @package         Tattoo
 * @copyright       2015 Mario Döring
 */

use Tattoo\Exception;
use Tattoo\Node\Value;

class AutoKey extends ArrKey
{
	/**
     * It should not be possible to set the value of an auto key
     * 
     * @param Tattoo\Node\Value 			$value
     */
    protected function setValue(Value $value)
    {
    	throw new Exception('Cannot set value of auto array key.');
    }
}
