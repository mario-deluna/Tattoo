<?php namespace Tattoo\Node\Arr;

/**
 * Tattoo array key
 **
 * @package         Tattoo
 * @copyright       2015 Mario Döring
 */

use Tattoo\Node;

class ArrKey extends Node
{
    /**
     * The value of the current array key
     *
     * @var Node
     */
    public $value = null;
}
