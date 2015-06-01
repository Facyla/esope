<?php

	// Generate a token which is then passed into the captcha algorithm for verification

	$challenge = vazco_text_captcha::getCaptchaChallenge();
	list($challenge_id, $challenge_question, $challenge_answer) = $challenge;  
?>
<div class="fing-register-captcha mandatory">
	<input type="hidden" name="captcha_token" value="<?php echo $challenge_id; ?>" />
	<label><?php echo $challenge_question; ?></label>
	
	<div class="profile_manager_register_input_container">
		<?php echo elgg_view('input/text', array('name' => 'captcha_input', 'class' => 'captcha-input-text')); ?>
	</div>
	
</div>
