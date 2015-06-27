<?php namespace Tattoo\Compiler\Loop;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Compiler\Scope;

class Each extends Scope
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
        $buffer = 'foreach (' . $this->compileChild($this->node->getCollection()) . ' as ';

        // if we have a key 
        if ( $keyVar = $this->node->getKeyVariable() )
        {
            $buffer .= $this->compileChild($keyVar) . ' => ';
        }

        // and the value variable
        $buffer .= $this->compileChild($this->node->getValueVariable()) . ") {\n";
    
        // compile child scope
        $buffer .= parent::compile();

        // close the loop scope
        $buffer .= "\n}";

        return $buffer;
    }
}
