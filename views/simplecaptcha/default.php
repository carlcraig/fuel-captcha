<?php if (isset($captcha_error)) { ?>
<div>
	<p style="color:red"><?php echo $captcha_error; ?></p>
</div>
<?php } ?>
<div>
	<img src="<?php echo $captcha_route; ?>" alt="Simple Captcha" height="<?php echo $captcha_height; ?>" width="<?php echo $captcha_width; ?>" />
</div>
<div style="margin-top:20px">
	<label for="form_simplecaptcha">Captcha: </label>
	<input type="text" id="form_simplecaptcha" value="" name="<?php echo $captcha_post_name; ?>">
</div>
