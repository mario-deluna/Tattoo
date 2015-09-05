<?php namespace Tattoo;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Scope as ScopeNode;
use Tattoo\Node\Tag as TagNode;
use Tattoo\Node;

abstract class Compiler
{
    /**
     * The current node to be compiled
     *
     * @var Node
     */
    protected $node = null;

    /**
     * Tattoo engine configuration holder
     *
     * @var array
     */ 
    protected $configuration = array();

    /**
     * Construct a compiler with the given node
     *
     * @param array                 $nodes
     * @return void
     */
    public function __construct(Node $node, array $configuration = array())
    {
        $this->node = $node;
        $this->configuration = $configuration;
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

        $compiler = new $compilerClass($child, $this->configuration);

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
        // compile the variable if its a node
        if (is_object($var) && $var instanceof Node)
        {
            return $this->compileChild($var);
        }

        // when its a primitive we can export directly
        if (is_bool($var) || is_numeric($var) || is_string($var) || is_null($var))
        {
            return var_export($var, true);
        }

        // if an array export every item on its own
        if (is_array($var))
        {
            $buffer = 'array(';

            if (empty($var))
            {
                return $buffer .= ')';
            }

            foreach($var as $key => $subVar)
            {
                $buffer .= $this->export($key) . ' => ' . $this->export($subVar) . ', ';
            }

            return substr($buffer, 0, -2) . ')';
        }

        throw new Exception('Cannot export value of type: ' . gettype($var));
    }
}
