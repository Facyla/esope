<?php
// Get current slider (if exists)
$slider = elgg_extract('entity', $vars);
if (elgg_instanceof($slider, 'object', 'slider')) {
	$guid = get_input('guid', false);
	// Add support for unique identifiers
	$slider = slider_get_entity_by_name($guid);
}

// Get slider vars
if (!elgg_instanceof($slider, 'object', 'slider')) { return; }

$allow_cloning = elgg_get_plugin_setting('enable_cloning', 'slider');
if ($allow_cloning != 'yes') { return; }


// Edit form
// Param vars
$content = '';
if ($slider) { $content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $slider->guid)) . '</p>'; }
$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('slider:edit:clone'))) . '</p>';
$content .= '<p>' . elgg_echo('slider:clone:details') . '</p>';


/* AFFICHAGE DE LA PAGE D'ÉDITION */
echo '<h2>' . elgg_echo('slider:clone') . '</h2>';

// Affichage du formulaire
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => elgg_get_site_url() . "action/slider/clone", 'body' => $content, 'id' => "slider-clone-form"));


