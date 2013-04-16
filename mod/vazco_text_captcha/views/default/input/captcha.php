<?php

	// Generate a token which is then passed into the captcha algorithm for verification

	$challenge = vazco_text_captcha::getCaptchaChallenge();
	list($challenge_id, $challenge_question, $challenge_answer) = $challenge;  
?>
<div class="captcha">
	<input type="hidden" name="captcha_token" value="<?php echo $challenge_id; ?>" />
	<label>
		<?php echo elgg_echo('vazco_text_captcha:entercaptcha'); ?><br />
	</label>
	
	<div class="captcha-right">
		<blockquote><?php echo $challenge_question; ?></blockquote>
	</div>
	<p><?php echo elgg_echo('vazco_text_captcha:entercaptcha:description'); ?>:</p>
	<div class="captcha-left">
		<?php echo elgg_view('input/text', array('internalname' => 'captcha_input', 'class' => 'captcha-input-text')); ?>
	</div>
</div>