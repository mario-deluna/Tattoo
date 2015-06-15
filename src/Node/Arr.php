<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright       2015 Mario Döring
 */

use Tattoo\Node;

class Arr extends Node
{
    /**
     * The scopes children nodes
     *
     * @var array[Node]
     */
    protected $items = array();

    /**
     * Add a new child node to the scope
     *
     * @param Node             $node
     * @return void
     */
    public function addItem($key, Node $node)
    {
        $this->items[] = array($key, $node);
    }

    /**
     * Converts the current array to a native php one
     * 
     * @return array
     */
    public function convertToNative()
    {
        $convertedArray = array();

        foreach($this->items as $item)
        {
            list($key, $value) = $item;

            if ($value instanceof Arr)
            {
                $value = $value->convertToNative();
            } else {
                $value = $value->getValue();
            }

            if (is_null($key = $key->getValue()))
            {
                $convertedArray[] = $value;
            } else {
                $convertedArray[$key->getValue()] = $value;
            }
        }

        return $convertedArray;
    }
}
