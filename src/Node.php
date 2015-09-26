<?php namespace Tattoo;

/**
 * Tattoo result node
 ** 
 * @package 		Tattoo
 * @copyright 		2015 Mario Döring
 */

use Tattoo\Exception;
 
class Node
{
	/**
	 * A node can implement events 
	 * 
	 * @var array
	 */
	private $events = array();

	/**
	 * storage for properties that get shared through the entire node tree
	 *
	 * @var array
	 */
	protected $inheritProperties = array();

	/**
	 * Gets a inherited property
	 * 
	 * @param string 			$key
	 * @param mixed 			$default 
	 * @return void
	 */
	final public function getInheritProperty($key, $default = null)
	{
		if (!isset($this->inheritProperties[$key]))
		{
			return $default;
		}
		
		return $this->inheritProperties[$key];
	}

	/**
	 * Sets a value for all property children in the current node tree
	 * 
	 * @param string 			$key
	 * @param mixed 			$value
	 * @return void
	 */
	final public function setInheritProperty($key, $value)
	{
		$this->inheritProperties[$key] = $value;

		$excludedProperties = array('parent', 'inheritProperties', 'events');

		foreach(get_object_vars($this) as $propertyKey => $propertyValue)
		{
			if (in_array($propertyKey, $excludedProperties))
			{
				continue;
			}

			$this->tryForwardingInheritProperty($propertyValue, $key, $value);
		}
	}

	/**
	 * Allows recursion of this step when we have arrays as properties
	 *
	 * @param Node 				$var
	 */
	private function tryForwardingInheritProperty($var, $key, $value)
	{
		if (is_array($var))
		{
			foreach($var as $item)
			{
				$this->tryForwardingInheritProperty($item, $key, $value);
			}
		}
		elseif($var instanceOf Node)
		{
			$var->setInheritProperty($key, $value);
		}
	}

	/**
	 * Registers an node event
	 * 
	 * @param string 			$name
	 * @param callable 			$callback 
	 * @return void
	 */
	final public function mindEvent($name, $callback)
	{
		if (!is_callable($callback))
		{
			throw new \Exception('Cannot register event, given callback is not callable.');
		} 

		$this->events[$name][] = $callback;
	}

	/** 
	 * Fires an event
	 * 
	 * @param string 			$name
	 * @param arguments...
	 */
	final public function fireEvent()
	{
		$arguments = func_get_args();

		$name = array_shift($arguments);

		if (isset($this->events[$name]))
		{
			foreach ($this->events[$name] as $event) 
			{
				call_user_func_array($event, $arguments);
			}
		}
	}

	/**
	 * Magic call function to enable default getters and setters
	 * 
	 * @param string 				$method
	 * @param array 				$arguments
	 * @return mixed
	 */
	public function __call($method, array $arguments)
	{
		$availableMethodPrefixes = array('get', 'set');

		$methodPrefix = null;
		$property = null;

		foreach($availableMethodPrefixes as $prefix)
		{
			if (substr($method, 0, strlen($prefix)) === $prefix)
			{
				$methodPrefix = $prefix;
				$property = lcfirst(substr($method, strlen($prefix)));
			}
		}

		if (is_null($methodPrefix)) 
		{
			throw new \BadMethodCallException();
		}

		if (!property_exists($this, $property))
		{
			throw new Exception('Property ' . $property . ' is not defined in: '.get_called_class());
		}

		$arguments = array_merge(array($property), $arguments);

		return call_user_func_array(array($this, $methodPrefix . 'Property'), $arguments);
	}

	/**
	 * Get the value of a property
	 * 
	 * @param string 			$key
	 * @param mixed 			$default
	 * @return mixed
	 */
	protected function getProperty($key, $default = null)
	{
		if (is_null($this->$key))
		{
			$value = $default;
		} else {
			$value = $this->$key;
		}

		// check if getter overwrite exsists
		if (method_exists($this, $methodName = 'get' . ucfirst($key)))
		{
			return call_user_func_array(array($this, $methodName), array($value));
		}

		return $value;
	}

	/**
	 * Set the value of a property
	 * 
	 * @param string 			$key
	 * @param mixed 			$value
	 * @return mixed
	 */
	protected function setProperty($key, $value)
	{
		// check if setter overwrite exsists
		if (method_exists($this, $methodName = 'set' . ucfirst($key)))
		{
			$value = call_user_func_array(array($this, $methodName), array($value));
		}

		return $this->$key = $value;
	}
}