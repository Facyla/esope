<?php
global $CONFIG;

$content = '';

// @TODO : list enabled identity providers

$providers = array('twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'google' => 'Google', 'facebook' => 'Facebook');

if ($providers) {
	if (!elgg_is_logged_in()) {
		//$content .= '<h4>' . elgg_echo('hybridauth:orregisterwith') . '</h4>';
	}
	$content .= '<p>';
	foreach ($providers as $key => $name) {
		// Add provider only if activated
		if (elgg_get_plugin_setting($key.'_enable', 'hybridauth') == 'yes') {
			if (elgg_is_logged_in()) {
				$content .= '<a href="' . $CONFIG->url . 'hybridauth/' . $key . '" style="float:left; margin-right:0.5ex;" title="' . elgg_echo('hybridauth:configureassociation', array($name)) . '"><img src="' . $CONFIG->url . 'mod/hybridauth/graphics/' . $key . '.png" alt="' . $name . '" /></a>';
			} else {
				$content .= '<a href="' . $CONFIG->url . 'hybridauth/' . $key . '" style="float:left; margin-right:0.5ex;" title="' . elgg_echo('hybridauth:registerwith', array($name)) . '"><img src="' . $CONFIG->url . 'mod/hybridauth/graphics/' . $key . '.png" alt="' . $name . '" /></a>';
			}
		}
	}
	$content .= '</p>';
	$content .= '<div class="clearfloat"></div>';
}

echo $content;


