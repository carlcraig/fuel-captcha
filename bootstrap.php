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
Autoloader::add_core_namespace('Captcha');

Autoloader::add_classes(array(
	'Captcha\\Captcha'          => __DIR__.'/classes/captcha.php',
	'Captcha\\Driver_Simplecaptcha'  => __DIR__.'/classes/driver/simplecaptcha.php',
	'Captcha\\Driver_Simplecaptcha_Image'  => __DIR__.'/classes/driver/simplecaptcha/image.php',
	'Captcha\\Driver_Recaptcha'  => __DIR__.'/classes/driver/recaptcha.php',
));
/* End of file bootstrap.php */
