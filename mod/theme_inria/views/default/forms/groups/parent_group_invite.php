<?php
/**
 * Elgg sub-groups invite form extend
 *
 * Invite parent group members
 */

$group = elgg_extract('entity', $vars);
$main_group = theme_inria_get_main_group($group);
if ($group->guid == $main_group->guid) { return; }


$content = '';

$content .= '<h3>' . elgg_echo('theme_inria:workspace:invite:parent_members:title') . '</h3>';

// Allow direct registration
$allowregister = elgg_get_plugin_setting('allowregister', 'esope');
if ($allowregister == 'yes') {
	$content .= ' <p><label>' . elgg_echo('esope:groups:allowregister') . '</label> ' . elgg_view('input/select', array('name' => 'group_register', 'options_values' => array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')))) . '</p>';
}

$content .= elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
// Note : this is useless when using only 1 subgroup level, but may make sense if using multiple level...
$content .= elgg_view('input/hidden', array('name' => 'main_group_guid', 'value' => $main_group->guid));
$content .= elgg_view('input/submit', array('value' => elgg_echo('theme_inria:workspace:invite:parent_members')));

echo $content;

