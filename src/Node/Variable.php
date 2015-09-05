<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Variable extends Node implements ContextInterface
{   
    /**
     * A text does have a parent but no children
     *
     * @var Node
     */
    protected $parent = null;

	/**
	 * The variable name
	 *
	 * @var Node
	 */
	protected $name = null;

    /**
     * Variable node constructor
     * 
     * @param string                $name
     * @return void
     */
    public function __construct($name = null)
    {
        if (!is_null($name))
        {
            $this->name = $this->setName($name);
        }
    }

    /**
     * Update the context (parent)
     * 
     * @param Node              $context
     * @return void
     */
    public function setContext(Node $context)
    {
        $this->parent = $context;
    }

    /**
     * Set the curent name and remove @ prefix
     * 
     * @param string            $name
     * @return void
     */
    protected function setName($name)
    {
        if (substr($name, 0, 1) === '@')
        {
            $name = substr($name, 1);
        }
        
        return $name;
    }
}