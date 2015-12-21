<?php
/**
 * Main file for the Font Awesome plugin
 */

require_once(dirname(__FILE__) . "/lib/functions.php");

// register default Elgg events
elgg_register_event_handler("init", "system", "fontawesome_init");

/**
 * Gets called when the Elgg system initializes
 *
 * @return void
 */
function fontawesome_init() {
	
	// add CSS / JS
	elgg_extend_view("css/elements/forms", "css/fontawesome/forms");
	elgg_extend_view("css/admin", "css/fontawesome/admin");
	
	// register css
	elgg_register_css("fontawesome", "mod/fontawesome/vendor/fortawesome/font-awesome/css/font-awesome.min.css");
	elgg_load_css("fontawesome");
}
