<?php
/**
 * Elgg external pages: add/edit action
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 */

gatekeeper();

// Get slider entity, if it exists
$guid = get_input('guid', false);
$slider = get_entity($guid);

$allow_cloning = elgg_get_plugin_setting('enable_cloning', 'slider');
if ($allow_cloning != 'yes') {
	register_error(elgg_echo("slider:clone:error"));
	// Forward to new slider edit page
	forward(REFERER);
}

// Check existing object, or create a new one
if (elgg_instanceof($slider, 'object', 'slider') && $slider->canEdit()) {
	$new_slider = clone $slider;
}

// Edition de l'objet nouvellement créé
$new_slider->owner_guid = elgg_get_logged_in_user_guid();
$new_slider->name = '';

// Save new/updated content
if ($new_slider->save()) {
	system_message(elgg_echo("slider:cloned")); // Success message
} else {
	register_error(elgg_echo("slider:clone:error"));
}

// Forward to new slider edit page
forward('slider/edit/' . $new_slider->guid);

