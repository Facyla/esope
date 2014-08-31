<?php
global $CONFIG;

$content = '';

// @TODO : list enabled identity providers

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

$title = elgg_echo('hybridauth:index');

$body = elgg_view_layout('one_colum', array('content' => $content));

// Affichage
echo elgg_view_page($title, $body);


