<?php

// register for events
elgg_register_event_handler('init','system','rssimport_init');


// our init function
function rssimport_init() {
	include_once 'lib/functions.php';
	
	// Top-level access control : feature is not loaded at all if we do not have the rights
	// but we might not have all infos for that yet...
	if (!rssimport_can_use()) { return; }

	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg', 'rssimport/css');
	
	// extend js with our own
	//elgg_extend_view('js/elgg', 'rssimport/js');
	$js = elgg_get_simplecache_url('js', 'rssimport/js');
	elgg_register_simplecache_view('js/rssimport/js');
	elgg_register_js('rssimport.js', $js);
	
	
	//register our actions
	$action_path = dirname(__FILE__) . '/actions/';
	elgg_register_action("rssimport/add", $action_path . "add.php");
	elgg_register_action("rssimport/delete", $action_path . "delete.php");
	elgg_register_action("rssimport/import", $action_path . "import.php");
	elgg_register_action("rssimport/blacklist", $action_path . "blacklist.php");
	elgg_register_action("rssimport/undoimport", $action_path . "undoimport.php");

	// register page handler
	elgg_register_page_handler('rssimport','rssimport_page_handler');
	
	// register our hooks
	elgg_register_plugin_hook_handler('cron', 'all', 'rssimport_cron');
	elgg_register_plugin_hook_handler('permissions_check', 'all', 'rssimport_permissions_check');
	elgg_register_plugin_hook_handler('object:notifications', 'all', 'rssimport_prevent_notification', 1);

	// create import urls
	elgg_register_entity_url_handler('object', 'rssimport', 'rssimport_url_handler');
	
	// add group configurations for enabled tools
	$types = array('blog', 'bookmarks', 'pages');
	foreach ($types as $type) {
		$tool_enabled = elgg_get_plugin_setting($type . '_enable', 'rssimport');
		if (($tool_enabled == 'yes') && elgg_is_active_plugin($type)) {
			add_group_tool_option('rssimport_' . $type, elgg_echo('rssimport:enable'.$type), true);
		}
	}
	
	elgg_register_event_handler('pagesetup','system','rssimport_pagesetup');
}


// page structure for imports <url>/rssimport/<container_guid>/<context>/<rssimport_guid>
// history: <url>/rssimport/<container_guid>/<context>/<rssimport_guid>/history
function rssimport_page_handler($page){
	gatekeeper();
	
	// Container GUID
	if(is_numeric($page[0])){
		$container = get_entity($page[0]);
		if (!$container) { return FALSE; }
		elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
		
		// set up breadcrumbs
		if (elgg_instanceof($container, 'user')) {
			$urlsuffix = 'owner/' . $container->username;
			$name = $container->username;
		} elseif (elgg_instanceof($container, 'group')) {
			rssimport_group_gatekeeper($container, $page[1]);
			$urlsuffix = 'group/' . $container->guid . '/all';
			$name = $container->name;
		}
		$url = elgg_get_site_url() . "{$page[1]}/{$urlsuffix}";
		
		// push original context
		elgg_push_breadcrumb(elgg_echo($page[1]), $url);
		
		// push import
		elgg_push_breadcrumb(elgg_echo('rssimport:import'), elgg_get_site_url() . "rssimport/{$page[0]}/{$page[1]}");
		
		
		// rssimport guid, set breadcrumbs and page owner
		if ($page[2]) {
			$url = '';
			if (!$rssimport = get_entity($page[2])) { return FALSE; }
			$name = $rssimport->title;
			
			// Calls history (any value does)
			if ($page[3]) {
				$url = elgg_get_site_url() . "rssimport/{$page[0]}/{$page[1]}/{$page[2]}";
				elgg_push_breadcrumb($name, $url);
				elgg_push_breadcrumb(elgg_echo('rssimport:history'));
				if (!$rssimport->canEdit()) { return FALSE; }
				
				// we're checking history
				set_input('rssimport_guid', $page[2]);
				elgg_set_context('rssimport_history');
				if(!include dirname(__FILE__) . '/pages/history.php'){ return FALSE; }
				return TRUE;
			} else {
				elgg_push_breadcrumb($name, $url);
			}
		}
		
		// import view or form
		set_input('container_guid', $page[0]);
		set_input('import_into', $page[1]);
		set_input('rssimport_guid', $page[2]);
		if(!include dirname(__FILE__) . '/pages/rssimport.php'){ return FALSE; }
		return TRUE;
	}
	
	return FALSE;
}


// Add import links to submenus
function rssimport_pagesetup() {
	// Get the page owner entity
	$createlink = false;
	$page_owner = elgg_get_page_owner_entity();
	
	$context = elgg_get_context();
	$rssimport_guid = get_input('rssimport_guid');
	$rssimport = get_entity($rssimport_guid);

	// Submenu items for group pages, if logged in and context is one of our imports
	if (elgg_is_logged_in()) {
		if (!$page_owner) {
			$page_owner = elgg_get_logged_in_user_entity();
			$createlink = true;
		}
	
		// if we're on a group page, check that the user is a member of the group
		if (elgg_instanceof($page_owner, 'group', '', 'ElggGroup')) {
			if ($page_owner->isMember() && rssimport_group_gatekeeper($page_owner, $context, FALSE)) {
				// Check if restricted to group admins
				if (rssimport_can_use($page_owner)) { $createlink = true; }
			}
		} else {
			// Check if personnal import is allowed
			// if we are the owner
			if (rssimport_can_use($page_owner)) {
				if ($page_owner->guid == elgg_get_logged_in_user_guid() ) { $createlink = true; }
			}
		}
	}
	
	if ($createlink) {
		elgg_register_menu_item('title', array(
				'name' => 'rssimport',
				'href' => 'rssimport/' . $page_owner->guid . '/' . $context,
				'text' => elgg_echo('rssimport:import:rss'),
				'class' => 'elgg-button elgg-button-action',
				'contexts' => array('blog', 'pages', 'bookmarks')
		));
	}
	
	// create "back" link on import page - go back to blogs/pages/etc.
	if (elgg_is_logged_in() && $context == "rssimport") {
		//have to parse URL to figure out what page type and owner to send them back to
		//this function does it, and returns an array('link_text','url')
		$linkparts = rssimport_get_return_url();

		$item = new ElggMenuItem('rssimport_back', $linkparts[0], $linkparts[1]);
		elgg_register_menu_item('page', $item);
	}
	
	// create link to "View History" on import page
	if (elgg_is_logged_in() && $context == "rssimport" && $rssimport && $rssimport->canEdit()) {
		$item = new ElggMenuItem('rssimport_history', elgg_echo('rssimport:view:history'), $rssimport->getURL() . "/history");
		elgg_register_menu_item('page', $item);
	}
	

	// create link to "View Import" on history page
	if (elgg_is_logged_in() && $context == "rssimport_history" && $rssimport) {
		$item = new ElggMenuItem('rssimport_view', elgg_echo('rssimport:view:import'), $rssimport->getURL());
		elgg_register_menu_item('page', $item);
	}
}


// Import URL
function rssimport_url_handler($rssimport) {
	$container = $rssimport->getContainerEntity();
	return elgg_get_site_url() . "rssimport/{$container->guid}/{$rssimport->import_into}/{$rssimport->guid}";
}


// determine if the logged in user can use rssimport
// $container : optional container for use
function rssimport_can_use($container = false) {
	// admin can always use it
	if (elgg_is_admin_logged_in()) { return true; }
	
	// is this a cron call?
	if (elgg_get_context() == 'cron') { return true; }
	
	// Group container : control import in groups (members / groupadmins / admins)
	if (elgg_instanceof($container, 'group')) {
		$group_role = elgg_get_plugin_setting('group_role', 'rssimport');
		if ($group_role == 'admin') {
			return false;
		} else if ($group_role == 'groupadmin') {
			if ($container->canEdit()) return true;
		} else {
			if ($container->isMember()) return true;
		}
		return false;
	}
	
	if (elgg_instanceof($container, 'user')) {
		// Other (user) container : do we allow personal import tools?
		$user_role = elgg_get_plugin_setting('user_role', 'rssimport');
		if ($user_role == 'no') { return false; }
	}
	
	// Allow in other cases ? (or should we block and check if not logged in ?)
	return true;
}


