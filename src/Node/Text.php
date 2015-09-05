<?php namespace Tattoo\Node;

/**
 * Tattoo Parser
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Node;

class Text extends Node implements ContextInterface
{
	/**
	 * The value type
	 *
	 * @var Node
	 */
	protected $content = null;
	
	/**
	 * A text does have a parent but no children
	 *
	 * @var Node
	 */
	public $parent = null;

	/**
     * Create new text node with content node
     * 
     * @param Tattoo\Node 			$content
     */
    public function __construct(Node $content)
    {
    	$this->content = $this->setContent($content);
    }

    /**
     * Set the content hook
     * 
     * @param Node              $content
     * @return Node
     */
    protected function setContent(Node $content)
    {
        if (method_exists($content, 'setContext'))
        {            
            $content->setContext($this);
        }

        return $content;
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
}