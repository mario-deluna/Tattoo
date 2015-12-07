<?php namespace Tattoo\Engine;

/**
 * Tattoo tag
 * This class is used to render a tag because this happens a lot
 * it should be kept as simple as freaking possible.
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

class Scope
{
    /**
     * The tags content
     *
     * @var string
     */
    public $children = array();

    /**
     * The scope callback to generate the children
     * 
     * @param callable
     */
    public $scope = null;

    /**
     * Construct a new tag
     *
     * @param callable               $scope
     *
     * @return void
     */
    public function __construct($scope = null)
    {
        $this->scope = $scope;
    }

    /**
     * To string magic forward render call
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Execute the node scope
     *
     * @return void
     */
    public function execute()
    {
        if (!is_null($this->scope))
        {
            // run the scope 
            call_user_func_array($this->scope, array(&$this));

            // and reset it to prevent double execution
            $this->scope = null;
        }
    }

    /**
     * Render the tag as html
     *
     * @return string
     */
    public function render()
    {
        $this->execute();

        $buffer = "";

        foreach($this->children as $child)
        {
            $buffer .= $child;
        }

        return $buffer;
    }
}
