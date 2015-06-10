<?php
/**
 * This view provides a hook for third parties to provide a CAPTCHA.
 *
 * @package Elgg
 * @subpackage Core
 */

if (elgg_is_active_plugin('vazco_text_captcha')) {
	// Generate a token which is then passed into the captcha algorithm for verification
	$challenge = vazco_text_captcha::getCaptchaChallenge();
	list($challenge_id, $challenge_question, $challenge_answer) = $challenge;

	// Display captcha only if set
	if (!empty($challenge_question) && !empty($challenge_question)) {
		?>
		<div class="captcha">
			<input type="hidden" name="captcha_token" value="<?php echo $challenge_id; ?>" />
			<strong><?php echo elgg_echo('vazco_text_captcha:entercaptcha'); ?></strong><br />
			<blockquote><?php echo $challenge_question; ?></blockquote>
			<p><?php echo elgg_echo('vazco_text_captcha:entercaptcha:description'); ?>:</p>
			<?php echo elgg_view('input/text', array('name' => 'captcha_input', 'class' => 'captcha-input-text')); ?>
		</div>
		<?php
	}
}

