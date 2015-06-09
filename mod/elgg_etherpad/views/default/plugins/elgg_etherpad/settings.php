<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

if (empty($vars['entity']->cookiedomain)) { $vars['entity']->cookiedomain = parse_url(elgg_get_site_url(), PHP_URL_HOST); }

// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name == 'default'; }


// Example yes/no setting
//echo '<p><label>Test select setting "setting_name"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->setting_name)) . '</p>';


// Server URL and port
echo '<p><label>Etherpad URL, e.g. http://localhost:9001 </label> ' . elgg_view('input/text', array('name' => 'params[server]', 'value' => $vars['entity']->server)) . '</p>';

// Cookie domain
echo '<p><label>Cookie domain, e.g. localhost </label> ' . elgg_view('input/text', array('name' => 'params[cookiedomain]', 'value' => $vars['entity']->cookiedomain)) . '<br /><em>Cookie domain MUST be in same main domain as your Elgg site. You will probably want to remove subdomain if any.</em></p>';

// Example text setting
echo '<p><label>Etherpad APIKEY </label> ' . elgg_view('input/text', array('name' => 'params[api_key]', 'value' => $vars['entity']->api_key)) . '</p>';


