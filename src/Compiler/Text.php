<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Compiler;

class Text extends Compiler
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
		if ($this->node->getContent()) 
        {
            return $this->compileChild($this->node->getContent()) . "\n";
        }
    }
}
