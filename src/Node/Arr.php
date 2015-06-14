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
    public $items = array();

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
}
