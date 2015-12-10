<?php namespace Tattoo\Engine;

/**
 * Tattoo tag
 * This class is used to render a tag because this happens a lot
 * it should be kept as simple as freaking possible.
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

class Tag extends Scope
{
    /**
     * The tags name
     *
     * @var string
     */
    public $name = '';

    /**
     * The tag attributes
     *
     * @var string
     */
    public $attributes = array();

    /**
     * The scope callback to generate the children
     * 
     * @param callable
     */
    public $scope = null;

    /**
     * Construct a new tag
     *
     * @param string                 $name
     * @param array                  $attributes
     * @param callable               $scope
     *
     * @return void
     */
    public function __construct($name, $attributes, $scope = null)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->scope = $scope;
    }

    /**
     * Render the tag as html
     *
     * @return string
     */
    public function render()
    {
        $this->execute();
        
        if (empty($this->children))
        {
            $content = null;
        }
        else
        {
            $content = parent::render();
        }

        $attributes = $this->attributes;

        // compile the class attributes
        if (isset($attributes['class'])) 
        {
            $attributes['class'] = implode(' ', $attributes['class']);
        }

        // also the data attributes need special handling
        if (isset($attributes['data'])) 
        {
            foreach ($attributes['data'] as $key => $value) 
            {
                $attributes['data-' . $key] = $value;
            }

            unset($attributes['data']);
        }

        $attributeString = '';
        foreach ($attributes as $key => $value) 
        {
            $attributeString .= ' ' . $key . '="' . $value . '"';
        }

        if (is_null($content)) 
        {
            return '<' . $this->name . $attributeString . " />";
        }

        return "<" . $this->name . $attributeString . ">" . $content . "</" . $this->name . ">";
    }
}
