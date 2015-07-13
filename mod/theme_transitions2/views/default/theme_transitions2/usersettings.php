<?php

$user = elgg_get_page_owner_entity();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));


// Public profile
$title = elgg_echo('theme_transitions2:usersettings:public_profile:title');
$content = '<p><label>' . elgg_echo('theme_transitions2:usersettings:public_profile') . ' ' . elgg_view('input/dropdown', array('name' => 'public_profile', 'options_values' => $yes_no_opt, 'value' => $user->getPrivateSetting('public_profile'))) . '</label></p>';
echo elgg_view_module('info', $title, $content);

// Block private messages
$title = elgg_echo('theme_transitions2:usersettings:block_messages:title');
$content = '<p><label>' . elgg_echo('theme_transitions2:usersettings:block_messages') . ' ' . elgg_view('input/dropdown', array('name' => 'block_messages', 'options_values' => $no_yes_opt, 'value' => $user->getPrivateSetting('block_messages'))) . '</label></em></p>';
echo elgg_view_module('info', $title, $content);


