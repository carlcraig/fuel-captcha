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
return array(

/** Driver List
 * 
 * (array)
 * 
 * An Array of Drivers
 * Driver Name => Driver Class
 * 
 * The Class has to have a forge function
 * 
 * eg. Captcha::forge('recaptcha');
 * will call Driver_Recaptcha::forge();
 * 
 */
	'driver_list' => array(
		'simplecaptcha' => 'Driver_Simplecaptcha',
		'recaptcha' => 'Driver_Recaptcha',
	),
	
/** Default Driver
 * 
 * (string)
 * 
 * The name of the default driver to load
 * 
 * The default driver will be called when you forge without giving the driver
 * e.g. Captcha::forge();
 */
	'driver_default' => 'simplecaptcha',
);
