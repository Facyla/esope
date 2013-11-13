<?php
/**
 * All groups listing page navigation
 *
 * @uses $vars['selected'] Name of the tab that has been selected
 */

$groups_newest = elgg_get_plugin_setting('groups_newest', 'adf_public_platform');
$groups_popular = elgg_get_plugin_setting('groups_popular', 'adf_public_platform');
$groups_discussion = elgg_get_plugin_setting('groups_discussion', 'adf_public_platform');
$groups_alpha = elgg_get_plugin_setting('groups_alpha', 'adf_public_platform');

// Newest, popular and discussion are default, so don't change if not asked to (should default to yes)
if (empty($groups_newest) || ($groups_newest == 'yes')) 
	$tabs['newest'] = array('text' => elgg_echo('groups:newest'), 'href' => 'groups/all?filter=newest', 'priority' => 200);

if (empty($groups_popular) || ($groups_popular == 'yes')) 
	$tabs['popular'] = array('text' => elgg_echo('groups:popular'), 'href' => 'groups/all?filter=popular', 'priority' => 300);

if (empty($groups_discussion) || ($groups_discussion == 'yes')) 
	$tabs['discussion'] = array('text' => elgg_echo('groups:latestdiscussion'), 'href' => 'groups/all?filter=discussion', 'priority' => 400);

if ($groups_alpha == 'yes') 
	$tabs['alpha'] = array('text' => elgg_echo('groups:alpha'), 'href' => 'groups/all?filter=alpha', 'priority' => 100);


if (count($tabs) > 1) {
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		if ($vars['selected'] == $name) { $tab['selected'] = true; }
		elgg_register_menu_item('filter', $tab);
	}
	echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
} else {
	/* Note : si on n'a aucun filtre, autant ne rien afficher du tout...
	foreach ($tabs as $name => $tab) {
		echo '<h3>' . $tab['text'] . '</h3>';
	}
	*/
}


