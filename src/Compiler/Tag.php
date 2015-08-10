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
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
        // if the contents are empty we can directly return the rendered tag
        if (empty($this->node->children)) 
        {
            $tag = new EngineTag($this->node->getName(), $this->node->getAttributes());
            return $this->getScopeAssignPrefix($this->node) . $this->export($tag->render()) . ';';
        }

        return parent::compile();
    }

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
        $buffer .= $this->export($this->node->attributes) . ", ";

        // add the callback
        $buffer .= "function(" . $this->variableTagHolder() . ") use(" . $this->variableVarHolder() . ")\n";

        // add the content;
        $buffer .= "{" . $content . "\n});\n";

        return $buffer;
    }
}
