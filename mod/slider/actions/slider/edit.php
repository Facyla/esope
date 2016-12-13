<?php
/**
 * Elgg slider: add/edit action
 * 
 * @package Slider
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 */

gatekeeper();

// Cache to the session
elgg_make_sticky_form('slider');

/* Get input data */
$slider_title = get_input('title');
$slider_name = get_input('name');
$slider_description = get_input('description');
$slider_slides = get_input('slides', '', false); // We do *not want to filter HTML
$slider_config = get_input('config', '', false); // We do *not want to filter HTML
$slider_css = get_input('css', '', false); // We do *not want to filter HTML
$slider_height = get_input('height');
$slider_width = get_input('width');
$slider_access = get_input('access_id');
$slider_editor = get_input('editor');
// Set slider name if not defined + normalize it
// @TODO : ensure it remains unique ?
if (empty($slider_name)) { $slider_name = $slider_title; }
$slider_name = elgg_get_friendly_title($slider_name);

// Get slider entity, if it exists
$guid = get_input('guid', false);
$slider = get_entity($guid);
if (!$slider) $slider = slider_get_entity_by_name($guid);

// Check if slider name already exists (for another slider)
$existing_slider = slider_get_entity_by_name($slider_name);
if ($existing_slider && elgg_instanceof($slider, 'object', 'slider') && elgg_instanceof($existing_slider, 'object', 'slider') && ($existing_slider->guid != $slider->guid)) {
	register_error(elgg_echo('slider:error:alreadyexists'));
	forward(REFERER);
}


// Check existing object, or create a new one
if (!elgg_instanceof($slider, 'object', 'slider')) {
	$slider = new ElggSlider();
	$slider->save();
}


// Edition de l'objet existant ou nouvellement créé
$slider->access_id = $slider_access;

$slider->title = $slider_title;
$slider->name = $slider_name;
$slider->description = $slider_description;
$slider->slides = $slider_slides;
$slider->config = $slider_config;
$slider->css = $slider_css;
$slider->height = $slider_height;
$slider->width = $slider_width;
$slider->editor = $slider_editor;


// Save new/updated content
if ($slider->save()) {
	system_message(elgg_echo("slider:saved")); // Success message
	elgg_clear_sticky_form('slider'); // Remove the cache
} else {
	register_error(elgg_echo("slider:error"));
	forward(REFERER);
}

//elgg_set_ignore_access(false);

// Forward back to the edit page
$forward = elgg_get_site_url() . 'slider/edit/' . $slider->guid;

forward($forward);

