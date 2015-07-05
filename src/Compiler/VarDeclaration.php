<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Compiler;

class VarDeclaration extends Compiler
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
        return $this->compileChild($this->node->getVariable()) . ' = ' . $this->compileChild($this->node->getValue()) . ';';
    }
}
