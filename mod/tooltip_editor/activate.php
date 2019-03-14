<?php

$positionmy = elgg_get_plugin_setting('positionmy', 'tooltip_editor');
if (empty($positionmy)) {
	elgg_set_plugin_setting('positionmy', 'top right', 'tooltip_editor');
}

$positionat = elgg_get_plugin_setting('positinat', 'tooltip_editor');
if (empty($positionat)) {
	elgg_set_plugin_setting('positionat', 'bottom left', 'tooltip_editor');
}

$persistent = elgg_get_plugin_setting('persistent', 'tooltip_editor');
if (empty($persistent)) {
	elgg_set_plugin_setting('persistent', 'no', 'tooltip_editor');
}

$delay = elgg_get_plugin_setting('delay', 'tooltip_editor');
if (empty($delay) && $delay !== '0') {
	elgg_set_plugin_setting('delay', '1000', 'tooltip_editor');
}

$fontsize = elgg_get_plugin_setting('fontsize', 'tooltip_editor');
if (empty($fontsize)) {
	elgg_set_plugin_setting('fontsize', 12, 'tooltip_editor');
}