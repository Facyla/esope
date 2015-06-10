<?php
/* Notes
 * General vocabulary is :
 * poll => survey
 * question => question
 * vote => response (annotation "response", action "response", responded)
 */


elgg_register_event_handler('init','system','survey_init');

function survey_init() {

	elgg_register_library('elgg:survey', elgg_get_plugins_path() . 'survey/lib/survey/functions.php');

	// Set up menu
	elgg_register_menu_item('site', array('name' => 'survey', 'href' => 'survey/all', 'text' => elgg_echo('survey')));

	// Extend system CSS with our own styles, which are defined in the survey/css view
	elgg_extend_view('css/elgg','survey/css');

	// Extend hover-over menu
	elgg_extend_view('profile/menu/links','survey/menu');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('survey','survey_page_handler');

	// Register a URL handler for survey posts
	elgg_register_entity_url_handler('object','survey','survey_url');
	//elgg_register_plugin_hook_handler('entity:url', 'object', 'survey_url'); // Elgg 1.10

	// notifications
	$send_notification = elgg_get_plugin_setting('send_notification', 'survey');
	if (!$send_notification || $send_notification != 'no') {
		register_notification_object('object', 'survey', elgg_echo('survey:new'));
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'survey_prepare_notification');
		//elgg_register_notification_event('object', 'survey'); // Elgg 1.10
		//elgg_register_plugin_hook_handler('prepare', 'notification:create:object:survey', 'survey_prepare_notification'); // Elgg 1.10
	}

	// add link to owner block
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'survey_owner_block_menu');

	// Register entity type
	elgg_register_entity_type('object','survey');

	// register the JavaScript (autoloaded in 1.10)
	$js = elgg_get_simplecache_url('js', 'survey/survey');
	elgg_register_simplecache_view('js/survey/survey');
	elgg_register_js('elgg.survey.survey', $js);
	$js = elgg_get_simplecache_url('js', 'survey/edit');
	elgg_register_simplecache_view('js/survey/edit');
	elgg_register_js('elgg.survey.edit', $js);

	// add group widget
	$group_survey = elgg_get_plugin_setting('group_survey', 'survey');
	if (!$group_survey || $group_survey != 'no') {
		elgg_extend_view('groups/tool_latest', 'survey/group_module');
	}

	if (!$group_survey || ($group_survey == 'yes_default')) {
		add_group_tool_option('survey', elgg_echo('survey:enable_survey'), true);
	} else if ($group_survey == 'yes_not_default') {
		add_group_tool_option('survey', elgg_echo('survey:enable_survey'), false);
	}

	//add widgets
	// @TODO
	/*
	elgg_register_widget_type('survey', elgg_echo('survey:my_widget_title'), elgg_echo('survey:my_widget_description'));
	elgg_register_widget_type('latestsurvey', elgg_echo('survey:latest_widget_title'), elgg_echo('survey:latest_widget_description'), array("dashboard"));
	$survey_front_page = elgg_get_plugin_setting('front_page','survey');
	if($survey_front_page == 'yes') {
		elgg_register_widget_type('survey_individual', elgg_echo('survey:individual'), elgg_echo('survey_individual:widget:description'), array("dashboard"));
	}
	if (elgg_is_active_plugin('widget_manager')) {
		elgg_register_widget_type('latestsurvey_index', elgg_echo('survey:latest_widget_title'), elgg_echo('survey:latest_widget_description'), array("index"));
		if (!$group_survey || $group_survey != 'no') {
			elgg_register_widget_type('latestgroupsurvey', elgg_echo('survey:latestgroup_widget_title'), elgg_echo('survey:latestgroup_widget_description'), array("groups"));
		}
		if($survey_front_page == 'yes') {
			elgg_register_widget_type('survey_individual_index', elgg_echo('survey:individual'), elgg_echo('survey_individual:widget:description'), array("index"));
		}

		//register title urls for widgets
		elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "survey_widget_urls", 499);
		//elgg_register_plugin_hook_handler("entity:url", "object", "survey_widget_urls"); // Elgg 1.10
	}
	*/

	// Register actions
	$action_path = elgg_get_plugins_path() . 'survey/actions/survey';
	elgg_register_action("survey/edit","$action_path/edit.php");
	elgg_register_action("survey/delete","$action_path/delete.php");
	elgg_register_action("survey/response","$action_path/response.php");
}


/**
 * survey page handler; allows the use of fancy URLs
 *
 * @param array $page From the page_handler function
 * @return true|false Depending on success
 */
function survey_page_handler($page) {
	elgg_load_library('elgg:survey');
	elgg_push_breadcrumb(elgg_echo('item:object:survey'), "survey/all");
	$page_type = $page[0];
	if (empty($page_type)) $page_type = 'all';
	switch($page_type) {
		case "view":
			echo survey_get_page_view($page[1]);
			break;
		case "all":
			echo survey_get_page_list($page_type);
			break;
		case "add":
		case "edit":
			$container = null;
			if (isset($page[1])){ $container = $page[1]; }
			echo survey_get_page_edit($page_type, $container);
			break;
		case "results":
			$guid = $filter = $filter_guid = false;
			if (isset($page[1])){ $guid = $page[1]; }
			if (isset($page[2])){ $filter = $page[2]; }
			if (isset($page[3])){ $filter_guid = $page[3]; }
			echo survey_get_page_results($guid, $filter, $filter_guid);
			break;
		case "export":
			$guid = false;
			if (isset($page[1])){ $guid = $page[1]; }
			echo survey_get_page_export($guid);
			break;
		case "friends":
		case "owner":
			$username = $page[1];
			$user = get_user_by_username($username);
			$user_guid = $user->guid;
			echo survey_get_page_list($page_type, $user_guid);
			break;
		case "group":
			echo survey_get_page_list($page_type, $page[1]);
			break;
		default:
			$user = get_user_by_username($page_type);
			if ($user instanceof ElggUser) {
				if (isset($page[1])) {
					switch($page[1]) {
						case "read":
							forward("/survey/view/{$page[2]}");
							break;
						case "friends":
							forward("/survey/friends/{$user->username}");
							break;
					}
				// If the URL is just 'survey/username' forward to surveys page of this user
				} else {
					forward("/survey/owner/{$user->username}");
					break;
				}
			}
			return false;
			break;
	}
	return true;
}


/**
 * Return the url for survey objects
 */
function survey_url($survey) {
	$title = elgg_get_friendly_title($survey->title);
	return  "survey/view/" . $survey->guid . "/" . $title;
}
/* Elgg 1.10
function survey_url($hook, $type, $url, $params) {
	$survey = $params['entity'];
	if ($survey instanceof Survey) {
		if (!$survey->getOwnerEntity()) {
			// default to a standard view if no owner.
			return false;
		}
		$title = elgg_get_friendly_title($survey->title);
		return "survey/view/" . $survey->guid . "/" . $title;
	}
}
*/

/**
 * Add a menu item to an owner block
 */
function survey_owner_block_menu($hook, $type, $return, $params) {
	if ($params['entity'] instanceof ElggUser) {
		$url = "survey/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('survey', elgg_echo('survey'), $url);
		$return[] = $item;
	} else {
		elgg_load_library('elgg:survey');
		if (survey_activated_for_group($params['entity'])) {
			$url = "survey/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('survey', elgg_echo('survey:group_survey'), $url);
			$return[] = $item;
		}
	}
	return $return;
}

/**
 * Prepare a notification message about a created survey
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg_Notifications_Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg_Notifications_Notification
 */
/* Elgg 1.10
function survey_prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];

	$notification->subject = elgg_echo('survey:notify:subject', array($entity->title), $language);
	$notification->body = elgg_echo('survey:notify:body', array(
		$owner->name,
		$entity->title,
		$entity->getURL()
	), $language);
	$notification->summary = elgg_echo('survey:notify:summary', array($entity->title), $language);

	return $notification;
}
*/
function survey_prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (elgg_instanceof($entity, 'object', 'survey')) {
		$user = elgg_get_logged_in_user_entity();
		if (!$user) {
			$user = $entity->getOwnerEntity();
		}
		return elgg_echo('survey:notify:body', array($user->name, $entity->title, $entity->getURL()));
	}
	return null;
}

function survey_widget_urls($hook_name, $entity_type, $return_value, $params){
	$result = $return_value;
	$widget = $params["entity"];

	if(empty($result) && ($widget instanceof ElggWidget)) {
		$owner = $widget->getOwnerEntity();
		switch($widget->handler) {
			case "survey":
				if($owner instanceof ElggUser){
					$result = "/survey/owner/{$owner->username}/all";
				} else {
					$result = "/survey/all";
				}
				break;
			case "latestsurvey":
			case "survey_individual":
			case "latestsurvey_index":
			case "survey_individual_index":
				$result = "/survey/all";
				break;
			case "latestgroupsurvey":
				if($owner instanceof ElggGroup){
					$result = "/survey/group/{$owner->guid}/all";
				} else {
					$result = "/survey/owner/{$owner->username}/all";
				}
				break;
		}
	}
	return $result;
}


