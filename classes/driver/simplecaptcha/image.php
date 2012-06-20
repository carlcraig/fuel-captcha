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

class Driver_Simplecaptcha_Image
{
	/** Image Type
	 * (string)
	 * The type of image to output, either png or jpeg
	 */
	protected $image_type;
	
	/** Image Captcha
	 * (image)
	 * The Captcha Image Object
	 */
	protected $image_captcha;
	
	/** Image Captcha Background
	 * (image colour)
	 * The Captcha Image Background Colour
	 */
	protected $image_captcha_background;
	
	/** Image Font
	 * (image)
	 * The Font Image Object
	 */
	protected $image_font;
	
	/** Captcha Width
	 * (integer)
	 * The width for the Captcha
	 */
	protected $captcha_width;
	
	/** Captcha Height
	 * (integer)
	 * The height for the Captcha
	 */
	protected $captcha_height;
	
	/** Key Array
	 * (array)
	 * The key array for the captcha
	 * each key should be an array with the following structure
	 * 'symbol' => the symbol,
	 * 'width' => the symbol width in pixels,
	 *  x => the symbols x coordinate
	 */
	protected $key_array;

	/** Key Width
	 * (integer)
	 * The Width for the key_array
	 * This is used to calculate the margins
	 * so that the key is central in the catcha
	 */
	protected $key_width;
	
	/** Margin X
	 * (integer)
	 * The x margin in pixels for the key within the captcha
	 */
	protected $margin_x;
	
	/** Margin Y
	 * (integer)
	 * The y margin in pixels for the key within the captcha
	 */
	protected $margin_y;
	
	/** Background RGBA
	 * (array)
	 * The rgba array for the captcha background
	 */
	protected $background_rgba;
	
	/** Font
	 * (string)
	 * A path to a font png file
	 */
	protected $font;
	
	/** Font RGBA
	 * (array)
	 * The rgba array for the font
	 */
	protected $font_rgba;
	
	/** Font Width
	 * (integer)
	 * The width for the font image
	 */
	protected $font_width;
	
	/** Font Height
	 * (integer)
	 * The height for the font image
	 */
	protected $font_height;
	
	/** Font Png Width
	 * (integer)
	 * The width for the font png image
	 */
	protected $font_png_width;

	/** Font Png Height
	 * (integer)
	 * The height for the font png image
	 */	
	protected $font_png_height;
	
	/** Font Smooth
	 * (boolean)
	 * If true then the font will be smothed
	 */
	protected $font_smooth;

	/** Font Smooth Level
	 * (integer)
	 * The level of smoothing to apply to the font
	 */
	protected $font_smooth_level;

	/** Font Gaussian Blue
	 * (boolean)
	 * If true then the font will have a gaussian blur applied
	 */
	protected $font_gaussian_blur;

	/** Distort
	 * (boolean)
	 * If true then the captcha will be distorted
	 */
	protected $distort;

	/** Distort Multiplier
	 * (integer)
	 * The multiplier for the distortion
	 */
	protected $distort_multiplier;	
	
	/** Distort Amplitude
	 * (integer)
	 * The amplitude for the distortion
	 */
	protected $distort_amplitude;

	/** Distort Amplitude Flip
	 * (boolean)
	 * If true then the amplitude will be flipped to negative randomly
	 */
	protected $distort_amplitude_flip;

	/** Distort Period
	 * (integer)
	 * The period for the distortion
	 */
	protected $distort_period;
	
	/** Message
	 * (boolean)
	 * If true then a message will be appended to the captcha
	 */
	protected $message;

	/** Message Height
	 * (integer)
	 * The height in pixels for the message
	 */
	protected $message_height;

	/** Message Text RGBA
	 * (array)
	 * The rgba array for the message text
	 */
	protected $message_text_rgba;

	/** Message Background RGBA
	 * (array)
	 * The rgba array for the message background
	 */
	protected $message_background_rgba;

	/** Message String
	 * (false) or (string)
	 * The Message string for the message, if false Uri::base() will be used
	 */
	protected $message_string;

	/** Message String Offset
	 * (array)
	 * The X, Y offset for the message string
	 */
	protected $message_string_offset;

	/** Message Font Size
	 * (integer) 0 - 5
	 * The Font Size for the message
	 */
	protected $message_font_size;


/** Construct
 * 
 * @param array
 * 
 * Runs the Config through the set() function
 */
	public function __construct($config)
	{
		$this->set($config);
	}

/** Set
 * 
 * @param string or array
 * @param any
 * 
 * Sets variables into the class properties.
 * example set('captcha_width', 50) would set the captcha_width property to 50
 * 
 * example set(array('captcha_width' => 50, 'captcha_height' => 10))
 * This would set the captcha width to 50 and the height to 10
 * 
 */
	public function set($config, $value = null)
	{
		if (is_array($config))
		{
			foreach ($config as $property => $value)
			{
				if (property_exists(__CLASS__, $property))
				{
					$this->$property = $value;
				}
			}
		}
		elseif ($value)
		{
			if (property_exists(__CLASS__, $config))
			{
				$this->$config = $value;
			}
		}
	}

/** Create
 * 
 * @return image response object
 * 
 * Creates the captcha response
 */
	public function create()
	{
		$this->image_type();
		$this->image_captcha();
		$this->image_font();
		$this->set_margins();
		$this->draw();
		$this->distort();
		$this->message();
		$response = new \Fuel\Core\Response();
		$response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
		$response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
		$response->set_header('Pragma', 'no-cache');
		if ($this->image_type === 'png')
		{
			$response->set_header('Content-Type','image/png');
			$response->body = imagepng($this->image_captcha);
		}
		else if ($this->image_type === 'jpeg')
		{
			$response->set_header('Content-Type','image/jpeg');
			$response->body = imagejpeg($this->image_captcha);
		}
		imagedestroy($this->image_captcha);
		return $response;
	}
	
/** Image Type
 * 
 * Sets the image type, if not already specified
 * 
 * png or jpeg
 */	
	protected function image_type()
	{
		if ( ! $this->image_type)
		{
			if (function_exists('imagepng'))
			{
				$this->image_type = 'png';
			}
			elseif (function_exists('imagejpeg'))
			{
				$this->image_type = 'jpeg';
			}
			else
			{
				throw new Captcha_Exception('Need Functions imagepng or imagejpeg');
			}
		}
	}

/** Alpha
 *
 * @param image object
 *
 * adds alphablending or alphasave to an image, depending on the image type
 */
	protected function alpha($image)
	{
		if ($this->image_type === 'png')
		{
			imagealphablending($image, false);
			imagesavealpha($image, true);
		}
		else
		{
			imagealphablending($image, true);
		}
	}

/** Image Captcha
 *
 * Creates the image captcha image object and applies the background colour
 */
	protected function image_captcha()
	{
		$this->image_captcha = imagecreatetruecolor($this->captcha_width, $this->captcha_height);
		$this->image_captcha_background = imagecolorallocatealpha($this->image_captcha, $this->background_rgba[0], $this->background_rgba[1], $this->background_rgba[2], $this->background_rgba[3]);
		imagefilledrectangle($this->image_captcha, 0, 0, $this->captcha_width, $this->captcha_height, $this->image_captcha_background);
		return true;
	}

/** Image Font
 *
 * Creates the image font image object and resizes it depending on the font height
 * 
 * Colours the font to $this->font_rgba
 * 
 * Applies smoothing and gaussian blur, if specified
 */
	protected function image_font()
	{
		$font_tmp = imagecreatefrompng($this->font);
		imagefilter($font_tmp, IMG_FILTER_COLORIZE, $this->font_rgba[0], $this->font_rgba[1], $this->font_rgba[2], $this->font_rgba[3]);
		$this->alpha($font_tmp);
		if ($this->font_smooth)
		{
			imagefilter($font_tmp, IMG_FILTER_SMOOTH, $this->font_smooth_level);
		}
		if ($this->font_gaussian_blur)
		{
			imagefilter($font_tmp, IMG_FILTER_GAUSSIAN_BLUR);
		}
		$this->image_font = imagecreatetruecolor($this->font_width, $this->font_height);
		$background = imagecolorallocatealpha($this->image_font, $this->background_rgba[0], $this->background_rgba[1], $this->background_rgba[2], $this->background_rgba[3]);
		imagefilledrectangle($this->image_font, 0, 0, $this->font_width, $this->font_height, $background);
		$this->alpha($this->image_font);
		imagecopyresampled($this->image_font, $font_tmp, 0, 0, 0, 0, $this->font_width, $this->font_height, $this->font_png_width, $this->font_png_height);
		imagedestroy($font_tmp);
		return true;	
	}

/** Set Margins
 *
 * Sets the margins for the key
 * This is so that the key will appear in the middle of the image
 */
	protected function set_margins()
	{
		$x = $this->captcha_width - $this->key_width;
		if ($x > 1)
		{
			$x = floor($x/2);
		}
		else
		{
			$x = 0;
		}
		$this->margin_x = $x;
		
		if ($this->font_height >= $this->captcha_height)
		{
			$y = 0;
		}
		else
		{
			$y = $this->captcha_height - $this->font_height;
			if ($y > 1)
			{
				$y = floor($y/2);
			}
			else
			{
				$y = 0;
			}
		}
		$this->margin_y = $y;
		return true;
	}

/** Draw
 *
 * Draws the symbols in the key onto the image captcha from the image font
 */
	protected function draw()
	{
		foreach ($this->key_array as $data)
		{
			imagecopy($this->image_captcha, $this->image_font, $this->margin_x, $this->margin_y, $data['x'], 0, $data['width'], $this->font_height);
			$this->margin_x += $data['width'];
		}
		return true;
	}

/** Distort
 *
 * Distorts the key in the captcha image
 */
	protected function distort()
	{
		if ($this->distort)
		{
			if ($this->distort_period <= 0)
			{
				$this->distort_period = 1;
			}
			if ($this->distort_amplitude_flip)
			{
				if (rand(0, 1) > 0)
				{
					$this->distort_amplitude = - $this->distort_amplitude;
				}
			}
			$distort_width = $this->captcha_width * $this->distort_multiplier;
			$distort_height = $this->captcha_height * $this->distort_multiplier;
			$distort_image = imagecreatetruecolor($distort_width, $distort_height);
			imagecopyresampled($distort_image, $this->image_captcha, 0, 0, 0, 0, $distort_width, $distort_height, $this->captcha_width, $this->captcha_height);
			for ($i = 0; $i < $distort_width; $i += 2)
			{
				imagecopy($distort_image, $distort_image, $i - 2, sin($i / $this->distort_period) * $this->distort_amplitude, $i, 0, 2, $distort_height);
			}
			imagecopyresampled($this->image_captcha, $distort_image, 0, 0, 0, 0, $this->captcha_width, $this->captcha_height, $distort_width, $distort_height);
			imagedestroy($distort_image);
		}
		return true;
	}

/** Message
 *
 * Adds a message to the bottom of the captcha image
 * 
 * This will increase the captcha height by message_height
 */
	protected function message()
	{
		if ($this->message)
		{
			if (! $this->message_string)
			{
				$this->message_string = \Uri::base();
			}
			$height = $this->captcha_height + $this->message_height;
			$message_image = imagecreatetruecolor($this->captcha_width, $height);
			$message_background_rgba = imagecolorallocatealpha($message_image, $this->message_background_rgba[0], $this->message_background_rgba[1], $this->message_background_rgba[2], $this->message_background_rgba[3]);
			$message_text_rgba = imagecolorallocatealpha($message_image, $this->message_text_rgba[0], $this->message_text_rgba[1], $this->message_text_rgba[2], $this->message_text_rgba[3]);
			$background = imagecolorallocatealpha($message_image, $this->background_rgba[0], $this->background_rgba[1], $this->background_rgba[2], $this->background_rgba[3]);
			imagefilledrectangle($message_image, 0, 0, $this->captcha_width, $height, $background);
			imagefilledrectangle($message_image, 0, $this->captcha_height, $this->captcha_width, $height, $message_background_rgba);
			imagestring($message_image, $this->message_font_size, $this->message_string_offset[0], $this->captcha_height + $this->message_string_offset[1], $this->message_string, $message_text_rgba);
			imagecopy($message_image, $this->image_captcha, 0, 0, 0, 0, $this->captcha_width, $this->captcha_height);
			$this->image_captcha = $message_image;
		}
		return true;
	}

}

/* end of file image.php */
