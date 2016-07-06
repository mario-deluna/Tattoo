<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Compiler;

class Accessor extends Compiler
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
    	return $this->export($this->node->getNode()) . '["' . $this->node->getKey()->getName() . '"]';
    }
}
