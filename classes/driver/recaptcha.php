<?php
/**
 * Copyright (c) 2007 reCAPTCHA -- http://recaptcha.net
 * AUTHORS:
 * Mike Crawford
 * Ben Maurer
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal 
 * in the Software without restriction, including without limitation the rights 
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
 * copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions: 
 * The above copyright notice and this permission notice shall be included in 
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE. 
 *
 * -------------------------------------------------------------------------------
 * 
 * This Code is a modified version of the reCaptcha package for fuel
 * @author Power Head <p0w3rhead@gmail.com>
 * @link https://github.com/fuel-packages/fuel-recaptcha
 * 
 * -------------------------------------------------------------------------------
 * 
 * Captcha - a driver based captcha package for fuelphp
 * 
 * @package Captcha
 * @version v1.0
 * @author Carl Craig
 * @license MIT License
 * 
 */

namespace Captcha;

class Driver_Recaptcha
{
	/** Config
	 * (array)
	 * The config array
	 */
	private $config;

	/** Error
	 * (string)
	 * Contains any errors generated whilst checking a recaptcha attempt
	 */
	protected $error;

/** Construct
 * 
 * Loads the config file and adds it to the config property
 */
	public function __construct()
	{
		\Config::load('recaptcha', true, false, true);
		$this->config = \Config::get('recaptcha');
		if ( ! $this->config['private_key'])
		{
			throw new Captcha_Exception('Recaptcha needs a private key to be specified in the config file');
		}
		if ( ! $this->config['public_key'])
		{
			throw new Captcha_Exception('Recaptcha needs a public key to be specified in the config file');
		}
	}	

/** Forge
 * 
 * Returns the current instance, or forges a new one if none exist
 */
	public static function forge()
	{
		static $instance = null;

		if ($instance === null)
		{
			$instance = new static;
		}
		
		return $instance;
	}
	
/** Check
 * 
 * Calls an HTTP POST function to verify if the user's guess was correct
 * 
 * @param string $remote_ip
 * @param string $challenge
 * @param string $response
 * @param array $extra_params an array of extra variables to post to the server
 * @return bool
 */
	public function check($remote_ip = null, $challenge = null, $response = null, $extra_params = array())
	{
		$remote_ip = \Input::real_ip();
		if ($remote_ip == '0.0.0.0' or $remote_ip == '')
		{
			throw new Captcha_Exception('Recaptcha needs a valid Remote IP');
		}
		if (is_null($challenge))
		{
			$challenge = \Input::post($this->config['challenge_field']);
		}
		if (is_null($response))
		{
			$response = \Input::post($this->config['response_field']);
		}
		
		$challenge = (string) e($challenge);
		$response = (string) e($response);
		
		if ($challenge === '' or $response === '')
		{
			$this->error = 'incorrect-captcha-sol';
			return false;
		}
	
		$response = $this->_http_post($this->config['verify_server'],"/recaptcha/api/verify",array(
			'privatekey' => $this->config['private_key'],
			'remoteip' => $remote_ip,
			'challenge' => $challenge,
			'response' => $response
			) + $extra_params);
			
		$answers = explode ("\n", $response[1]);
		if (trim($answers[0]) == 'true')
		{
			return true;
		}
		else
		{
			$this->error = $answers[1];
			return false;
		}
	}

/** Html
 * 
 * Gets the challenge HTML (javascript and non-javascript version).
 * 
 * @param string $view The view to load (optional, default is null)
 * @param string $error The error given by reCAPTCHA (optional, default is null)
 * @param boolean $use_ssl Should the request be made over ssl? (optional, default is false)
 * @return string - The HTML to be embedded in the user's form.
 */
	public function html($view = null, $error = null, $use_ssl = false)
	{
		if ($use_ssl)
		{
			$server = $this->config['secure_server'];
		}
		else
		{
			$server = $this->config['server'];
		}
		if (is_null($error) and $this->error)
		{
			$error = $this->error;
		}
		$error_part = '';
		if ($error)
		{
			$error_part = '&amp;error='.$error;
		}
		if (is_null($view))
		{
			$view = $this->config['default_view'];
		}
		
		$data = array();
		$data['server'] = $server;
		$data['public_key'] = $this->config['public_key'];
		$data['error_part'] = $error_part;
		$data['error'] = $error;
		return \View::forge($view, $data);
	}

/** Qsencode
 * 
 * Encodes the given data into a query string format
 * 
 * @param array $data - array of string elements to be encoded
 * @return  string - encoded request
 */
	private function _qsencode($data)
	{
		return http_build_query($data);
	}

/** Http Post
 * 
 * Submits an HTTP POST to a reCAPTCHA server
 * 
 * @param string $host
 * @param string $path
 * @param array $data
 * @param int port
 * @return array response
 */
	private function _http_post($host, $path, $data, $port = 80)
	{
		$req = $this->_qsencode($data);
		
		$http_request = implode('',array(
			"POST $path HTTP/1.0\r\n",
			"Host: $host\r\n",
			"Content-Type: application/x-www-form-urlencoded;\r\n",
			"Content-Length:".strlen($req)."\r\n",
			"User-Agent: reCAPTCHA/PHP\r\n",
			"\r\n",
			$req));
		
		$response = '';
		if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) )
		{
			throw new Captcha_Exception('Recaptcha could not open Socket');
			return false;
		}
		
		fwrite($fs, $http_request);
		while (!feof($fs))
		{
			$response .= fgets($fs, 1160); // One TCP-IP packet
		}
		fclose($fs);
		$response = explode("\r\n\r\n", $response, 2);
		return $response;
	}

/** Error
 * Returns error
 * @return string
 */
	public function error()
	{
		if ($this->error)
		{
			return $this->error;
		}
		else
		{
			return false;
		}
	}	
}

/* end of file recaptcha.php */
