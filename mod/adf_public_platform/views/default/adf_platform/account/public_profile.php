<?php

$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');

if ($public_profiles == 'yes') {
	$user = elgg_get_page_owner_entity();
	
	if ($user) {
		$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
		$content = '<p><label>' . elgg_echo('adf_platform:usersettings:public_profile') . ' ';
		$content .= elgg_view('input/dropdown', array('name' => 'public_profile', 'options_values' => $no_yes_opt, 'value' => $user->public_profile));
		$content .= '</label></p>';
		$content .= '<p>' . elgg_echo('adf_platform:usersettings:public_profile:help') . '</p>';
	}
	echo elgg_view_module("info" , elgg_echo('adf_platform:usersettings:public_profiles:title'), $content);
}

