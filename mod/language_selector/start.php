<?php

require_once(dirname(__FILE__) . "/lib/functions.php");

/**
 * Init function for the language selector
 * 
 * @return void
 */
function language_selector_plugins_boot() {
	language_selector_set_logged_out_user_language();
	elgg_extend_view("css/elgg", "language_selector/css/site");
}

/**
 * Extends the header with the language selector
 * 
 * @return void
 */
function language_selector_pagesetup() {
	if (elgg_get_plugin_setting("show_in_header", "language_selector") == "yes") {
		elgg_extend_view("page/elements/header", "language_selector/default");
	}
}

// register hooks
elgg_register_plugin_hook_handler("all", "plugin", "language_selector_invalidate_setting");

// register events
elgg_register_event_handler("language:merge", "translation_editor", "language_selector_invalidate_setting");
elgg_register_event_handler("all", "plugin", "language_selector_invalidate_setting");

// Default event handlers for plugin functionality
elgg_register_event_handler('plugins_boot', 'system', 'language_selector_plugins_boot');
elgg_register_event_handler('pagesetup', 'system', 'language_selector_pagesetup');
elgg_register_event_handler('upgrade', 'system', 'language_selector_invalidate_setting');

// actions
elgg_register_action('language_selector/change', dirname(__FILE__) . '/actions/change.php', "logged_in");
