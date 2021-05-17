<?php
$plugin = elgg_extract('entity', $vars);

$url = elgg_get_site_url();

// Define select options
$yn_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$ny_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];



// Mode debug
echo '<div><label>' . elgg_echo('theme_adf:settings:home_text') . ' ' . elgg_view('input/longtext', array('name' => 'params[home_text]', 'value' => $plugin->home_text)) . '</label></div>';


