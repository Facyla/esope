<?php

elgg_register_event_handler('init', 'system', 'announcements_init');


function announcements_init() {
	elgg_register_entity_type('object', 'announcement');

	$actions_dir = elgg_get_plugins_path() . "announcements/actions/announcements";

	add_subtype('object', 'announcement', 'ElggAnnouncement');
	
	elgg_register_action("announcements/save", "$actions_dir/save.php");
	elgg_register_action("announcements/delete", "$actions_dir/delete.php");

	elgg_register_page_handler('announcements', 'announcements_page_handler');

	// Register a URL handler for announcements
	//elgg_register_entity_url_handler('object', 'announcement', 'announcements_url_handler');
	elgg_register_plugin_hook_handler('entity:url', 'object', 'announcements_set_url');

	//register_notification_object('object', 'announcement', elgg_echo('announcement:new'));
	//elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'announcements_notify_message');
	elgg_register_notification_event('object', 'announcement', array('create'));
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:announcement', 'announcements_prepare_notification');
	
	// Register for search.
	elgg_register_entity_type('object', 'announcement');

	// Add group option
	add_group_tool_option('announcements', elgg_echo('announcements:enableannouncements'), true);
	elgg_extend_view('groups/tool_latest', 'announcements/group_module');
	
	// Add menus
	elgg_register_plugin_hook_handler('register', 'menu:page', 'announcements_page_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'announcements_owner_block_menu');
	
	// Modify recipients depending on plugin settings
	elgg_register_plugin_hook_handler('get', 'subscriptions', 'announcements_get_subscriptions');
	
}


/**
 * Populates the ->getUrl() method for announcement objects
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string announcement URL
 */
function announcements_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'announcement')) {
		$title = elgg_get_friendly_title($entity->title);
		return "announcements/view/" . $entity->getGUID() . "/" . $title;
	}
}


/**
 * @todo Need to find a way to update for Elgg 1.8 urls
 */
function announcements_page_handler($page) {

	// push all announcements breadcrumb
	elgg_push_breadcrumb(elgg_echo('announcements:announcements'), "announcements/all");

	$page_type = $page[0];
	
	$pages_dir = elgg_get_plugins_path() . 'announcements/pages/announcements';
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
		case 'friends':
			require_once "$pages_dir/friends.php";
			break;
		case 'owner':
			set_input('username', $page[1]);
			require_once "$pages_dir/owner.php";
			break;
		case 'group':
			require_once "$pages_dir/group.php";
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


/**
 * Add a page menu menu.
 *
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function announcements_page_menu($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		if (elgg_in_context('messages')) {
			$title = elgg_echo('announcements:announcements');
			$return[] = new ElggMenuItem('announcements', $title, 'announcements/inbox/');
		}
	}
	return $return;
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


/**
 * Prepare a notification message about a new announcement
 * 
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg\Notifications\Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg\Notifications\Notification
 */
function announcements_prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];

	$descr = $entity->description;
	$title = $entity->title;
	$container_name = $entity->getContainerEntity()->name;

	$notification->subject = elgg_echo('announcements:notify:subject', array($title, $container_name), $language); 
	$notification->body = elgg_echo('announcements:notify:body', array(
		$owner->name,
		$container_name,
		$title,
		$descr,
		$entity->getURL()
	), $language);
	$notification->summary = elgg_echo('announcements:notify:summary', array($entity->title), $language);

	return $notification;
}


/**
 * Get subscriptions for group notifications
 *
 * @param string $hook          'get'
 * @param string $type          'subscriptions'
 * @param array  $subscriptions Array containing subscriptions in the form
 *                       <user guid> => array('email', 'site', etc.)
 * @param array  $params        Hook parameters
 * @return array
 */
function announcements_get_subscriptions($hook, $type, $subscriptions, $params) {
	$object = $params['event']->getObject();

	if (!elgg_instanceof($object, 'object', 'announcement')) {
		return $subscriptions;
	}
	
	// Force to all group members
	$group_recipients = elgg_get_plugin_setting('group_recipients', 'announcements', 'default');
	if ($group_recipients == 'email_members') {
		$group = $object->getContainerEntity();
		if (elgg_instanceof($group, 'group')) {
			$group_subscriptions = array();
			$method = array('email');
			$group_members = $group->getMembers(array('limit' => false));
			foreach ($group_members as $ent) {
				if (!$ent->isBanned()) {
					$group_subscriptions[$ent->guid] = $method;
				}
			}
			return $group_subscriptions;
		}
	}
	return $subscriptions;
}



