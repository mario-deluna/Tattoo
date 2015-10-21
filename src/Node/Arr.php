<?php namespace Tattoo\Node;

/**
 * Tattoo Arr Node
 * 
 * Working with the tattoo array node is in no way performance
 * optimized, but that does not matter because it's compiled.
 * I just needed some tools to be able to modify the tattoo arrays
 * without compiling them to php.
 **
 * @package         Tattoo
 * @copyright       2015 Mario Döring
 */

use Tattoo\Node;
use Tattoo\Node\Value as ValueNode;

use Tattoo\Node\Arr\ArrKey;
use Tattoo\Node\Arr\AutoKey;

class Arr extends Node
{
    /**
     * The array items
     *
     * @var array[ArrKey => Node]
     */
    protected $items = array();

    /**
     * Current array pointer
     * Well not a real point but gets the job done..
     *
     * @var int
     */
    protected $pointer = 0;

    /**
     * Get the current pointer position
     * 
     * @return int
     */
    public function pointer()
    {
        return $this->pointer;
    }

    /**
     * Add a new child node to the scope
     *
     * @param Node             $node
     * @return void
     */
    public function addItem(ArrKey $key, Node $node)
    {
        if ($key instanceof AutoKey)
        {
            while($this->has($this->pointer))
            {
                $this->pointer++;
            }

            $key->setValue(new ValueNode($this->pointer, 'number'));
        }

        $this->items[] = array($key, $node);
    }

    /**
     * Check if an array item with the given key exists
     *
     * @param mixed             $key
     * @return bool
     */
    public function has($checkedKey)
    {
        foreach($this->items as list($key, $value))
        {
            if ($key->getValue()->getValue() === $checkedKey)
            {
                return true;
            }
        }

        return false;
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
            } elseif ($value instanceof Value) {
                $value = $value->getValue();
            } else {
                $value = $value;
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
