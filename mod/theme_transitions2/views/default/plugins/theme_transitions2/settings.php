<?php
$url = elgg_get_site_url();

// Define dropdown options
//$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Define Site menus replacement ?
$menus_options = elgg_menus_menus_opts();

echo "Choose custom site menus";

echo '<p><label>Topbar menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_topbar]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_topbar)) . '</label></p>';

echo '<p><label>Page menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_page]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_page)) . '</label></p>';

echo '<p><label>Site menu (main navigation) ' . elgg_view('input/dropdown', array('name' => 'params[menu_site]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_site)) . '</label></p>';

echo '<p><label>Footer menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_footer]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_footer)) . '</label></p>';


// Example yes/no setting
//echo '<p><label>Test select setting "setting_name"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->setting_name)) . '</p>';


// Example text setting
//echo '<p><label>Text setting "setting_name2"</label> ' . elgg_view('input/text', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</p>';


