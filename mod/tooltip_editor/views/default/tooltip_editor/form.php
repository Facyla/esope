<?php

admin_gatekeeper();

$vars['submit'] = true;
$vars['set_content'] = true;

// get our defaults
$defaults = array(
	'positionmy' => elgg_get_plugin_setting('positionmy', 'tooltip_editor'),
	'positionat' => elgg_get_plugin_setting('positionat', 'tooltip_editor'),
	'persistent' => elgg_get_plugin_setting('persistent', 'tooltip_editor'),
	'delay' => elgg_get_plugin_setting('delay', 'tooltip_editor'),
	'tooltip_title' => '',
	'fontsize' => elgg_get_plugin_setting('fontsize', 'tooltip_editor')
);

$annotations = elgg_get_site_entity()->getAnnotations('tooltip-editor-' . $vars['token']);

$params = array();
if ($annotations) {
	$params = unserialize($annotations[0]->value);
				
	if (!is_array($params)) {
		$params = $defaults;
	}
}

$params = array_merge($defaults, $params);

$vars = array_merge($vars, $params);

echo elgg_view_form('tooltip_editor/edit', array(), $vars);