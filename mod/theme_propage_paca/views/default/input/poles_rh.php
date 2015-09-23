<?php
$group = elgg_get_page_owner_entity();

// Lists all existing pole types and allow multiple selection
$vars['options_values'] = theme_propage_paca_get_poles_names();
// Allow to pass value by URL (for new group creation)
if (empty($vars['value'])) $vars['value'] = get_input('poles_rh');

if (!empty($vars["name"])) $vars["name"] = 'poles_rh';

$pole = theme_propage_paca_is_pole($group);
if ($pole) {
	echo '<p><em>' . elgg_echo('theme_propage_paca:group:already_pole', array(elgg_echo("theme_propage_paca:pole:$pole"))) . '</em></p>';
	echo elgg_view('input/hidden', array('name' => $vars["name"], 'value' => $pole));
} else {
	if ($departement) {
		$departement = theme_propage_paca_is_departement($group);
		echo '<p><em>' . elgg_echo('theme_propage_paca:group:already_departement', array(elgg_echo("theme_propage_paca:pole:$departement"))) . '</em></p>';
		echo elgg_view('input/hidden', array('name' => $vars["name"], 'value' => $departement));
	} else {
		if (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
			echo elgg_view('input/multiselect', $vars);
		}
	}
}

