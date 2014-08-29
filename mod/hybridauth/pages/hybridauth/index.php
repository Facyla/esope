<?php
global $CONFIG;

//if (elgg_get_plugin_setting('twitter_enable', 'hybridauth') == 'yes') {}

// @TODO : list enabled identity providers

$providers = array('twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'google' => 'Google', 'facebook' => 'Facebook');

foreach ($providers as $key => $name) {
	// Add provider only if activated
	if (elgg_get_plugin_setting($key.'_enable', 'hybridauth') == 'yes') {
		$content .= 
	}
}

$title = "Hybridauth identity providers integration";

$body = elgg_view_layout('one_colum', array('content' => $content));

// Affichage
echo elgg_view_page($title, $body);


