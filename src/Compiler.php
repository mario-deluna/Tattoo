<?php namespace Tattoo;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Scope as ScopeNode;
use Tattoo\Node\Tag as TagNode;

abstract class Compiler
{
    /**
     * The current node to be compiled
     *
     * @var Node
     */
    protected $node = null;

    /**
     * Construct a compiler with the given node
     *
     * @param array                 $nodes
     * @return void
     */
    public function __construct(Node $node)
    {
        $this->node = $node;
    }

    /**
     * Compile the current node to text
     *
     * @return string
     */
    abstract public function compile();

    /**
     * Compiles a child node based on it's class
     *
     * @param Node                 $node
     * @return string
     */
    protected function compileChild(Node $child)
    {
        // the compiler class equals the node just with a diffrent namespace
        $compilerClass = str_replace("\\Node\\", "\\Compiler\\", get_class($child));

        $compiler = new $compilerClass($child);

        return $compiler->compile();
    }

    /**
     * Append to scope contents or output?
     *
     * @return string
     */
    protected function getScopeAssignPrefix($node)
    {
        if (is_null($node->parent) || ($node->parent instanceof ScopeNode && (!$node->parent instanceof TagNode))) 
        {
            return "\necho ";
        }

        return "\n" . $this->variableTagHolder() . "->content .= ";
    }

    /**
     * Variablfy a name
     *
     * @param string                 $name
     * @return string
     */
    protected function variable($name)
    {
        return '$' . str_replace('-', '_', $name);
    }

    /**
     * Tag holder variable
     *
     * @param string                 $name
     * @return string
     */
    protected function variableTagHolder()
    {
        return $this->variable('__tattoo_tag');
    }

    /**
     * Variable holder variable
     *
     * @param string                 $name
     * @return string
     */
    protected function variableVarHolder()
    {
        return $this->variable('__tattoo_vars');
    }

    /**
     * Exports a tattoo variable
     * 
     * @param string            $variable
     * @return string
     */
    protected function exportVariable($variable)
    {
        return $this->variableVarHolder() . '[' . $this->export($variable) . ']';
    }

    /**
     * Exports an expression to php code
     *
     * @param mixed             $var
     * @return string
     */
    protected function export($var)
    {
        return var_export($var, true);
    }

    /**
     * Build php array string
     *
     * @return string
     */
    protected function exportArray($array)
    {
        return str_replace('array (', 'array(', $this->export($array));
    }
}
