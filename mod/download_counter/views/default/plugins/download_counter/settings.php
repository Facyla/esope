<?php
global $CONFIG;

$url = elgg_get_site_url();

// Define dropdown options
$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));


// Set default value
$entity = elgg_extract('entity', $vars);
if (!isset($entity->display_counter)) { $entity->display_counter = 'no'; }


// @TODO Display counter ?
echo '<p><label>' . elgg_echo('download_counter:setting:display_counter') . ' ' . elgg_view('input/dropdown', array('name' => 'params[display_counter]', 'options_values' => $ny_opt, 'value' => $entity->display_counter)) . '</label><br /><em>' . elgg_echo('download_counter:setting:display_counter:details') . '</em></p>';


