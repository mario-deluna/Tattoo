<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Engine\Tag as EngineTag;

class Tag extends Scope
{
    /**
     * Wrap the plain scope contents
     *
     * @param string             $content
     * @return string
     */
    protected function wrapScopeContents($content)
    {
        $buffer = $this->getScopeAssignPrefix($this->node) . "new Tattoo\Engine\Tag('" . $this->node->getName() . "', ";

        // add the attributes
        $buffer .= $this->export($this->node->getAttributes()) . ", ";

        // add the content;
        if (is_null($content) || empty($content))
        {
            $buffer .= 'null';
        }
        else
        {
            // add the callback
            $buffer .= "function(" . $this->variableTagHolder() . ") use(" . $this->variableVarHolder() . ")\n";
            $buffer .= "{" . $content . "\n}"; 
        }

        // close the function
        $buffer .= ");\n";

        return $buffer;
    }
}
