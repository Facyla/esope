<?php
$yesno_options = array('no' => elgg_echo('group_chat:no'), 'yes' => elgg_echo('group_chat:yes'));

// Set defaults
if (!isset($vars['entity']->group_chat_days)) $vars['entity']->group_chat_days = 1;
if (!isset($vars['entity']->group_chat)) $vars['entity']->group_chat = 'yes';
if (!isset($vars['entity']->site_chat)) $vars['entity']->site_chat = 'no';


echo '<p><label>' . elgg_echo('group_chat:setting') .' '. elgg_view('input/text', array('name' => "params[group_chat_days]", 'value' => $vars['entity']->group_chat_days, 'js' => ' style="width:5ex;" ')) . '</label></p>';

$groupchat_options = array('no' => elgg_echo('group_chat:no'), 'yes' => elgg_echo('group_chat:yes'), 'groupoption' => elgg_echo('group_chat:groupoption'));
echo '<p><label>' . elgg_echo('group_chat:settings:group_chat') .' '. elgg_view('input/dropdown', array('name' => 'params[group_chat]', 'options_values' => $groupchat_options, 'value' => $vars['entity']->group_chat));
echo '</label></p>';

echo '<p><label>' . elgg_echo('group_chat:settings:site_chat') .' '. elgg_view('input/dropdown', array('name' => 'params[site_chat]', 'options_values' => $yesno_options, 'value' => $vars['entity']->site_chat));
echo '</label></p>';


