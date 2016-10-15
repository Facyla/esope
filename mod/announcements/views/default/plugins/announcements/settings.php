<?php
/**
 * Elgg CMIS authentication settings
 * Enable user mode / site mode
 * Set CMIS server settings
 * Set credentials for site mode
 * Enable widgets
 */

$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

$group_recipients_opt = array(
		'default' => elgg_echo('announcements:group_recipients:default'),
		'email_members' => elgg_echo('announcements:group_recipients:email_members'),
	);

$hide_groupmodule_opt = array(
		'no' => elgg_echo('announcements:hide_groupmodule:no'),
		'nonadmin' => elgg_echo('announcements:hide_groupmodule:nonadmin'),
		'yes' => elgg_echo('announcements:hide_groupmodule:yes'),
	);



echo '<p><label>' . elgg_echo('announcements:settings:group_recipients') . elgg_view('input/select', array( 'name' => 'params[group_recipients]', 'options_values' => $group_recipients_opt, 'value' => $vars['entity']->group_recipients)) . '</label></p>';

echo '<p><label>' . elgg_echo('announcements:settings:hide_groupmodule') . elgg_view('input/select', array( 'name' => 'params[hide_groupmodule]', 'options_values' => $hide_groupmodule_opt, 'value' => $vars['entity']->hide_groupmodule)) . '</label></p>';

echo '<p><label>' . elgg_echo('announcements:settings:can_comment') . elgg_view('input/select', array( 'name' => 'params[can_comment]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->can_comment)) . '</label></p>';


