<?php namespace Tattoo\Node;

/**
 * Tattoo node context interface
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node;

interface ContextInterface
{
    /**
     * Update the context (parent)
     * 
     * @param Node              $context
     * @return void
     */
    public function setContext(Node $context);
}
