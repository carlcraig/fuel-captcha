Notice
======

This project is no longer maintained.

------------------------------

# Fuel Captcha Package

A driver based captcha package for FuelPHP

## About
* Version: 1.0
* MIT License
* Author: Carl Craig
* reCAPTCHA Driver based FuelPHP reCAPTCHA Package [https://github.com/pwrhead/fuel-recaptcha](https://github.com/pwrhead/fuel-recaptcha)

## Installation

Download the package and extract it into `fuel/packages/captcha/`

You must then either add it to __always_load__ in `app/config/config.php` or use `Package::load('captcha')`.

## Basic Configuration

The Captcha config file is located at

`config/captcha.php`

#### driver_list

An array of drivers

```php
  'driver_list' => array(
		'simplecaptcha' => 'Driver_Simplecaptcha',
		'recaptcha' => 'Driver_Recaptcha',
	),
```

#### driver_default

The default driver to load

## Drivers

By default there are two drivers for the Captcha Package

* Simplecaptcha
* reCAPTCHA

## Basic Usage

### Forging a Captcha Instance
To get a Captcha instance with the default driver:
```php
Captcha::forge();
```
To get a Captcha instance with a specific driver:
```php
Captcha::forge('driver_name');
```
### Captcha::forge()->check();
Checks to see if the user entered the correct captcha key

### Captcha::forge()->image();
Returns a Captcha Image response object
This currently works with the Simplecaptcha Driver

### Captcha::forge()->html();
Returns a html block for the given driver. In general the html block will contain the captcha image code and an input field.

## Simplecaptcha
Simplecaptcha is our lightweight captcha class written for this package

### Basic Configuration
The config file for Simplecaptcha can be found at `config/simplecaptcha.php`
#### Captcha_Route
You will want to add a path to a controller action which returns
```php
public function action_simplecaptcha()
{
	return Captcha::forge('simplecaptcha')->image();
}
```
This will enable you to use ->html() as it requires the path to where the captcha image is displayed

#### Salt
You will want to replace the salt with a new random hash.
This string will be used to salt captcha keys before storing them in the session.

#### Styling the Simplecaptcha Image
In the config file there are many different ways to style the captcha generated image.
Each config variable is well documented in the comments and it's really easy to tweak

### Image
#### Captcha::forge('simplecaptcha')->image($config = array());
The image function will return a image response object created with the php GD library
You can pass in extra configuration values whilst calling the image function.
```php
$config = array('captcha_width' => 300);
Captcha::forge('simplecaptcha')->image($config);
```
This will create the image object, with a width of 300 pixels.

When the image is created, a hashed and salted key will be stored in the users session.

### Html
#### Captcha::forge('simplecaptcha')->html($config = array());
This will return a html object with the captcha image and input text field.
By default it will load a view `views/simplecaptcha/default.php`
This file can be edited directly should you want to change the output
Alternatively you can pass a view variable in the config array, which will make the function load a custom view
```php
$config = array( 'view' => 'path/to/view' );
Captcha::forge('simplecaptcha')->html($config);
```
You can also pass the captcha_route variable in the $config array
```php
$config = array( 'captcha_route' => 'url for image()' );
Captcha::forge('simplecaptcha')->html($config);
```
Should you want to change the default view that is loaded, alter the default_view variable in the config
```php
'default_view' => 'simplecaptcha/default',
```

### Check
#### Captcha::forge('simplecaptcha')->check($key = null);
This will check the key entered by the user, against the one stored in the session
If __$key__ is left null, the function will try to get the entered key from the POST input, using the __post_key_name__ specified in config
```php
'session_key_name' => 'simplecaptcha',
'post_key_name' => 'simplecaptcha',
```
If the keys match, it will return True, otherwise it will return false

## reCAPTCHA
The recaptcha driver is based on the recaptcha package here: [https://github.com/pwrhead/fuel-recaptcha](https://github.com/pwrhead/fuel-recaptcha)

### Basic Configuration
The config file for reCAPTCHA can be found at `config/recaptcha.php`

You will need to add your private and public api keys here

### Html
#### Captcha::forge('recaptcha')->html($view = null, $error = null, $use_ssl = false);
This will return a html object with the reCAPTCHA html block.
By default it will load the view `views/recaptcha/default.php`
You can set $view to a different view whilst calling html()
```php
Captcha::forge('recaptcha')->html('recaptcha/custom');
```
You can also add the $error variable, with any error messages the reCAPTCHA html block needs to display
Finally you can set $use_ssl to true should you wish to enable ssl.
Should you want to change the default view that is loaded, alter the default_view variable in the config
```php
'default_view' => 'simplecaptcha/default',
```

### Check
#### Captcha::forge('recaptcha')->check($remote_ip = null, $challenge = null, $response = null, $extra_params = array());

This will check if the key entered by the user is correct.
```php
Captcha::forge('recaptcha')->check();
```
Will return True or False dependant on the keys being a match
By default the function will find the $remote_ip, $challenge, $response and $extra_params,
But you can enter them when you call check() if needed.
If left null, the $challenge and $response will be taken from the Input POST using the names specified in the config file
```php
'challenge_field' => 'recaptcha_challenge_field',
'response_field' => 'recaptcha_response_field',
```

