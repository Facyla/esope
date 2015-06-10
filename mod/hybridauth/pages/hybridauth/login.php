<?php
global $CONFIG;

$providers = array('twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'google' => 'Google', 'facebook' => 'Facebook');

foreach ($providers as $key => $name) {
	// Add provider only if activated
	if (elgg_get_plugin_setting($key.'_enable', 'hybridauth') == 'yes') {
		if (elgg_is_logged_in()) {
			$content .= '<p><a href="' . $CONFIG->url . 'hybridauth/' . $key . '"><img src="' . $CONFIG->url . 'mod/hybridauth/graphics/' . $key . '.png" style="float:left;" /> ' . elgg_echo('hybridauth:configureassociation', array($name)) . '</a></p>';
		} else {
			$content .= '<p><a href="' . $CONFIG->url . 'hybridauth/' . $key . '"><img src="' . $CONFIG->url . 'mod/hybridauth/graphics/' . $key . '.png" style="float:left;" /> ' . elgg_echo('hybridauth:configureassociation', array($name)) . '</a></p>';
		}
		$content .= '<div class="clearfloat"></div>';
	}
}


