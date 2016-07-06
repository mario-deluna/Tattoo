<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package         	Tattoo
 * @copyright       	2015 Mario Döring
 */

use Tattoo\Compiler;
use Tattoo\Node;

class Scope extends Compiler
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
        return $this->wrapScopeContents($this->compileChildren());
    }

    /**
     * Compile the scopes children
     * 
     * @return string
     */
    protected function compileChildren()
    {
        $buffer = '';

        foreach ($this->node->children as $child) 
        {
            $buffer .= $this->compileChild($child);
        }

        return $buffer;
    }

    /**
     * Wrap the plain scope contents
     *
     * @param string             $content
     * @return string
     */
    protected function wrapScopeContents($content)
    {
        if (is_null($this->node->parent))
        {
            $buffer = "if (!isset(" . $this->variableVarHolder() . ")) {\n\t";
            $buffer .= $this->variableVarHolder() . ' = ' . $this->export(array()) . ";\n}\n";
            $buffer .= "echo new Tattoo\Engine\Scope(";
        }
        else
        {
            $buffer = "new Tattoo\Engine\Scope(";
        }

        // add the content;
        if (is_null($content) || empty($content))
        {
            $buffer .= 'null';
        }
        else
        {
            // add the callback
            $buffer .= "function(" . $this->variableTagHolder() . ") use(" . $this->variableVarHolder() . ")\n";
            $buffer .= "{\n" . $content . "\n}"; 
        }

        // close the function
        $buffer .= ");\n";

        return $buffer;
    }

}
