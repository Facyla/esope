<?php
// reCAPTCHA input field

$publickey = elgg_extract('publickey', $vars);
if (empty($publickey)) {
	$publickey = elgg_get_plugin_setting('publickey', 'recaptcha');
}

// Do not block if no public key set by the admin
if (!empty($publickey)) {
	echo '<div><div class="g-recaptcha" data-sitekey="' . $publickey . '"></div></div>';
}

