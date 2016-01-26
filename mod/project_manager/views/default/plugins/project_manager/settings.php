<?php

/* Project manager settings
 * @TODO : serious rewrite of the plugin :
 * - enable personnal time tracking
 * - data model rewrite ?
 * - easier time tracking ?
 * - default project group ?
 * - custom project_manager metadata ?
 * - ...?
 */

$pm_meta = project_manager_get_user_metadata();

// Set defaults
if (empty($vars['entity']->user_metadata_name)) { $vars['entity']->user_metadata_name = 'project_manager_status'; }
// @TODO : add all admins ?  or at least the currently logged in admin for start
if (empty($vars['entity']->managers)) {
	$vars['entity']->managers = elgg_get_logged_in_user_guid();
}


// Set plugin settings
echo '<p>' . elgg_echo('project_manager:settings:presentation', array($pm_meta)) . '</p>';

// Set main user metadata name (used for roles and access)
echo '<p><label>' . elgg_echo('project_manager:settings:user_metadata_name') . ' ' . elgg_view('input/text', array('name' => 'params[user_metadata_name]', 'value' => $vars['entity']->user_metadata_name)) . '</p>';

// Managers GUIDs
// @TODO : use autocomplete field ?
echo '<p><label>' . elgg_echo('project_manager:settings:managers') . ' ' . elgg_view('input/text', array('name' => 'params[managers]', 'value' => $vars['entity']->managers));
$managers = explode(',', $vars['entity']->managers);
if (is_array($managers)) {
	echo '<br />' . elgg_view('output/members_list', array('value' => $managers)) . '<br /><br />';
}
echo '</p>';

// Données de base pour calculs consultants
echo '<h3>' . elgg_echo('project_manager:settings:consultants:data') . '</h3>';
echo '<p><label>' . elgg_echo('project_manager:settings:coefsalarie') . ' ' . elgg_view('input/text', array('name' => 'params[coefsalarie]', 'value' => $vars['entity']->coefsalarie, 'js' => ' style="width:5ex;"')) . '</p>';
echo '<p><label>' . elgg_echo('project_manager:settings:coefpv') . ' ' . elgg_view('input/text', array('name' => 'params[coefpv]', 'value' => $vars['entity']->coefpv, 'js' => ' style="width:5ex;"')) . '</p>';
echo '<p><label>' . elgg_echo('project_manager:settings:dayspermonth') . ' ' . elgg_view('input/text', array('name' => 'params[dayspermonth]', 'value' => $vars['entity']->dayspermonth, 'js' => ' style="width:5ex;"')) . '</p>';

// Default projects group ?
// Or keeping projects in user profile can be fine too..



