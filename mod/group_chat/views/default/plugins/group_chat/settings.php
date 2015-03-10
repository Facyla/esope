<?php
$no_yes_opt = array('no' => elgg_echo('group_chat:no'), 'yes' => elgg_echo('group_chat:yes'));

// Set defaults
if (!isset($vars['entity']->group_chat)) $vars['entity']->group_chat = 'yes';
if (!isset($vars['entity']->group_chat_days)) $vars['entity']->group_chat_days = 2;
if (!isset($vars['entity']->site_chat)) $vars['entity']->site_chat = 'no';
if (!isset($vars['entity']->site_chat_days)) $vars['entity']->site_chat_days = 2;
if (!isset($vars['entity']->user_chat)) $vars['entity']->user_chat = 'no';
if (!isset($vars['entity']->user_chat_days)) $vars['entity']->user_chat_days = 2;


// Group chat
echo '<fieldset><legend>' . elgg_echo('group_chat:settings:group_chat') .'</legend>';
$groupchat_options = array('no' => elgg_echo('group_chat:no'), 'yes' => elgg_echo('group_chat:yes'), 'groupoption' => elgg_echo('group_chat:groupoption'));
echo '<p><label>' . elgg_echo('group_chat:settings:group_chat') .' '. elgg_view('input/dropdown', array('name' => 'params[group_chat]', 'options_values' => $groupchat_options, 'value' => $vars['entity']->group_chat));
echo '</label></p>';
// Chat accessible history
echo '<p><label>' . elgg_echo('group_chat:history:group') .' '. elgg_view('input/text', array('name' => "params[group_chat_days]", 'value' => $vars['entity']->group_chat_days, 'js' => ' style="width:5ex;" ')) . '</label></p>';
echo '<p><label>' . elgg_echo('group_chat:settings:notifications') .' '. elgg_view('input/dropdown', array('name' => 'params[group_notification]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->group_notification));
echo '</fieldset>';


// Site chat
echo '<fieldset><legend>' . elgg_echo('group_chat:settings:site_chat') .'</legend>';
echo '<p><label>' . elgg_echo('group_chat:settings:site_chat') .' '. elgg_view('input/dropdown', array('name' => 'params[site_chat]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->site_chat));
echo '</label></p>';
echo '<p><label>' . elgg_echo('group_chat:history:site') .' '. elgg_view('input/text', array('name' => "params[site_chat_days]", 'value' => $vars['entity']->site_chat_days, 'js' => ' style="width:5ex;" ')) . '</label></p>';
echo '<p><label>' . elgg_echo('group_chat:settings:notifications') .' '. elgg_view('input/dropdown', array('name' => 'params[site_notification]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->site_notification));
echo '</fieldset>';

// User chat
echo '<fieldset><legend>' . elgg_echo('group_chat:settings:user_chat') .'</legend>';
echo '<p><label>' . elgg_echo('group_chat:settings:user_chat') .' '. elgg_view('input/dropdown', array('name' => 'params[user_chat]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->user_chat));
echo '</label></p>';
echo '<p><label>' . elgg_echo('group_chat:history:user') .' '. elgg_view('input/text', array('name' => "params[user_chat_days]", 'value' => $vars['entity']->user_chat_days, 'js' => ' style="width:5ex;" ')) . '</label></p>';
echo '<p><label>' . elgg_echo('group_chat:settings:notifications') .' '. elgg_view('input/dropdown', array('name' => 'params[user_notification]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->user_notification));
echo '</fieldset>';

echo '</label></p>';


