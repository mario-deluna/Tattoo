<?php namespace Tattoo\Compiler;

/**
 * Tattoo code compiler
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Compiler;
use Tattoo\Node\Text as TextNode;

class Variable extends Compiler
{
    /**
     * Compile the current node to text
     *
     * @return string
     */
    public function compile()
    {
    	$variable = $this->exportVariable($this->node->getName());

    	// check if auto escaping is enabled
    	if ($this->configuration['autoEscapeVariables'])
    	{
    		// we still don't know if we should escape this var so..
    		$escapeIsPossible = false;
    		
    		// now we cannot just always escape when a variable is 
    		// compiles so we have to check if the parent will output the
    		// current variable node
    		if ($this->node->getParent() && ( $this->node->getParent() instanceof TextNode ))
    		{
    			$escapeIsPossible = true;
    		}

    		// if the given node is an tag attribute we also 
    		// escape it.
    		elseif($this->node->getInheritProperty('tagAttribute') === true)
    		{
    			$escapeIsPossible = true;
    		}

    		// if escape is possible with the current var do it
    		if ($escapeIsPossible)
    		{
    			$variable = $this->configuration['defaultEscapeFunction'].'('.$variable.')';
    		}
    	}

        return $variable;
    }
}
