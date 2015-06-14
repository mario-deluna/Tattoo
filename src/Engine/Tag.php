<?php namespace Tattoo\Engine;

/**
 * Tattoo tag
 * This class is used to render a tag because this happens a lot
 * it should be kept as simple as freaking possible.
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

class Tag
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
     * The tags content
     *
     * @var string
     */
    public $content = '';

    /**
     * Construct a new tag
     *
     * @param string                 $name
     * @param array                 $attributes
     * @param callable                $content
     *
     * @return void
     */
    public function __construct($name, $attributes, $content = null)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->content = $content;
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
     * Render the tag as html
     *
     * @return string
     */
    public function render()
    {
        if (is_callable($this->content)) 
        {
            $contentRequest = $this->content;
            $this->content = '';
            call_user_func_array($contentRequest, array(&$this));
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

        if (empty($this->content)) 
        {
            return '<' . $this->name . $attributeString . " />";
        }

        return "<" . $this->name . $attributeString . ">" . $this->content . "</" . $this->name . ">";
    }
}
