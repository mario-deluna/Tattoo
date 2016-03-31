<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Compiler;

class Accessor extends Compiler
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
        var_dump($this->node); die;

    	$buffer = '';

    	foreach($this->node->getNodes() as $node)
    	{
    		$buffer .= $this->export($node) . ' . ';
    	}

    	return substr($buffer, 0, -3);
    }
}
