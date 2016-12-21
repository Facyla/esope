<?php
// Add custom disclaimer text
if (!isset($vars['entity'])) {
	$disclaimer = elgg_get_plugin_setting('groups_disclaimer', 'esope');
	if (empty($displaimer)) { $dislaimer = '<p>' . elgg_echo('groups:newgroup:disclaimer') . '</p>'; }
	echo $disclaimer;
}

