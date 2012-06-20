<script type="text/javascript" src="<?php echo $server; ?>/challenge?k=<?php echo $public_key.$error_part; ?>"></script>
<noscript>
<iframe src="<?php echo $server; ?>/noscript?k=<?php echo $public_key.$error_part; ?>" height="300" width="500" frameborder="0"></iframe><br/>
<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
</noscript>
