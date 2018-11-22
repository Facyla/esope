<?php
/**
 * emojis plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

/*
 * Store Unicode emojis as HTML &#XXX;
 * Filter Unicode non-characters
 * Convert (display) :emoji: to HTML emoji entity
 * Provide endpoint for emojis search ?
*/


// Init plugin
elgg_register_event_handler('init', 'system', 'emojis_init');


/**
 * Init emojis plugin.
 */
function emojis_init() {
	
	elgg_extend_view('css', 'emojis/css');
	
	// Adds emojis detection support
	require_once('lib/EmojiDetection/Emoji.php');
	
	// Convert emoji to HTML codepoint + filter UTF-8 non-characters
	// Note : &#XXX; is itself stored as HTML entity (as &amp;#XXX;)
	// @TODO Store emojis as HTML entity (not encoded entity) to avoid display headaches
	// @TODO use this only if Database engine does not support UTF-8 (eg. mysql's utf8 does NOT, while utf8mb4 does)
	elgg_register_plugin_hook_handler('validate', 'input', 'emojis_input_hook');
	
	// Convert back encoded HTML entities to HTML codepoints
	// Note: easy when using longtext output, but use in search results, tags extraction and other string manipulations would work beter with emojis not converted to HTML entities in database
	//elgg_register_plugin_hook_handler('view', 'output/longtext', 'emojis_output_hook'); // Handles only longtext output
	elgg_register_plugin_hook_handler('view', 'all', 'emojis_output_hook'); // Intercepts everything
	
	// Override the wire action so we can change the publish function and add emojis support
	elgg_unregister_action('thewire/add');
	$thewire_action_path = elgg_get_plugins_path() . 'emojis/actions/thewire/';
	elgg_register_action("thewire/add", $thewire_action_path . 'add.php');
	
	
	// Register a page handler on "emojis/"
	elgg_register_page_handler('emojis', 'emojis_page_handler');
	
}


// Include page handlers, hooks and events functions
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/functions.php');
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/page_handlers.php');
/*
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/hooks.php');
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/events.php');
*/


