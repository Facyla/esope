<?php
/**
 * Set some homepage settings
 */

if (!theme_transitions2_user_is_platform_admin()) {
	register_error(elgg_echo('theme:error:notadmin'));
	forward(REFERER);
}

$name = get_input('name', '');
// Filter valid setting sthat content admin is allowed to update
$match_name = substr($name, 0, 12);
//if (in_array($name, array('home-article1', 'home-article2', 'home-article3', 'home-article4'))) {
if ($match_name == 'home-article') {
	$value = get_input($name, '');
	elgg_set_plugin_setting($name, $value, 'theme_transitions2');
}

forward(REFERER);
