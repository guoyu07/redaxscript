<?php
namespace Redaxscript;

/**
 * abstract class to create a singleton class
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Singleton
 * @author Henry Ruhs
 *
 *
 * @codeCoverageIgnore
 */

abstract class Singleton
{
	/**
	 * instance of the class
	 *
	 * @var array
	 */

	protected static $_instance;

	/**
	 * constructor of the class
	 *
	 * @since 2.2.0
	 */

	private function __construct()
	{
	}

	/**
	 * get the instance
	 *
	 * @since 2.2.0
	 *
	 * @return object
	 */

	public static function getInstance()
	{
		$className = get_called_class();

		/* create instance */

		if (!is_array(static::$_instance) || !array_key_exists($className, static::$_instance))
		{
			static::$_instance[$className] = new static();
		}
		return static::$_instance[$className];
	}

	/**
	 * clear the instance
	 *
	 * @since 3.0.0
	 */

	public static function clearInstance()
	{
		$className = get_called_class();
		self::$_instance[$className] = null;
	}
}
