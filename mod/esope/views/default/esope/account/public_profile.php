<?php

$public_profiles = elgg_get_plugin_setting('public_profiles', 'esope');
$public_profiles_default = elgg_get_plugin_setting('public_profiles_default', 'esope');
if (empty($public_profiles_default)) $public_profiles_default = 'no';

if ($public_profiles == 'yes') {
	$user = elgg_get_page_owner_entity();
	
	if ($user) {
		$content = '<p><label>' . elgg_echo('esope:usersettings:public_profile') . ' ';
		// Valeur par défaut selon le choix pour le site (par défaut : restreint)
		if ($public_profiles_default == 'no') {
			$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
			$content .= elgg_view('input/dropdown', array('name' => 'public_profile', 'options_values' => $no_yes_opt, 'value' => $user->public_profile));
		} else {
			$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
			$content .= elgg_view('input/dropdown', array('name' => 'public_profile', 'options_values' => $yes_no_opt, 'value' => $user->public_profile));
		}
		$content .= '</label></p>';
		$content .= '<p>' . elgg_echo('esope:usersettings:public_profile:help') . '</p>';
	}
	echo elgg_view_module("info" , elgg_echo('esope:usersettings:public_profiles:title'), $content);
}

