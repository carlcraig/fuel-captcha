# Fuel Captcha Package

A driver based captcha package for FuelPHP

## About
* Version: 1.0
* MIT License
* Author: Carl Craig
* reCAPTCHA Driver based FuelPHP reCAPTCHA Package [https://github.com/pwrhead/fuel-recaptcha](https://github.com/pwrhead/fuel-recaptcha)

## Installation

Download the package and extract it into `fuel/packages/captcha/`

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



