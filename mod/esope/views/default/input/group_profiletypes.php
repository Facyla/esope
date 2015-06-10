<?php
// Lists all existing profile types and allows a multi select in the list
$vars['options_values'] = esope_get_profiletypes();

if (!empty($vars["name"])) $vars["name"] = 'allowed_profile_types';
// Note : "canonical" names would be allowed_profile_types and forbidden_profile_types;

if (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
	echo elgg_view('input/multiselect', $vars);
}

