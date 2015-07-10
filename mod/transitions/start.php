<?php
/**
 * Transitions
 *
 * @package Transitions
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 */

elgg_register_event_handler('init', 'system', 'transitions_init');

/**
 * Init transitions plugin.
 */
function transitions_init() {

	elgg_register_library('elgg:transitions', elgg_get_plugins_path() . 'transitions/lib/transitions.php');

	// add a site navigation item
	$item = new ElggMenuItem('transitions', elgg_echo('transitions:transitions'), 'transitions/all');
	elgg_register_menu_item('site', $item);

	elgg_register_event_handler('upgrade', 'upgrade', 'transitions_run_upgrades');

	// add to the main css
	elgg_extend_view('css/elgg', 'transitions/css');

	// routing of urls
	elgg_register_page_handler('transitions', 'transitions_page_handler');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "transitions_icon_hook");

	// override the default url to view a transitions object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'transitions_set_url');

	// notifications
	elgg_register_notification_event('object', 'transitions', array('publish'));
	elgg_register_plugin_hook_handler('prepare', 'notification:publish:object:transitions', 'transitions_prepare_notification');

	// add transitions link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'transitions_owner_block_menu');

	// pingbacks
	//elgg_register_event_handler('create', 'object', 'transitions_incoming_ping');
	//elgg_register_plugin_hook_handler('pingback:object:subtypes', 'object', 'transitions_pingback_subtypes');

	// Register for search.
	elgg_register_entity_type('object', 'transitions');

	// Add group option
	add_group_tool_option('transitions', elgg_echo('transitions:enabletransitions'), true);
	elgg_extend_view('groups/tool_latest', 'transitions/group_module');

	// add a transitions widget
	elgg_register_widget_type('transitions', elgg_echo('transitions'), elgg_echo('transitions:widget:description'));

	// register actions
	$action_path = elgg_get_plugins_path() . 'transitions/actions/transitions';
	// Quickform is a light contribution form that quickly creates a draft
	elgg_register_action('transitions/save', "$action_path/save.php");
	elgg_register_action('transitions/auto_save_revision', "$action_path/auto_save_revision.php");
	elgg_register_action('transitions/delete', "$action_path/delete.php");
	
	// Note : add , 'public' to allow onyone to use action
	elgg_register_action('transitions/quickform', "$action_path/save.php");
	elgg_register_action('transitions/addtag', "$action_path/addtag.php");
	elgg_register_action('transitions/addlink', "$action_path/addlink.php");

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'transitions_entity_menu_setup');

	// ecml
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'transitions_ecml_views_hook');
}

/**
 * Dispatches transitions pages.
 * URLs take the form of
 *  All transitions:       transitions/all
 *  User's transitions:    transitions/owner/<username>
 *  Friends' transitions:   transitions/friends/<username>
 *  User's archives: transitions/archives/<username>/<time_start>/<time_stop>
 *  Transitions post:       transitions/view/<guid>/<title>
 *  New post:        transitions/add/<guid>
 *  Edit post:       transitions/edit/<guid>/<revision>
 *  Preview post:    transitions/preview/<guid>
 *  Group transitions:      transitions/group/<guid>/all
 *
 * Title is ignored
 *
 * @todo no archives for all transitions or friends
 *
 * @param array $page
 * @return bool
 */
function transitions_page_handler($page) {

	elgg_load_library('elgg:transitions');

	// push all transitions breadcrumb
	elgg_push_breadcrumb(elgg_echo('transitions:transitions'), "transitions/all");

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			if (!$user) {
				forward('', '404');
			}
			$params = transitions_get_page_content_list($user->guid);
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			if (!$user) {
				forward('', '404');
			}
			$params = transitions_get_page_content_friends($user->guid);
			break;
		case 'archive':
			$user = get_user_by_username($page[1]);
			if (!$user) {
				forward('', '404');
			}
			$params = transitions_get_page_content_archive($user->guid, $page[2], $page[3]);
			break;
		case 'view':
			$params = transitions_get_page_content_read($page[1]);
			break;
		case 'add':
			elgg_gatekeeper();
			$params = transitions_get_page_content_edit($page_type, $page[1]);
			break;
		case 'edit':
			elgg_gatekeeper();
			$params = transitions_get_page_content_edit($page_type, $page[1], $page[2]);
			break;
		case 'group':
			$group = get_entity($page[1]);
			if (!elgg_instanceof($group, 'group')) {
				forward('', '404');
			}
			if (!isset($page[2]) || $page[2] == 'all') {
				$params = transitions_get_page_content_list($page[1]);
			} else {
				$params = transitions_get_page_content_archive($page[1], $page[3], $page[4]);
			}
			break;
		case 'icon':
			// The username should be the file we're getting
			if (isset($page[1])) { set_input("guid",$page[1]); }
			if (isset($page[2])) { set_input("size",$page[2]); }
			include(elgg_get_plugins_path() . "transitions/pages/transitions/icon.php");
			return true;
			break;
		case 'download':
			// The username should be the file we're getting
			if (isset($page[1])) { set_input("guid",$page[1]); }
			if (isset($page[2])) { set_input("name",$page[2]); }
			include(elgg_get_plugins_path() . "transitions/pages/transitions/attachment.php");
			return true;
			break;
		case 'all':
			//$params = transitions_get_page_content_list();
		default:
			if ($page[0] != 'all') { set_input("category",$page[0]); }
			if (isset($page[1])) { set_input("q",$page[1]); }
			include(elgg_get_plugins_path() . "transitions/pages/transitions/index.php");
			return true;
	}

	if (isset($params['sidebar'])) {
		$params['sidebar'] .= elgg_view('transitions/sidebar', array('page' => $page_type));
	} else {
		$params['sidebar'] = elgg_view('transitions/sidebar', array('page' => $page_type));
	}

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);
	return true;
}



/**
 * Format and return the URL for transitions.
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of transitions.
 */
function transitions_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'transitions')) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return "transitions/view/{$entity->guid}/$friendly_title";
	}
}

/**
 * Add a menu item to an ownerblock
 */
function transitions_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "transitions/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('transitions', elgg_echo('transitions'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->transitions_enable != "no") {
			$url = "transitions/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('transitions', elgg_echo('transitions:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular transitions links/info to entity menu
 */
function transitions_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'transitions') {
		return $return;
	}

	if ($entity->status != 'published') {
		// draft status replaces access
		foreach ($return as $index => $item) {
			if ($item->getName() == 'access') {
				unset($return[$index]);
			}
		}

		$status_text = elgg_echo("status:{$entity->status}");
		$options = array(
			'name' => 'published_status',
			'text' => "<span>$status_text</span>",
			'href' => false,
			'priority' => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}

/**
 * Prepare a notification message about a published transitions
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg\Notifications\Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg\Notifications\Notification
 */
function transitions_prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];

	$notification->subject = elgg_echo('transitions:notify:subject', array($entity->title), $language);
	$notification->body = elgg_echo('transitions:notify:body', array(
		$owner->name,
		$entity->title,
		$entity->getExcerpt(),
		$entity->getURL()
	), $language);
	$notification->summary = elgg_echo('transitions:notify:summary', array($entity->title), $language);

	return $notification;
}

/**
 * Register transitions with ECML.
 */
function transitions_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/transitions'] = elgg_echo('transitions:transitions');

	return $return_value;
}

/**
 * Upgrade from 1.7 to 1.8.
 */
function transitions_run_upgrades($event, $type, $details) {
	$transitions_upgrade_version = elgg_get_plugin_setting('upgrade_version', 'transitions');

	if (!$transitions_upgrade_version) {
		 // When upgrading, check if the ElggTransitions class has been registered as this
		 // was added in Elgg 1.8
		if (!update_subtype('object', 'transitions', 'ElggTransitions')) {
			add_subtype('object', 'transitions', 'ElggTransitions');
		}

		elgg_set_plugin_setting('upgrade_version', 1, 'transitions');
	}
}

function transitions_icon_hook($hook, $entity_type, $returnvalue, $params) {
	if (!empty($params) && is_array($params)) {
		$entity = $params["entity"];
		if(elgg_instanceof($entity, "object", "transitions")){
			$size = $params["size"];
			if ($icontime = $entity->icontime) {
				$icontime = "{$icontime}";
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getOwnerGUID();
				$filehandler->setFilename("transitions/" . $entity->getGUID() . $size . ".jpg");
				if ($filehandler->exists()) {
					return elgg_get_site_url() . "transitions/icon/{$entity->getGUID()}/$size/$icontime.jpg";
				}
			} else {
				if ($size == 'gallery') return elgg_get_site_url() . "mod/transitions/graphics/icons/gallery.png";
			}
		}
	}
}


/* Renvoie la liste des catégories
 * $addempty : for select dropdowns
 * $full : get all values (useful when not editing)
*/
function transitions_get_category_opt($value = '', $addempty = false, $full = false) {
	$list = array();
	if ($addempty) { $list[''] = ''; }
	$values = array('actor', 'project', 'experience', 'imaginary', 'event', 'tools', 'knowledge');
	foreach($values as $val) { $list[$val] = elgg_echo('transitions:category:' . $val); }
	if (elgg_is_admin_logged_in() || $full) { $list['editorial'] = elgg_echo('transitions:category:editorial'); }
	// Add current value
	if (!empty($value) && !isset($list[$value])) { $list[$value] = elgg_echo('transitions:category:' . $value); }
	return $list;
}

function transitions_get_actortype_opt($value = '', $addempty = false) {
	$list = array();
	if ($addempty) { $list[''] = ''; }
	$values = array('individual', 'collective', 'association', 'enterprise', 'education', 'collectivity', 'administration', 'plurinational');
	foreach($values as $val) { $list[$val] = elgg_echo('transitions:actortype:' . $val); }
	// Add current value
	if (!empty($value) && !isset($list[$value])) { $list[$value] = elgg_echo('transitions:category:' . $value); }
	return $list;
}

function transitions_get_lang_opt($value = '', $addempty = false) {
	$list = array();
	if ($addempty) { $list[''] = ''; }
	$values = array('fr', 'en');
	foreach($values as $val) { $list[$val] = elgg_echo($val); }
	// Add current value
	if (!empty($value) && !isset($list[$value])) { $list[$value] = elgg_echo($value); }
	return $list;
}


