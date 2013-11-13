<?php
function announcements_init() {
	elgg_register_entity_type('object', 'announcement');

	$actions_dir = dirname(__FILE__) . "/actions";

	add_subtype('object', 'announcement', 'ElggAnnouncement');
	
	elgg_register_action("announcements/save", "$actions_dir/announcements/save.php");
	elgg_register_action("announcements/delete", "$actions_dir/announcements/delete.php");

	elgg_register_page_handler('announcements', 'announcements_page_handler');

	elgg_register_entity_url_handler('object', 'announcement', 'announcements_url_handler');

	register_notification_object('object', 'announcement', elgg_echo('announcement:new'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'announcements_notify_message');
	
	// add blog link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'announcements_owner_block_menu');

	// Register for search.
	elgg_register_entity_type('object', 'blog');

	// Add group option
	add_group_tool_option('announcements', elgg_echo('announcements:enableannouncements'), true);
	elgg_extend_view('groups/tool_latest', 'announcements/group_module');
	
	elgg_register_menu_item('page', array(
		'name' => 'announcements',
		'href' => '/announcements/inbox',
		'text' => elgg_echo('announcements:announcements'),
		'priority' => 500,
		'context' => 'messages',
	));
}

function announcements_url_handler($announcement) {
	return "/announcements/view/$announcement->guid/" . elgg_get_friendly_title($announcement->title);
}

/**
 * @todo Need to find a way to update for Elgg 1.8 urls
 */
function announcements_page_handler($page) {

	// push all blogs breadcrumb
	elgg_push_breadcrumb(elgg_echo('announcements:announcements'), "announcements/all");

	$page_type = $page[0];
	
	$pages_dir = dirname(__FILE__) . '/pages/announcements';
	switch ($page_type) {
		case 'view':
			set_input('guid', $page[1]);
			require_once "$pages_dir/view.php";
			break;
		case 'add':
			gatekeeper();
			require_once "$pages_dir/add.php";
			break;
		case 'edit':
			gatekeeper();
			set_input('guid', $page[1]);
			require_once "$pages_dir/edit.php";
			break;
		// @TODO case owner et friends
		case 'group':
			require_once "$pages_dir/owner.php";
			break;
		case 'inbox':
			elgg_push_context('messages');
			elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
			require_once "$pages_dir/inbox.php";
			elgg_pop_context();
			break;
		case 'all':
			require_once "$pages_dir/all.php";
			break;
		default:
			break;
	}
	return true; // Facyla 20111123
}

function announcements_owner_block_menu($hook, $type, $items, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'group')  && $entity->announcements_enable != 'no') {
		$items[] = ElggMenuItem::factory(array(
			'name' => 'announcements',
			'text' => elgg_echo('announcements:group'),
			'href' => "/announcements/group/$entity->guid/all",
		));
	}

	return $items;
}

elgg_register_event_handler('init', 'system', 'announcements_init');

