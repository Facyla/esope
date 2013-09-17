<?php
/**
 * access_icons
 *
 * @package access_icons
 *
 */

elgg_register_event_handler('init', 'system', 'access_icons_init');

/**
 * Init plugin.
 */
function access_icons_init() {
	
	elgg_extend_view('css', 'access_icons/css');
	
}


