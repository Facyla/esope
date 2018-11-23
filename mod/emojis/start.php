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
	
	$debug = elgg_get_plugin_setting('debug', 'emojis');
	$input_hook = elgg_get_plugin_setting('enable_input_hook', 'emojis');
	$output_hook = elgg_get_plugin_setting('enable_output_hook', 'emojis');
	$thewire = elgg_get_plugin_setting('enable_thewire', 'emojis');
	
	// Debug
	if ($debug == 'yes') error_log("Emojis : debug session cache : " . count($_SESSION['emojis_known']) . ' / ' . mb_strlen(json_encode($_SESSION['emojis_known']))); // debug
	// Delete session data if it becomes too big ? eg > 100k
	if (mb_strlen(json_encode($_SESSION['emojis_known'])) > 1000000) {
		if ($debug == 'yes') error_log("Emojis : cache clear (size > 1M)"); // debug for RC stat info
		$_SESSION['emojis_known'] = null;
	}
	// Debug : Uncomment to clear session static cache (or use admin page on emojis/)
	//$_SESSION['emojis_Emoji_load_map'] = null;
	//$_SESSION['emojis_Emoji_load_regex'] = null;
	
	
	/* Speed tests and improvements :
	// No emojis hook : 0.03 0.2 0.03
	// No htmlawed hook : 0.03 0.2 0.03
	// First use of hook / session cleared : 0.03 0.2 0.04
	// First use of hook / session kept : 0.03 0.2 0.05
	// Next uses of hook / session kept : 0.0015 0.2 0.04
	 * - use static vars cache in session for map + regex
	 * - use static vars cache in session for converted strings
	 */
	
	// Convert emoji to HTML codepoint + filter UTF-8 non-characters
	// Note : &#XXX; may itself be stored as HTML entity (as &amp;#XXX;)
	// Store emojis as HTML entity (not encoded entity) to avoid display headaches
	// @TODO use this only if Database engine does not support UTF-8 (eg. mysql's utf8 does NOT, while utf8mb4 does)
	
	// INPUT HOOK (validates any user entry + some other entries too)
	if ($input_hook != 'no') {
		elgg_register_plugin_hook_handler('validate', 'input', 'emojis_input_hook');
	}
	
	// OUTPUT HOOK
	// Convert back encoded HTML entities to HTML codepoints
	// Note: easy when using longtext output, but use in search results, tags extraction and other string manipulations would work beter with emojis not converted to HTML entities in database
	//elgg_register_plugin_hook_handler('view', 'output/longtext', 'emojis_output_hook'); // Handles only longtext output
	if ($output_hook != 'no') {
		elgg_register_plugin_hook_handler('view', 'all', 'emojis_output_hook'); // Intercepts everything
	}
	
	// THE WIRE
	// Overrides the wire action so we can change the publish function and add emojis support
	if ($thewire != 'no') {
		elgg_unregister_action('thewire/add');
		$thewire_action_path = elgg_get_plugins_path() . 'emojis/actions/thewire/';
		elgg_register_action("thewire/add", $thewire_action_path . 'add.php');
	}
	
	
	// Register a page handler on "emojis/"
	// CUrrently restricted to admins / tests
	// This PH may become more public, e.g. as an endpoint for emojis, etc.
	elgg_register_page_handler('emojis', 'emojis_page_handler');
	
}


// Include page handlers, hooks and events functions
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/functions.php');
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/page_handlers.php');
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/hooks.php');
/*
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/events.php');
*/


