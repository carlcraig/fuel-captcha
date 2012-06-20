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

/** Private Key
 * 
 * (string)
 * 
 * The private key for recaptcha
 */	
	'private_key' => '',
	
/** Public Key
 * 
 * (string)
 * 
 * The public key for recaptcha
 */	
	'public_key' => '',

/** Server
 * 
 * (string)
 * 
 * The recaptcha API server
 */	
	'server' => 'http://www.google.com/recaptcha/api',

/** Secure Server
 * 
 * (string)
 * 
 * The recaptcha secure API server
 */	
	'secure_server' => 'https://www.google.com',
	
/** Verify Server
 * 
 * (string)
 * 
 * The recaptcha verify Server
 */	
	'verify_server' => 'www.google.com',

/** Challenge Field
 * 
 * (string)
 * 
 * The recaptcha challenge field
 */	
	'challenge_field' => 'recaptcha_challenge_field',
	
/** Response Field
 * 
 * (string)
 * 
 * The recaptcha response field
 */	
	'response_field' => 'recaptcha_response_field',
	
/** Default View
 * 
 * (string)
 * 
 * The default view to return when html() is called
 * variables passed to the view are
 * $server
 * $public_key
 * $error_part
 * $error
 */
	'default_view' => 'recaptcha/default',
);
