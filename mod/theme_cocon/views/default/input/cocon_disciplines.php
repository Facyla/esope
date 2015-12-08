<?php
// Lists all existing profile types and allows a multi select in the list
$values = elgg_get_plugin_setting("disciplines", 'theme_cocon');
$vars['options_values'] = esope_build_options($values, true);

if (empty($vars["name"])) $vars["name"] = 'cocon_discipline';

if (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
	echo elgg_view('input/dropdown', $vars);
}

