<?php
/**
* Part of the FuelPHP framework.
*
* @package Fuel\Alias
* @version 2.0
* @license MIT License
* @copyright 2010 - 2014 Fuel Development Team
*/


if ( ! function_exists('object_exists'))
{
	/**
	 * Checks various object types for existence
	 */
	function object_exists($object, $autoload = true)
	{
		return class_exists($object, $autoload) or
			interface_exists($object, $autoload) or
			trait_exists($object, $autoload);
	}
}
