<?php

namespace AU\ViewsCounter;

const PLUGIN_ID = 'views_counter';

require_once __DIR__ . '/lib/functions.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

/**
 * INIT
 */
function init() {
	// Try to add a views counter for the entities selected through the plugin settings
	set_views_counter();

	elgg_extend_view('css/elgg', 'css/views_counter');
	elgg_extend_view('css/admin', 'css/views_counter');

	elgg_register_action('views_counter/settings/save', __DIR__ . '/actions/views_counter/settings/save.php', 'admin');
	
	elgg_register_admin_menu_item('administer', 'views_counter', 'statistics');
}


