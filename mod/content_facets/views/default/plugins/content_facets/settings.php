<?php
$url = elgg_get_site_url();

// Define dropdown options
$yn_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));


// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Example yes/no setting
//echo '<p><label>' . elgg_echo('content_facets:settings:settingname'). ' ' . elgg_view('input/select', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('content_facets:settings:settingname:details'). '</em></p>';


// Example text setting
//echo '<p><label>' . elgg_echo('content_facets:settings:settingname'). ' ' . elgg_view('input/text', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</label><br /><em>' . elgg_echo('content_facets:settings:settingname:details'). '</em></p>';


// Convertir les médias identifiés en lecteurs embarqués (vidéos, images)
echo '<p><label>' . elgg_echo('content_facets:settings:convert_longtext'). ' ' . elgg_view('input/select', array('name' => 'params[convert_longtext]', 'options_values' => $ny_opt, 'value' => $vars['entity']->convert_longtext)) . '</label><br /><em>' . elgg_echo('content_facets:settings:convert_longtext:details'). '</em></p>';


// Ajouter les ressources après le contenu
echo '<p><label>' . elgg_echo('content_facets:settings:extend_longtext'). ' ' . elgg_view('input/select', array('name' => 'params[extend_longtext]', 'options_values' => $ny_opt, 'value' => $vars['entity']->convert_longtext)) . '</label><br /><em>' . elgg_echo('content_facets:settings:extend_longtext:details'). '</em></p>';


