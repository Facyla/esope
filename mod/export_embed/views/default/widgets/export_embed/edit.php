<?php
$embedtype_opt = array(
    'site_activity' => elgg_echo('export_embed:type:site_activity'), 
    'friends_activity' => elgg_echo('export_embed:type:friends_activity'), 
    'my_activity' => elgg_echo('export_embed:type:my_activity'), 
    'group_activity' => elgg_echo('export_embed:type:group_activity'), 
    'groups_list' => elgg_echo('export_embed:type:groups_list'), 
    'agenda' => elgg_echo('export_embed:type:agenda'),
  );


// Full url
$embedurl = '<p><label>' . elgg_echo('export_embed:widget:embedurl') . elgg_view('input/text',  array('name' => 'params[embedurl]', 'value' => $vars['entity']->embedurl)) . '</label><br />' . elgg_echo('export_embed:widget:embedurl:help') . '</p>';
// Or finer config
$site_url = '<p><label>' . elgg_echo('export_embed:widget:site_url') . elgg_view('input/text',  array('name' => 'params[site_url]', 'value' => $vars['entity']->site_url)) . '</label><br />' . elgg_echo('export_embed:widget:site_url:help') . '</p>';
$embedtype = '<p><label>' . elgg_echo('export_embed:widget:embedtype') . elgg_view('input/dropdown',  array('name' => 'params[embedtype]', 'value' => $vars['entity']->embedtype, 'options_values' => $embedtype_opt)) . '</label><br />' . elgg_echo('export_embed:widget:embedtype:help') . '</p>';

// Additional parameters
$limit = '<p><label>' . elgg_echo('export_embed:widget:limit') . elgg_view('input/text',  array('name' => 'params[limit]', 'value' => $vars['entity']->limit)) . '</label><br />' . elgg_echo('export_embed:widget:limit:help') . '</p>';
$offset = '<p><label>' . elgg_echo('export_embed:widget:offset') . elgg_view('input/text',  array('name' => 'params[offset]', 'value' => $vars['entity']->offset)) . '</label><br />' . elgg_echo('export_embed:widget:offset:help') . '</p>';
$group_guid = '<p><label>' . elgg_echo('export_embed:widget:group_guid') . elgg_view('input/text',  array('name' => 'params[group_guid]', 'value' => $vars['entity']->group_guid)) . '</label><br />' . elgg_echo('export_embed:widget:group_guid:help') . '</p>';
$user_guid = '<p><label>' . elgg_echo('export_embed:widget:user_guid') . elgg_view('input/text',  array('name' => 'params[user_guid]', 'value' => $vars['entity']->user_guid)) . '</label><br />' . elgg_echo('export_embed:widget:user_guid:help') . '</p>';

$params = '<p><label>' . elgg_echo('export_embed:widget:params') . elgg_view('input/text',  array('name' => 'params[params]', 'value' => $vars['entity']->params)) . '</label><br />' . elgg_echo('export_embed:widget:params:help') . '</p>';


// Display settings
echo $embedurl;

echo $site_url . $embedtype . $params;

echo $limit . $offset . $group_guid . $user_guid;

