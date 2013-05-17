<?php
// Widget config view
$embedtype_opt = array(
    'site_activity' => elgg_echo('export_embed:type:site_activity'), 
    'friends_activity' => elgg_echo('export_embed:type:friends_activity'), 
    'my_activity' => elgg_echo('export_embed:type:my_activity'), 
    'group_activity' => elgg_echo('export_embed:type:group_activity'), 
    'groups_list' => elgg_echo('export_embed:type:groups_list'), 
    'agenda' => elgg_echo('export_embed:type:agenda'),
  );


// Full url
$embedurl = '<p><label>' . elgg_echo('export_embed:widget:embedurl') . elgg_view('input/text',  array('name' => 'params[embedurl]', 'value' => $vars['entity']->embedurl)) . '</label><div class="clearfloat"></div>' . elgg_echo('export_embed:widget:embedurl:help') . '</em></p>';
// Or easier config : site URL + widget type
$site_url = '<p><label>' . elgg_echo('export_embed:widget:site_url') . elgg_view('input/text',  array('name' => 'params[site_url]', 'value' => $vars['entity']->site_url)) . '</label><div class="clearfloat"></div><em>' . elgg_echo('export_embed:widget:site_url:help') . '</em></p>';
$embedtype = '<p><label>' . elgg_echo('export_embed:widget:embedtype') . elgg_view('input/dropdown',  array('name' => 'params[embedtype]', 'value' => $vars['entity']->embedtype, 'options_values' => $embedtype_opt)) . '</label><div class="clearfloat"></div><em>' . elgg_echo('export_embed:widget:embedtype:help') . '</em></p>';

// Additional parameters
$group_guid = '<p><label>' . elgg_echo('export_embed:widget:group_guid') . elgg_view('input/text',  array('name' => 'params[group_guid]', 'value' => $vars['entity']->group_guid)) . '</label><div class="clearfloat"></div><em>' . elgg_echo('export_embed:widget:group_guid:help') . '</em></p>';
$limit = '<p><label>' . elgg_echo('export_embed:widget:limit') . elgg_view('input/text',  array('name' => 'params[limit]', 'value' => $vars['entity']->limit)) . '</label><div class="clearfloat"></div><em>' . elgg_echo('export_embed:widget:limit:help') . '</em></p>';
$offset = '<p><label>' . elgg_echo('export_embed:widget:offset') . elgg_view('input/text',  array('name' => 'params[offset]', 'value' => $vars['entity']->offset)) . '</label><div class="clearfloat"></div><em>' . elgg_echo('export_embed:widget:offset:help') . '</em></p>';
$user_guid = '<p><label>' . elgg_echo('export_embed:widget:user_guid') . elgg_view('input/text',  array('name' => 'params[user_guid]', 'value' => $vars['entity']->user_guid)) . '</label><div class="clearfloat"></div><em>' . elgg_echo('export_embed:widget:user_guid:help') . '</em></p>';

// Custom URL params
$params = '<p><label>' . elgg_echo('export_embed:widget:params') . elgg_view('input/text',  array('name' => 'params[customparams]', 'value' => $vars['entity']->customparams)) . '</label><div class="clearfloat"></div><em>' . elgg_echo('export_embed:widget:params:help') . '</em></p>';


// Display settings
echo $embedurl;
echo $site_url . $embedtype;

echo $group_guid . $limit . $offset . $user_guid;

echo $params;

