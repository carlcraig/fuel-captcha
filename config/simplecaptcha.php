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

/**--------------------------------------------------------
 * KEY CONFIGURATION
 * --------------------------------------------------------
 */
 
/** Session Key Name
 * 
 * (string)
 * 
 * The name to store the key under in the session
 */	
	'session_key_name' => 'simplecaptcha',

/** Post Key Name
 * 
 * (string)
 * 
 * The name of the post variable containing the captcha attempt
 * This is only called if you dont pass the key attempt in the
 * check() function
 */	
	'post_key_name' => 'simplecaptcha',

/** Salt
 * 
 * (string)
 * 
 * The salt to use when hashing the key
 */		
	'salt' => '1f3870be274f6c49b3e31a0c6728957f',
	
	

/**--------------------------------------------------------
 * GENERAL CONFIGURATION
 * --------------------------------------------------------
 */
 
 /** Captcha Route
 * 
 * (string)
 * 
 * The route to the captcha image
 * e.g. \Uri::create('captcha/index')
 */	
	'captcha_route' => false,

/** Default View
 * 
 * (string)
 * 
 * The default view to load
 */	
	'default_view' => 'simplecaptcha/default',
 
/** Captcha Length
 *
 * (integer)
 * 
 * The number of characters for the captcha to show
 * Will be trimmed down to a number which fits into the captcha width
 */
	'captcha_length' => 6,

/** Captcha Width
 *
 * (integer)
 * 
 * The width in pixels for the captcha image
 */	
	'captcha_width' => 130,

/** Captcha Height
 * 
 * (integer)
 * 
 * The height in pixels for the captcha image
 */	
	'captcha_height' => 50,

/** Background RGBA
 * 
 * (array)
 * 
 * The background rgba for the captcha image
 */	
	'background_rgba' => array(255, 255, 255, 0),
	
/** Image Type
 * 
 * (string)
 * 
 * The type of image to output, either png or jpeg
 */	
	'image_type' => 'png',



/**--------------------------------------------------------
 * FONT CONFIGURATION
 * --------------------------------------------------------
 * Configuration for the Captcha font
 * 
 * To make the font larger or smaller adjust the font_height
 */
 
/** Font Directory
 * 
 * (string)
 * 
 * The Directory for the font png's including trailing slash
 */
	'font_directory' => PKGPATH.'captcha'.DS.'assets'.DS.'simplecaptcha'.DS,

/** Font List
 * 
 * (array)
 * 
 * A List of fonts to be used, they must be within the font_directory
 * To disable a font, remove it from this list;
 */	
	'font_list' => array(
		'cambria.png',
		'century.png',
		'droid_serif.png',
		'pt_serif.png',
		'times.png',
		'verdana.png',
	),

/** Font RGBA
 *
 * (array)
 * 
 * RGBA colour for the font
 */
	'font_rgba' => array(0, 0, 0, 0),
	
/** Font Height
 * 
 * (integer)
 * 
 * The height in pixels for the font to be displayed
 */
	'font_height' => 30,

/** Font Smooth
 * 
 * (boolean)
 * 
 * Set true to smooth the font
 */
	'font_smooth' => true,

/** Font Smooth Level
 *
 * (integer)
 * 
 * Set the level of smoothing to apply
 */
	'font_smooth_level' => 6,
	
/** Font Gaussian Blur
 * 
 * (boolean)
 * 
 * Set tue to apply gaussian blur to the font
 */
	'font_gaussian_blur' => true,
	
/** Font Png Width
 *
 * (integer)
 * 
 * The width in pixels for the font png
 * Default = 880
 */
	'font_png_width' => 880,
	
/** Font Png Height
 * 
 * (integer)
 * 
 * The height in pixels for the font png
 * Default = 30
 */
	'font_png_height' => 30,
	
	
	
/**--------------------------------------------------------
 * DISTORT CONFIGURATION
 * --------------------------------------------------------
 * Configuration for the distortion to apply to the captcha
 */

/** Distort
 *
 * (boolean)
 * 
 * Set to true to distort the captcha
 */
	'distort' => true,

/** Distort Multiplier
 *
 * (integer)
 * 
 * The multiplier to resample the image with
 */
	'distort_multiplier' => 2,
	
/** Distort Amplitude
 *
 * (integer)
 * 
 * The Amplitude for the distortion
 */
	'distort_amplitude' => 15,
	
/** Distort Amplitude Flip
 *
 * (boolean)
 * 
 * Set true to cause amplitude to flip to negative randomly
 */
	'distort_amplitude_flip' => true,

/** Distort Period
 * 
 * (integer) > 0
 * 
 * The Period for the distortion
 */
	'distort_period' => 30,



/**--------------------------------------------------------
 * MESSAGE CONFIGURATION
 * --------------------------------------------------------
 */

/** Message
 * 
 * (boolean)
 * 
 * Set true to apply the message tag to the captcha
 */
	'message' => true,
 
/** Message Height
 * 
 * (integer)
 * 
 * The height in pixels for the message tag
 */
	'message_height' => 15,

/** Message Text RGBA
 * 
 * (array)
 * 
 * The RGBA for the message text
 */
	'message_text_rgba' => array(255, 255, 255, 0),
	
/** Message Background RGBA
 *
 * (array)
 * 
 * The RGBA for the message background
 */
	'message_background_rgba' => array(0, 0, 0, 0),
	
/** Message String
 * 
 * (false) or (string)
 * 
 * The string to show in the message tag
 * If set to false it will show the base url, via Uri::base();
 * Alternatively set the string to show here.
 */
	'message_string' => 'Fuel Captcha Package',
	
/** Message String Offset
 * 
 * (array)
 * 
 * The x, y offset in pixels for the message string
 */
	'message_string_offset' => array(5, 0),
	
/** Message Font Size
 * 
 * (integer) 0-5
 * 
 * The size for the font in the message
 */
	'message_font_size' => 2,



/**--------------------------------------------------------
 * SYMBOL CONFIGURATION
 * --------------------------------------------------------
 */
 
/** Symbol List
 *
 * (array)
 * 
 * List of symbols and their grid width in pixels
 * This is preconfigured for the default font's
 * They will need to be altered if the sizes change in the font png's
 */
	'symbol_list' => array(
		array('symbol' => '0', 'width' => 20),
		array('symbol' => '1', 'width' => 20),
		array('symbol' => '2', 'width' => 20),
		array('symbol' => '3', 'width' => 20),
		array('symbol' => '4', 'width' => 20),
		array('symbol' => '5', 'width' => 20),
		array('symbol' => '6', 'width' => 20),
		array('symbol' => '7', 'width' => 20),
		array('symbol' => '8', 'width' => 20),
		array('symbol' => '9', 'width' => 20),
		array('symbol' => 'a', 'width' => 20),
		array('symbol' => 'b', 'width' => 20),
		array('symbol' => 'c', 'width' => 20),
		array('symbol' => 'd', 'width' => 20),
		array('symbol' => 'e', 'width' => 20),
		array('symbol' => 'f', 'width' => 20),
		array('symbol' => 'g', 'width' => 20),
		array('symbol' => 'h', 'width' => 20),
		array('symbol' => 'i', 'width' => 20),
		array('symbol' => 'j', 'width' => 20),
		array('symbol' => 'k', 'width' => 20),
		array('symbol' => 'l', 'width' => 20),
		array('symbol' => 'm', 'width' => 40),
		array('symbol' => 'n', 'width' => 20),
		array('symbol' => 'o', 'width' => 20),
		array('symbol' => 'p', 'width' => 20),
		array('symbol' => 'q', 'width' => 20),
		array('symbol' => 'r', 'width' => 20),
		array('symbol' => 's', 'width' => 20),
		array('symbol' => 't', 'width' => 20),
		array('symbol' => 'u', 'width' => 20),
		array('symbol' => 'v', 'width' => 20),
		array('symbol' => 'w', 'width' => 40),
		array('symbol' => 'x', 'width' => 20),
		array('symbol' => 'y', 'width' => 20),
		array('symbol' => 'z', 'width' => 20),
		array('symbol' => '=', 'width' => 20),
		array('symbol' => '-', 'width' => 20),
		array('symbol' => '+', 'width' => 20),
		array('symbol' => '*', 'width' => 20),
		array('symbol' => '/', 'width' => 20),
		array('symbol' => '?', 'width' => 20),
	),

/** Symbol Blacklist
 *
 * (array)
 * 
 * List of symbols that should not be used
 *(removing vowels helps prevent normal words from being generated)
 *
 */	
	'symbol_blacklist' => array('0','1','a','e','f','i','j','l','m','o','r','u','w','=','-','+','*','/','?'),	
);
