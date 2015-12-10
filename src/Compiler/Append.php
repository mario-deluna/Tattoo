<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package           Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Compiler;

class Append extends Compiler
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
		return "\n" . trim($this->variableTagHolder() . '->children[] = ' . $this->compileChild($this->node->getNode())) . ';' . "\n";
    }
}
