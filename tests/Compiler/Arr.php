<?php namespace Tattoo\Tests;
/**
 * Tattoo Compiler tests
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Compiler
 * @group Tattoo_Compiler_Arr
 */

use Tattoo\Node\Arr;
use Tattoo\Node\Arr\AutoKey;
use Tattoo\Node\Arr\AssocKey;

use Tattoo\Node\Value;
use Tattoo\Node\Variable;


class Compiler_Arr_Test extends Compiler_Test
{
	/**
	 * tests Parser
	 */
	public function testBasic()
	{	
		$array = new Arr;
		$array->addItem(new AutoKey, new Value('foo', 'string'));
		
		$this->assertEquals("array(0 => 'foo')", $this->compile($array));
	}

	/**
	 * tests Parser
	 */
	public function testWithVariable()
	{	
		$array = new Arr;
		$array->addItem(new AutoKey, new Variable('foo'));

		$this->assertEquals("array(0 => \$__tattoo_vars['foo'])", $this->compile($array, array('autoEscapeVariables' => false)));
	}
}