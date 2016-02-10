<?php

namespace AU\RSSImport;

const PLUGIN_ID = 'rssimport';
const PLUGIN_VERSION = 20151008;

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/events.php';
require_once __DIR__ . '/vendor/autoload.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

// our init function
function init() {

	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg', 'css/rssimport');

	if (!RSSImport::canUse()) {
		return;
	}

	//register our actions
	elgg_register_action("rssimport/edit", __DIR__ . "/actions/edit.php");
	elgg_register_action("rssimport/delete", __DIR__ . "/actions/delete.php");
	elgg_register_action("rssimport/import", __DIR__ . "/actions/import.php");
	elgg_register_action("rssimport/blacklist", __DIR__ . "/actions/blacklist.php");
	elgg_register_action("rssimport/undoimport", __DIR__ . "/actions/undoimport.php");

	// register page handler
	elgg_register_page_handler('rssimport', __NAMESPACE__ . '\\rssimport_page_handler');

	// register our hooks
	elgg_register_plugin_hook_handler('cron', 'daily', __NAMESPACE__ . '\\daily_cron');
	elgg_register_plugin_hook_handler('cron', 'hourly', __NAMESPACE__ . '\\hourly_cron');
	elgg_register_plugin_hook_handler('cron', 'weekly', __NAMESPACE__ . '\\weekly_cron');
	elgg_register_plugin_hook_handler('permissions_check', 'all', __NAMESPACE__ . '\\permissions_check');
	elgg_register_plugin_hook_handler('entity:url', 'object', __NAMESPACE__ . '\\rssimport_url');

	elgg_register_plugin_hook_handler('enqueue', 'notification', __NAMESPACE__ . '\\prevent_notifications', 1000);


	// add group configurations
	$types = array('blog', 'bookmarks', 'pages');
	foreach ($types as $type) {
        $enable = elgg_get_plugin_setting($type . '_enable', PLUGIN_ID);
		if (elgg_is_active_plugin($type) && $enable != 'no') {
			add_group_tool_option('rssimport_' . $type, elgg_echo('rssimport:enable' . $type), true);
		}
	}

	elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\pagesetup');
	elgg_register_event_handler('upgrade', 'system', __NAMESPACE__ . '\\upgrades');
}

/**
 * page structure for imports <url>/rssimport/<container_guid>/<context>/<rssimport_guid>
 * history: <url>/rssimport/<container_guid>/<context>/<rssimport_guid>/history
 * 
 * @param type $page
 * @return boolean
 */
function rssimport_page_handler($page) {
	elgg_gatekeeper();
	
	if ($page[3] == 'history') {
		elgg_set_page_owner_guid($page[0]);
		set_input('rssimport_guid', $page[2]);
		$content = elgg_view('resources/rssimport/history', array(
			'container_guid' => $page[0],
			'import_into' => $page[1],
			'guid' => $page[2]
		));
	}
	else {
		elgg_set_page_owner_guid($page[0]);
		set_input('rssimport_guid', $page[2]);
		$content = elgg_view('resources/rssimport/import', array(
			'container_guid' => $page[0],
			'import_into' => $page[1],
			'guid' => $page[2]
		));
	}
	
	if ($content) {
		echo $content;
		return true;
	}
	
	return false;
}
