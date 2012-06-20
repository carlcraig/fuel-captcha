<?php
/**
 * Captcha - a driver based captcha package for fuelphp
 * 
 * @package Captcha
 * @version v1.0
 * @author Carl Craig
 * @license MIT License
 * @copyright 2012 Carl Craig
 */
namespace Captcha;

class Captcha
{
	/** Config
	 * (array)
	 * The config array
	 */
	private static $config;
	
/** _Init
 * 
 * Loads the config file and adds it to the config property
 */
	public static function _init()
	{
		\Config::load('captcha', true);
		self::$config = \Config::get('captcha');
	}
	
/** Forge
 * 
 * @param string $driver - default null
 * 
 * Gets the driver returns the driver calling the forge function
 */
	public static function forge($driver = null)
	{
		$driver = self::get_driver($driver);
		return $driver::forge();
	}

/** Get Driver
 * 
 * @param string $driver - default null
 * 
 * Trys to find the driver. if driver is null, it will get the default driver from the config file
 */	
	protected static function get_driver($driver = null)
	{
		if ((string) $driver === '')
		{
			$driver = self::$config['driver_default'];
		}
		if (array_key_exists((string) $driver, self::$config['driver_list']))
		{
			$driver_class = self::$config['driver_list'][$driver];
		}
		else
		{
			throw new Captcha_Exception('Could not find driver "'.$driver.'" in the driver list');
		}
		if ( ! class_exists($driver_class))
		{
			throw new Captcha_Exception('Could not find class "'.$driver_class.'" for driver "'.$driver.'"');
		}

		return $driver_class;
	}
}

/** Captcha Exception
 * 
 * Extends the Fuel Exception Class
 */	
class Captcha_Exception extends \FuelException { }

/* end of file captcha.php */
