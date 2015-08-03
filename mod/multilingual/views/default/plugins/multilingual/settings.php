<?php
//$url = elgg_get_site_url();

// Define dropdown options
//$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));


// Set default value
if (!isset($vars['entity']->main_lang)) {
	global $CONFIG;
	$vars['entity']->main_lang = $CONFIG->language;
}

$available_types = get_registered_entity_types();
foreach ($available_types['object'] as $subtype) { $available_subtypes[$subtype] = $subtype; }
$available_subtypes = array_unique($available_subtypes);
$available_subtypes = implode(', ',$available_subtypes);
if (!isset($vars['entity']->object_subtypes)) $vars['entity']->object_subtypes = implode(', ', $available_subtypes);
// "blog, page, page_top";



// Example yes/no setting
//echo '<p><label>' . elgg_echo('plugin_template:settings:settingname'). ' ' . elgg_view('input/dropdown', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('plugin_template:settings:settingname:details'). '</em></p>';


// Set default lancguage code
echo '<p><label>' . elgg_echo('multilingual:settings:main_lang'). ' ' . elgg_view('input/text', array('name' => 'params[main_lang]', 'value' => $vars['entity']->main_lang)) . '</label><br /><em>' . elgg_echo('multilingual:settings:main_lang:details'). '</em></p>';

// Available languages
echo '<p><label>' . elgg_echo('multilingual:settings:langs'). ' ' . elgg_view('input/text', array('name' => 'params[langs]', 'value' => $vars['entity']->langs)) . '</label><br /><em>' . elgg_echo('multilingual:settings:langs:details'). '</em></p>';

// Translatable object subtypes (eg. nonsense for the Wire...)
echo '<p><label>' . elgg_echo('multilingual:settings:object_subtypes'). ' ' . elgg_view('input/text', array('name' => 'params[object_subtypes]', 'value' => $vars['entity']->object_subtypes)) . '</label><br /><em>' . elgg_echo('multilingual:settings:object_subtypes:details'). '</em><br />' . $available_subtypes . '</p>';


