<?php
// reCAPTCHA input field

$publickey = elgg_extract('publickey', $vars);
if (empty($publickey)) {
	$publickey = elgg_get_plugin_setting('publickey', 'recaptcha');
}

/* Other optional parameters : due to the (cloning) method used for multiple reCAPTCHAS on same page, 
 * all reCAPTCHA will have the same parameters as the first one
 * So better set these params site-wide
 * theme: The visual design of the recaptcha ('light' | 'dark')
 * size: The size of the recaptcha ('normal' | 'compact')
 * type: Type of challenge to perform ('image' | 'audio')
 */
$theme = elgg_extract('theme', $vars);
if (empty($theme)) { $theme = elgg_get_plugin_setting('theme', 'recaptcha'); }
$size = elgg_extract('size', $vars);
if (empty($size)) { $size = elgg_get_plugin_setting('size', 'recaptcha'); }
$type = elgg_extract('type', $vars);
if (empty($type)) { $type = elgg_get_plugin_setting('type', 'recaptcha'); }


// Multiple reCAPTCHA support : requires using id
if (function_exists('esope_unique_id')) {
	$id = esope_unique_id('g-recaptcha-');
} else {
	global $recaptcha_count;
	if (!$recaptcha_count) { $recaptcha_count = 0; }
	$recaptcha_count++;
	$id = 'g-recaptcha-' . $recaptcha_count;
}

// Render reCAPTCHA
// Note : Do not block (by generating an invalid reCAPTCHA) if no public key set by the admin
if (!empty($publickey)) {
	echo '<div class="g-recaptcha" id="' . $id . '"';
	echo ' data-sitekey="' . $publickey . '"';
	if ($theme) { echo ' data-theme="' . $theme . '"'; }
	if ($size) { echo ' data-size="' . $size . '"'; }
	if ($type) { echo ' data-type="' . $type . '"'; }
	echo '></div>';
	// Support no JS
	// Note : this requires to enable low security mode in reCAPTCHA settings
	/*
	echo '<noscript>
		<div>
			<div style="width: 302px; height: 422px; position: relative;">
				<div style="width: 302px; height: 422px; position: absolute;">
					<iframe src="https://www.google.com/recaptcha/api/fallback?k=' . $publicKey . '" frameborder="0" scrolling="no" style="width: 302px; height:422px; border-style: none;"></iframe>
				</div>
			</div>
			<div style="width: 300px; height: 60px; border-style: none; bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px; background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
				<textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;"></textarea>
			</div>
		</div>
	</noscript>';
	*/
} else {
	// But we could alert the users (publicly ?)
	
}

