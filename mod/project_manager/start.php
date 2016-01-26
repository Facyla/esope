<?php
/**
 * Elgg project_manager
 * 
 * @package Elggproject_manager
 * @author Facyla
 * @copyright Facyla @ITEMS International 2013
 * @link http://items.fr/
 */


// Make sure project_manager_init is called on initialisation
elgg_register_event_handler('init','system','project_manager_init');


/** project_manager plugin initialisation functions. */
function project_manager_init() {
	
	// ACTIONS
	$action_path = elgg_get_plugins_path() . "project_manager/actions/";
	// Projects
	elgg_register_action("project_manager/new", $action_path . "project_manager/edit.php");
	elgg_register_action("project_manager/edit", $action_path . "project_manager/edit.php");
	elgg_register_action("project_manager/delete", $action_path . "project_manager/delete.php");
	elgg_register_action("project_manager/edit_consultants", $action_path . "project_manager/edit_consultants.php");
	elgg_register_action("project_manager/edit_project_production", $action_path . "project_manager/edit_project_production.php");
	elgg_register_action("project_manager/edit_project_expenses", $action_path . "project_manager/edit_project_expenses.php");
	elgg_register_action("project_manager/edit_all_expenses", $action_path . "project_manager/edit_all_expenses.php");
	// Tasks
	elgg_register_action("tasks/edit", $action_path . "tasks/edit.php");
	elgg_register_action("tasks/delete", $action_path . "tasks/delete.php");
	// Time_tracker
	elgg_register_action("time_tracker/edit", $action_path . "time_tracker/edit.php");
	elgg_register_action("time_tracker/validate", $action_path . "time_tracker/validate.php");
	elgg_register_action("time_tracker/delete", $action_path . "time_tracker/delete.php");
	
	// MENUS
	elgg_register_event_handler('pagesetup','system','project_manager_menu_setup');
	elgg_register_event_handler('pagesetup','system','time_tracker_menu_setup');
	$item = new ElggMenuItem('tasks', elgg_echo('tasks'), 'tasks/all');
	elgg_register_menu_item('site', $item);
	// Gestion du menu personnel
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'project_manager_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'tasks_owner_block_menu');
	// Entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'tasks_entity_menu_setup');
	
	// REGISTER ENTITY TYPES : OBJECTS
	elgg_register_entity_type('object','project_manager'); // Register entity type
	elgg_register_entity_type('object','time_tracker');
	elgg_register_entity_type('object', 'task');
	elgg_register_entity_type('object', 'task_top');
	
	// CSS, JS, HEADERS & METATAGS
	// Headers
	elgg_extend_view('page/elements/head','project_manager/metatags');
	// CSS
	//elgg_extend_view('css', 'project_manager/css'); // Extend CSS
	elgg_extend_view('css/elgg', 'tasks/css');
	// Register CSS needed for sidebar menu
	$css_url = 'mod/project_manager/vendors/jquery-treeview/jquery.treeview.css';
	elgg_register_css('jquery-treeview', $css_url);
	// JS
	// Register javascript needed for sidebar menu
	$js_url = 'mod/project_manager/vendors/jquery-treeview/jquery.treeview.min.js';
	elgg_register_js('jquery-treeview', $js_url);
	
	// URL HANDLERS, so we can have nice URLs
	elgg_register_plugin_hook_handler('entity:url', 'object', 'project_manager_set_url');
	// @TODO : replace annotation url handler by new method
	elgg_register_annotation_url_handler('task', 'tasks_revision_url');
	// @TODO : see extender:url,annotation	500	_elgg_set_comment_url 			pages_set_revision_url
	
	// PAGE HANDLERS
	elgg_register_page_handler('project_manager','project_manager_page_handler'); // Register a page handler, so we can have nice URLs
	elgg_register_page_handler('time_tracker','time_tracker_page_handler');
	elgg_register_page_handler('tasks', 'tasks_page_handler');
	
	// NOTIFICATIONS
	// Register granular notification for this type
	// @TODO replace by new function
	if (is_callable('register_notification_object')) { register_notification_object('object', 'project_manager', elgg_echo('project_manager:notification:title')); }
	// Message content
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'project_manager_notify_message');

	// GROUP TOOLS OPTION
	$pm_meta = project_manager_get_user_metadata();
	if (elgg_is_logged_in() && !empty($_SESSION['user']->{$pm_status})) {
		add_group_tool_option('project_manager',elgg_echo('project_manager:enableproject_manager'),false);
	}
	add_group_tool_option('tasks', elgg_echo('groups:enabletasks'), false);
	elgg_extend_view('groups/tool_latest', 'tasks/group_module');
	
	// SETTINGS SAVE OVERRIDE : On a besoin d'enregistrer des array, ce que le core ne permet pas via les settings
	elgg_register_plugin_hook_handler('action', 'plugins/settings/save', 'project_manager_save_site_project_manager');
	
	// WIDGETS
	//add_widget_type('project_managerrepo',elgg_echo("project_manager:widget"),elgg_echo("project_manager:widget:description")); // Add a new project_manager widget
	elgg_register_widget_type('tasks', elgg_echo('tasks'), elgg_echo('tasks:widget:description'));
	
	/* TASKS */
	// register a library of helper functions
	elgg_register_library('elgg:tasks', elgg_get_plugins_path() . 'project_manager/lib/tasks.php');
	
	// NOTIFICATIONS - Register granular notification for this type
	register_notification_object('object', 'task', elgg_echo('tasks:new'));
	register_notification_object('object', 'task_top', elgg_echo('tasks:new'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'task_notify_message');

	// Language short codes must be of the form "tasks:key"
	// where key is the array key below
	elgg_set_config('tasks', array(
			'title' => 'text',
			'description' => 'longtext',
			'start_date' => 'date',
			'end_date' => 'date',
			'task_type' => 'text',
			'status' => 'text',
			'assigned_to' => 'members_select',
			'percent_done' => 'percentage',
			'work_remaining' => 'percentage',
			'tags' => 'tags',
			'access_id' => 'access',
			'write_access_id' => 'write_access',
		));
	
	// write permission plugin hooks
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'tasks_write_permission_check');
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'tasks_container_permission_check');
	
	// icon url override
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'tasks_icon_url_override');
	
	// register ecml views to parse
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'tasks_ecml_views_hook');
	
	
}



// Define main metadata to use for access management
function project_manager_get_user_metadata() {
	$metadata_name = elgg_get_plugin_setting('user_metadata_name', 'project_manager');
	if (empty($metadata_name)) { $metadata_name = 'project_manager_status'; }
	return $metadata_name;
}


// Define some special statuses
function project_manager_get_special_status() {
	return array('salarie', 'non-salarie');
}


/* MENUS */

/** Sets up menus for the project_manager system.	Triggered on pagesetup. */
function project_manager_menu_setup() {
	$page_owner = elgg_get_page_owner_entity();
	
	// General submenu options
	if (elgg_get_context() == "project_manager") {
		//add_submenu_item(elgg_echo('project_manager:all'), elgg_get_site_url() . "mod/project_manager/world.php");
		elgg_register_menu_item('page', array(
				'href' => 'project_manager', 'name' => 'project_manager',
				'text' => elgg_echo('project_manager:all'),
			));
		/*
		if (can_write_to_container($_SESSION['guid'], elgg_get_page_owner_guid()))
			elgg_register_menu_item('page', array(
					//'href' => 'project_manager/' . elgg_get_logged_in_user_entity()->username . '/new/', 
					'href' => 'project_manager/new', 
					'name' => 'new_project_manager',
					'text' => elgg_echo('project_manager:new'),
				));
		*/
	}
	
	// Group menu
	if (elgg_in_context('groups')) {
		// Ajoute le menu dans un groupe
		if (elgg_instanceof($page_owner, 'group') && ($page_owner->project_manager_enable == "yes")) {
			if (elgg_is_logged_in() && $page_owner->isMember() && project_manager_gatekeeper(false, true, false)) {
				elgg_register_menu_item('page', array(
						'name' => 'project_manager', 'text' => elgg_echo('project_manager:group'),
						'href' => elgg_get_site_url() . "project_manager/group/{$page_owner->getGUID()}",
						'section' => 'project_manager', 'priority' => 900,
					));
				// Si manager du projet, lien de gestion de la production
				if (project_manager_projectdata_gatekeeper($project, elgg_get_logged_in_user_guid())) {
					elgg_register_menu_item('page', array(
							'name' => 'project_manager_production', 'text' => elgg_echo('project_manager:menu:group:production'),
							'href' => elgg_get_site_url() . "project_manager/production/group/{$page_owner->getGUID()}",
							'section' => 'project_manager', 'priority' => 800,
						));
				}
			}
		}
	}
	
	// Set up menu for logged in users
	/*
	$pm_meta = project_manager_get_user_metadata();
	if (elgg_is_logged_in() && !empty($_SESSION['user']->{$pm_meta})) {
		$menu_item = ElggMenuItem::factory(array(
				'name' => 'project_manager',
				'text' => elgg_echo('project_manager'),
				'href' => "/project_manager/" . $_SESSION['user']->username,
			));
		elgg_register_menu_item('project_manager', $menu_item);
	}
	*/
	
}

// Owner_block menu : for user only (already registred in group menu)
function project_manager_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "project_manager/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('project_manager', elgg_echo('project_manager'), $url);
		$return[] = $item;
	}
	return $return;
}


/* Add a menu item to the user ownerblock */
function tasks_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "tasks/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('tasks', elgg_echo('tasks'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->tasks_enable == "yes") {
			$url = "tasks/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('tasks', elgg_echo('tasks:group'), $url);
			$return[] = $item;
		}
	}
	return $return;
}

/* Add links/info to entity menu particular to tasks plugin */
function tasks_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'tasks') { return $return; }

	// remove delete if not owner or admin
	if (!elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != $entity->getOwnerGuid()) {
		foreach ($return as $index => $item) {
			if ($item->getName() == 'delete') { unset($return[$index]); }
		}
	}
	$options = array('name' => 'history', 'priority' => 800, 'href' => "tasks/history/$entity->guid", 'text' => elgg_echo('tasks:history'));
	$return[] = ElggMenuItem::factory($options);
	return $return;
}


/** Sets up menus for the time_tracker system.	Triggered on pagesetup. */
function time_tracker_menu_setup() {
	$page_owner = elgg_get_page_owner_entity();
	// Group menu
	if (elgg_in_context('groups')) {
		//if (($page_owner instanceof ElggGroup) && ($page_owner->time_tracker_enable == "yes")) {
		if (($page_owner instanceof ElggGroup) && (($page_owner->project_manager_enable == "yes") || ($page_owner->time_tracker_enable == "yes")) && project_manager_gatekeeper(false, true, false)) {
			if (elgg_is_logged_in() && $page_owner->isMember()) {
				elgg_register_menu_item('page', array(
						'name' => 'time_tracker', 'text' => elgg_echo('time_tracker:group'),
						'href' => elgg_get_site_url() . "time_tracker/group/{$page_owner->getGUID()}",
						'section' => 'project_manager', 'priority' => 100,
					));
			}
		}
	}
}

// Time_tracker owner_block menu (for users only - group is already registered through pagesetup)
function time_tracker_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "time_tracker/{$params['entity']->username}";
		$item = new ElggMenuItem('time_tracker', elgg_echo('time_tracker'), $url);
		$return[] = $item;
	}
	return $return;
}

/* Contenu du message de notification */
function project_manager_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'project_manager')) {
		$owner = $entity->getOwnerEntity();
		return $owner->name . ' a créé un nouveau projet : ' . $entity->title . "\n\n" . $entity->description . "\n\n" . $entity->getURL();
	}
	return null;
}



/* PAGE HANDLERS */

/** Project_manager page handler
 *	Default = project list :	project_manager
 *	Global project list :		 project_manager/all	or: world, or: references
 * 
 *	New project :						 project_manager/new
 *	Edit project :						project_manager/edit/<project_guid>
 *	Project view page :			 project_manager/view/<project_guid>
 * 
 *	Project view by group :	 project_manager/group/<group_guid>
 *	New project in group :		project_manager/group/<group_guid>/new
 *	Edit project in group :	 project_manager/group/<group_guid>/edit
 * 
 *	Consultants :						 project_manager/consultants
 * 
 *	Notes de frais :					project_manager/expenses ou frais
 *	Gestion notes de frais :	project_manager/expenses/all ou summary
 *	Gestion notes de frais :	project_manager/expenses/{username} ou frais/{username}
 * 
 *	Production globale :			project_manager/production/all	ou: production/summary
 *	Production by project :	 project_manager/production
 *	Production by date :			project_manager/production/<year></<month> (option)	or: <date_stamp>
 *	Production by group :		 project_manager/production/group/<group_guid>
 *	Production by project :	 project_manager/production/project/<project_guid>
 *	Production/project/date : project_manager/production/<'group' or 'project'>/<project_guid>/<date_stamp>
 * 
*/
function project_manager_page_handler($page) {
	// Block any attempt to access 
	project_manager_gatekeeper();
	elgg_push_breadcrumb(elgg_echo('project_manager:references'), "project_manager/all");
	elgg_set_context('project_manager');
	if (!isset($page[0])) { $page[0] = 'all'; }
	$project_manager_root = dirname(__FILE__);
	switch($page[0]) {
		case "group":
			set_input('container_guid',$page[1]);
			if (isset($page[2]) && ($page[2] == 'edit')) {
				require($project_manager_root . "/pages/project_manager/edit.php");
			} else if (isset($page[2]) && ($page[2] == 'new')) {
				require($project_manager_root . "/pages/project_manager/edit.php");
			} else require($project_manager_root . "/pages/project_manager/view.php");
			break;
		case "consultants":
			require($project_manager_root . "/pages/project_manager/consultants.php");
			break;
		case "expenses":
		case "frais":
			if (($page[1] == 'all') || ($page[1] == 'summary')) {
				require($project_manager_root . "/pages/project_manager/global_expenses.php");
			} else {
				if (!empty($page[1])) set_input('username',$page[1]);
				require($project_manager_root . "/pages/project_manager/expenses.php");
			}
			break;
		case "production":
			if (($page[1] == 'all') || ($page[1] == 'summary')) {
				require($project_manager_root . "/pages/project_manager/global_production.php");
				break;
			} else if ($page[1] == 'project') {
				set_input('project_guid',$page[2]);
			} else if ($page[1] == 'group') {
				set_input('container_guid',$page[2]);
			} else {
				if (isset($page[1])) set_input('year', $page[1]);
				if (isset($page[2])) set_input('month', $page[2]);
			}
			if (isset($page[3])) set_input('year', $page[3]);
			if (isset($page[4])) set_input('month', $page[4]);
			require($project_manager_root . "/pages/project_manager/production.php");
			break;
		case "view":
			set_input('guid',$page[1]);
			require($project_manager_root . "/pages/project_manager/view.php");
			break;
		case "edit": set_input('guid',$page[1]);
		case "new":	
			require($project_manager_root . "/pages/project_manager/edit.php");
			break;
		case "world": case "references":
		case "all":
		default:
			require($project_manager_root . "/pages/project_manager/world.php");
	}
	elgg_pop_context();
	return true;
}

/* Time tracker page handler
 *	All time trackers:		time_tracker/all
 *	Group time tracker:	 time_tracker/group/<group_guid>
 *	Project time tracker: time_tracker/project/<project_guid>
 * 
 *	User's time tracker:	time_tracker/owner/<username>
 *	User's time summary:	time_tracker/owner/<username>/summary
 *	User's time summary:	time_tracker/owner/<username>/<year>/<month> (option) ou: <year><month> (<date_stamp>)
 * 
 *	Own time tracker:		 time_tracker
 *	Own time summary:		 time_tracker/summary
 *	Own time at date:		 time_tracker/<year>/<month> (option) ou: <year><month> (<date_stamp>)
*/
function time_tracker_page_handler($page) {
	elgg_push_breadcrumb(elgg_echo('project_manager:time_tracker'), "time_tracker/mine");
	elgg_set_context('project_manager');
	$project_manager_root = dirname(__FILE__);
	switch($page[0]) {
		case "group": set_input('container_guid',$page[1]);
			require($project_manager_root . "/pages/time_tracker/project_time_tracker.php");
			break;
		case "project": set_input('project_guid',$page[1]);
			require($project_manager_root . "/pages/time_tracker/project_time_tracker.php");
			break;
		case "project": set_input('project_guid',$page[1]);
			require($project_manager_root . "/pages/time_tracker/project_time_tracker.php");
			break;
		case "all":
			require($project_manager_root . "/pages/time_tracker/all_time_trackers.php");
			break;
		case "owner":
			set_input('username',$page[1]);
			if ($page[2] == 'summary') set_input('summary', true);
			else {
				if (isset($page[2])) set_input('year', $page[2]);
				if (isset($page[3])) set_input('month', $page[3]);
			}
			require($project_manager_root . "/pages/time_tracker/owner_time_tracker.php");
			break;
		case "notes":
			set_input('username',$page[1]);
			if (isset($page[2])) {
				if (isset($page[3])) {
					set_input('year', $page[2]);
					set_input('month', $page[3]);
				} else {
					set_input('date_stamp', $page[2]); // Enables range : 201502-201506 | 201402-2015 | 2013-2015 | 201407
				}
			}
			require($project_manager_root . "/pages/time_tracker/owner_time_tracker_notes.php");
			break;
		default:
			if ($page[0] == 'summary') { set_input('summary', true); } 
			else {
				if (isset($page[0])) set_input('year', $page[0]);
				if (isset($page[1])) set_input('month', $page[1]);
			}
			require($project_manager_root . "/pages/time_tracker/owner_time_tracker.php");
	}
	elgg_pop_context();
	return true;
}

/**
 * Dispatcher for tasks.
 * URLs take the form of
 *	All tasks:				tasks/all
 *	User's tasks:		 tasks/owner/<username>
 *	Friends' tasks:	 tasks/friends/<username>
 *	View task:				tasks/view/<guid>/<title>
 *	New task:				 tasks/add/<guid> (container: user, group, parent)
 *	Edit task:				tasks/edit/<guid>
 *	History of task:	tasks/history/<guid>
 *	Revision of task: tasks/revision/<id>
 *	Group tasks:			tasks/group/<guid>/all
 *
 * Title is ignored
 *
 * @param array $task
 * @return bool
 */
function tasks_page_handler($task) {
	elgg_load_library('elgg:tasks');
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');
	if (!isset($task[0])) { $task[0] = 'all'; }
	elgg_push_breadcrumb(elgg_echo('tasks'), 'tasks/all');
	elgg_set_context('project_manager');
	
	$base_dir = elgg_get_plugins_path() . 'project_manager/pages/tasks';
	$task_type = $task[0];
	switch ($task_type) {
		case 'owner': include "$base_dir/owner.php"; break;
		case 'friends': include "$base_dir/friends.php"; break;
		case 'view': set_input('guid', $task[1]); include "$base_dir/view.php"; break;
		case 'add': set_input('guid', $task[1]); include "$base_dir/new.php"; break;
		case 'edit': set_input('guid', $task[1]); include "$base_dir/edit.php"; break;
		case 'group': include "$base_dir/owner.php"; break;
		case 'history': set_input('guid', $task[1]); include "$base_dir/history.php"; break;
		case 'revision': set_input('id', $task[1]); include "$base_dir/revision.php"; break;
		case 'all': include "$base_dir/world.php"; break;
		default: return false;
	}
	return true;
}



function project_manager_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object')) {
		$title = elgg_get_friendly_title($entity->title);
		
		// Project
		if (elgg_instanceof($entity, 'object', 'project_manager')) {
			return elgg_get_site_url() . 'project_manager/view/'. $entity->getGUID() . "/" . $title;
		}
		
		
		// Task
		if (elgg_instanceof($entity, 'object', 'task') || elgg_instanceof($entity, 'object', 'task_top')) {
			return elgg_get_site_url() . 'tasks/view/'. $entity->getGUID() . "/" . $title;
		}
		
		// Time tracker
		if (elgg_instanceof($entity, 'object', 'time_tracker')) {
			return elgg_get_site_url() . 'time_tracker/view/'. $entity->getGUID() . '/' . $title;
		}
		
	}
}

/**
 * Override the task annotation url
 *
 * @param ElggAnnotation $annotation
 * @return string
 */
function tasks_revision_url($annotation) {
	return "tasks/revision/$annotation->id";
}



function project_manager_save_site_project_manager($hook, $type, $value, $params) {
	$params = get_input('params');
	$plugin_id = get_input('plugin_id');
	if ($plugin_id != 'project_manager') { return $value; }
	$plugin = elgg_get_plugin_from_id($plugin_id);
	if (!($plugin instanceof ElggPlugin)) {
		register_error(elgg_echo('plugins:settings:save:fail', array($plugin_id)));
		forward(REFERER);
	}
	
	$plugin_name = $plugin->getManifest()->getName();
	$result = false;
	$managers = get_input('managers');
	$managers = array_unique($managers);
	/* Modifier les metadonnées des membres dynamiquement ?	dans ce cas aussi modifier les non-listés..
	foreach ($managers as $manager_guid) {
		$manager = get_entity($manager_guid);
		$manager->project_manager_role = 'manager';
	}
	*/
	$params['managers'] = implode(',', $managers);
	foreach ($params as $k => $v) {
		$result = $plugin->setSetting($k, $v);
		if (!$result) {
			register_error(elgg_echo('plugins:settings:save:fail', array($plugin_name)));
			forward(REFERER);
			exit;
		}
	}
	system_message(elgg_echo('plugins:settings:save:ok', array($plugin_name)));
	forward(REFERER);
}



// TASKS PLUGIN

/**
 * Override the default entity icon for tasks
 *
 * @return string Relative URL
 */
function tasks_icon_url_override($hook, $type, $returnvalue, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'task_top') ||
		elgg_instanceof($entity, 'object', 'task')) {
		switch ($params['size']) {
			case 'small':
				return 'mod/project_manager/graphics/tasks.gif';
				break;
			case 'medium':
				return 'mod/project_manager/graphics/tasks_lrg.gif';
				break;
		}
	}
}


/**
* Returns a more meaningful message
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function task_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && (($entity->getSubtype() == 'task_top') || ($entity->getSubtype() == 'task'))) {
		$descr = $entity->description;
		$title = $entity->title;
		//@todo why?
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		$owner = $entity->getOwnerEntity();
		return $owner->name . ' ' . elgg_echo("tasks:via") . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
	}
	return null;
}

/**
 * Extend permissions checking to extend can-edit for write users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function tasks_write_permission_check($hook, $entity_type, $returnvalue, $params) {
	if (($params['entity']->getSubtype() == 'task') || ($params['entity']->getSubtype() == 'task_top')) {
		$write_permission = $params['entity']->write_access_id;
		$user = $params['user'];
		if (($write_permission) && ($user)) {
			// $list = get_write_access_array($user->guid);
			$list = get_access_array($user->guid); // get_access_list($user->guid);
			if (($write_permission!=0) && (in_array($write_permission,$list))) { return true; }
		}
	}
}

/**
 * Extend container permissions checking to extend can_write_to_container for write users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function tasks_container_permission_check($hook, $entity_type, $returnvalue, $params) {
	if (elgg_get_context() == "tasks") {
		if (elgg_get_page_owner_guid()) {
			if (can_write_to_container(elgg_get_logged_in_user_guid(), elgg_get_page_owner_guid())) return true;
		}
		if ($task_guid = get_input('task_guid',0)) {
			$entity = get_entity($task_guid);
		} else if ($parent_guid = get_input('parent_guid',0)) {
			$entity = get_entity($parent_guid);
		}
		if ($entity instanceof ElggObject) {
			if ( can_write_to_container(elgg_get_logged_in_user_guid(), $entity->container_guid)
					|| in_array($entity->write_access_id,get_access_list())
				) { return true; }
		}
	}
}

/**
 * Return views to parse for tasks.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $return_value
 * @param unknown_type $params
 */
function tasks_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/task'] = elgg_echo('item:object:task');
	$return_value['object/task_top'] = elgg_echo('item:object:task_top');

	return $return_value;
}


function project_manager_get_project_for_container($container_guid = 0) {
	if (empty($container_guid)) return false;
	$options = array(
			//'metadata_names' => 'date_stamp', 'metadata_values' => $date_stamp, 
			'types' => 'object', 'subtypes' => 'project_manager',
			'container_guids' => $container_guid,
			'limit' => 1, 'offset' => 0, 'order_by' => '', 'count' => false,
		);
	$existing_projects = elgg_get_entities($options);
	if ($existing_projects[0] instanceof ElggObject) return $existing_projects[0];
	else return false;
}

/* Récupérer un projet qui n'en est pas un == saisies spéciales (CGAT)
function project_manager_get_project_by_name($project_guid = 0, $container_guid = false) {
	if (empty($container_guid)) return false;
	$options = array(
			'metadata_names' => 'project_guid', 'metadata_values' => $project_guid, 
			'types' => 'object', 'subtypes' => 'time_tracker',
			'limit' => 1, 'offset' => 0, 'order_by' => '', 'count' => false,
		);
	if ($container_guid) $options['container_guids'] = $container_guid;
	$existing_projects = elgg_get_entities($options);
	if ($existing_projects[0] instanceof ElggObject) return $existing_projects[0];
	else return false;
}
*/


// GATEKEEPERS

// Project_manager gatekeeper : deny access to unauthorised people
// Seuls les salariés ont accès aux projets en lecture
// Setting a $user_guid manually enables providing access under certain conditions, so do not block when not logged in
function project_manager_gatekeeper($user_guid = false, $admin_bypass = true, $forward = true) {
	$allowed = false;
	$pm_meta = project_manager_get_user_metadata();
	
	if (!$user_guid && elgg_is_logged_in()) { $user_guid = elgg_get_logged_in_user_guid(); }
	$user = get_entity($user_guid);
	
	if (elgg_instanceof($user, 'user')) {
		// Main access condition for non-admin : not empty role metadata
		if (empty($user->{$pm_meta})) { $allowed = true; }
		
		// Admin bypass
		if ($admin_bypass && $user->isAdmin()) { $allowed = true; }
	}
	
	// Forward if no access
	if ($forward && !$allowed) {
		register_error(elgg_echo('project_manager:noaccess'));
		forward();
	}
	
	// Return result otherwise
	return $allowed;
}

// Project data gatekeeper : deny access to anyone except project owner/manager, general managers, and admins if bypass not unset
// Seuls les auteurs/managers des projets ont accès à certaines données
function project_manager_projectdata_gatekeeper($project, $user_guid = false, $admin_bypass = true, $forward = false) {
	$allowed = false;
	if (!$user_guid && elgg_is_logged_in()) { $user_guid = elgg_get_logged_in_user_guid(); }
	$user = get_entity($user_guid);
	
	if (elgg_instanceof($user, 'user')) {
		// Global managers
		$managers = explode(',', elgg_get_plugin_setting('managers', 'project_manager'));
		if (in_array($user_guid, $managers)) { $allowed = true; }
		// Project owner
		if ($user_guid == $project->owner_guid) { $allowed = true; }
		// Project manager
		if ($user_guid == $project->projectmanager) { $allowed = true; }
		// Admin bypass
		if ($admin_bypass && elgg_is_admin_logged_in()) { $allowed = true; }
	}
	
	// Forward or return result
	if ($forward && !$allowed) {
		register_error(elgg_echo('project_manager:projectmanager:noaccess'));
		forward();
	}
	return $allowed;
}

// Manager gatekeeper : deny access to anyone except managers, and admins if bypass not unset
function project_manager_manager_gatekeeper($user_guid = false, $admin_bypass = true, $forward = true) {
	$allowed = false;
	if (!$user_guid && elgg_is_logged_in()) { $user_guid = elgg_get_logged_in_user_guid(); }
	$user = get_entity($user_guid);
	
	if (elgg_instanceof($user, 'user')) {
		$managers = explode(',', elgg_get_plugin_setting('managers', 'project_manager'));
		if (in_array($user_guid, $managers)) { $allowed = true; }
		//error_log("DEBUG Time tracker : $user_guid = " . print_r($managers, true));
		if ($admin_bypass && elgg_is_admin_logged_in()) { $allowed = true; }
	}
	
	// Forward or return result
	if ($forward && !$allowed) {
		register_error(elgg_echo('project_manager:managers:noaccess'));
		forward();
	}
	return $allowed;
}

/* Flexible gatekeeper based on various metadata
 * $user : the user entity to check
 * $metadata_values : array of ($metadata => $value) arrays
 * $allow : allow (or disallow) if condition is true
 * $is_equal : use an equality condition filter
 * $required : all metadata => values required, or only 1 sufficient ?
 * $forward : return result, or forward
 * $admin_bypass : let admin pass anyway, or filter as well ?
*/
function project_manager_flexible_gatekeeper($user, $metadata_values = '', $allow = true, $is_equal = true, $required = true, $forward = true, $admin_bypass = true) {
	gatekeeper();
	if ($admin_bypass && elgg_is_admin_logged_in()) return true;
	$has_access = true;
	if (is_array($metadata_values)) {
		foreach ($metadata_values as $metadata => $value) {
// error_log('TEST accès ' . $user->name . " : $metadata => $value ? ==> " . $user->{$metadata});
			if ($is_equal) {
				if ($user->{$metadata} == $value) {
					if ($allow) {
						if (!$required) return true; // Sufficient => OK, else : keep checking
					} else { $has_access = false; }
				} else {
					if ($allow) { $has_access = false; } else {
						if (!$required) return true; // Sufficient => OK, else : keep checking
					}
				}
			} else {
				if ($user->{$metadata} == $value) {
					if ($allow) { $has_access = false; } else {
						if (!$required) return true; // Sufficient => OK, else : keep checking
					}
				} else {
					if ($allow) {
						if (!$required) return true; // Sufficient => OK, else : keep checking
					} else { $has_access = false; }
				}
			}
		}
	}
	// Return result if asked (instead of forwarding)
	if (!$forward) { return $has_access; }
	// Forward if needed
	if (!$has_access) {
		if (!elgg_is_logged_in()) {
			$_SESSION['last_forward_from'] = current_page_url();
			register_error(elgg_echo('loggedinrequired'));
			forward('', 'login');
		} else {
			register_error(elgg_echo('project_manager:noaccess'));
			forward('');
		}
	}
}


// INFOS DE BASE, SELECTEURS ET COLONNES

/* Tables de correspondance des jours et mois - avec cache */
function time_tracker_get_date_table($type, $short = false) {
	global $time_tracker_date_table;
	if ($type == 'days') {
		if ($short) {
			if (isset($time_tracker_date_table['dayshort'])) { return $time_tracker_date_table['dayshort']; }
			$return = array('D', 'L', 'M', 'M', 'J', 'V', 'S');
			$time_tracker_date_table['dayshort'] = $return;
		} else {
			if (isset($time_tracker_date_table['day'])) { return $time_tracker_date_table['day']; }
			$return = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
			$time_tracker_date_table['day'] = $return;
		}
	} else if ($type == 'months') {
		if ($short) {
			if (isset($time_tracker_date_table['monthshort'])) { return $time_tracker_date_table['monthshort']; }
			$return = array(1 => 'J', 2 => 'F', 3 => 'M', 4 => 'A', 5 => 'M', 6 => 'J', 7 => 'J', 8 => 'A', 9 => 'S', 10 => 'O', 11 => 'N', 12 => 'D');
			$time_tracker_date_table['monthshort'] = $return;
		} else {
			if (isset($time_tracker_date_table['month'])) { return $time_tracker_date_table['month']; }
			$return = array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');
			$time_tracker_date_table['month'] = $return;
		}
	}
	return $return;
}

/* Renvoie un sélecteur d'année */
function time_tracker_select_input_year($year, $base_url = 'time_tracker', $name = '?year=', $forward = true) {
	$base_url = elgg_get_site_url() . $base_url . $name;
	if ($forward) $content = '<label>Changer d\'année pour <select name="' . $name . '" onChange="javascript:document.location.href=this.value">';
	else $content = '<label>Changer d\'année pour <select name="' . $name . '">';
	for ($y = 2013; $y <= (date('Y')); $y++) {
		if ($y == $year) {
			$content .= '<option selected="selected" value="' . $base_url . $y . '">' . $y . '</option>';
		} else {
			$content .= '<option value="' . $base_url . $y . '">' . $y . '</option>';
		}
	}
	$content .= '</select></label>';
	return $content;
}

/* Renvoie un sélecteur de mois */
function time_tracker_select_input_month($year, $month, $base_url = 'time_tracker', $name = '?date_stamp=', $forward = true, $title = 'Changer de mois pour ') {
	$base_url = elgg_get_site_url() . $base_url . $name;
	$months = time_tracker_get_date_table('months');
	if ($forward) $content = '<label>' . $title . '<select name="' . $name . '" onChange="javascript:document.location.href=this.value">';
	else $content = '<label>' . $title . '<select name="' . $name . '">';
	if ( !$year || !$month || ($year < 2013) || ($year > date('Y')) ) $content .= '<option value="' . $base_url . '" selected ="selected" disabled="disabled">' . elgg_echo('project_manager:choose') . '</option>';
	else $content .= '<option value="' . $base_url . '" disabled="disabled">' . elgg_echo('project_manager:choose') . '</option>';
	for ($y = 2013; $y <= (date('Y')); $y++) {
		for ($m = 1; $m <= 12; $m++) {
			if (strlen($m) == 1) $ds = $y.'0'.$m; else $ds = $y.$m;
			if (($y == $year) && ($m == $month)) {
				$content .= '<option selected="selected" value="' . $base_url . $ds . '">' . $months[$m] . ' ' . $y . '</option>';
			} else {
				$content .= '<option value="' . $base_url . $ds . '">' . $months[$m] . ' ' . $y . '</option>';
			}
		}
	}
	$content .= '</select></label>';
	return $content;
}

/* Renvoie un sélecteur de projet */
function time_tracker_select_input_project($project_guid, $include_specials = true, $base_url = 'project_manager/production', $name = '/project/', $forward = true, $label = 'Changer de projet ') {
	$base_url = elgg_get_site_url() . $base_url . $name;
	$months = time_tracker_get_date_table('months');
	if ($forward) $content = '<label>' . $label . '<select name="' . $name . '" onChange="javascript:document.location.href=this.value">';
	else $content = '<label>' . $label . '<select name="' . $name . '">';
	$projects = time_tracker_get_projects();
	if (empty($project_guid)) $content .= '<option selected="selected" value="" disabled="disabled">' . elgg_echo('project_manager:choose') . '</option>';
	// Projects "spéciaux"
	$special_projects = array('C', 'G', 'A', 'T');
	if ($include_specials) {
		foreach ($special_projects as $val) {
			if ($val == $project_guid) {
				$content .= '<option selected="selected" value="' . $base_url . $val . '">' . time_tracker_get_projectname($val) . '</option>';
			} else {
				$content .= '<option value="' . $base_url . $val . '">' . time_tracker_get_projectname($val) . '</option>';
			}
		}
	} else if (in_array($project_guid, $special_projects)) { $content .= '<option selected="selected" value="' . $base_url . $val . '">' . time_tracker_get_projectname($val) . '</option>'; }
	// Projets "normaux" (production)
	foreach ($projects as $ent) {
		if ($ent->guid == $project_guid) {
			$content .= '<option selected="selected" value="' . $base_url . $ent->guid . '">' . time_tracker_get_projectname($ent) . '</option>';
		} else {
			$content .= '<option value="' . $base_url . $ent->guid . '">' . time_tracker_get_projectname($ent) . '</option>';
		}
	}
	$content .= '</select></label>';
	return $content;
}


/* Renvoie un sélecteur de taux journalier (TJM) */
function time_tracker_select_tjm($project, $profile = '', $name = 'profile', $select_disabled = true) {
	$select_disabled = '';
	if ($select_disabled) $select_disabled = ' disabled="disabled"';
	$content = '<select name="' . $name . '" style="max-width:10ex;">';
	$profiles = $project->profiles;
	$profiles = str_replace("\r", '\n', $profiles);
	$profiles = str_replace('\n\n', '\n', $profiles);
	$profiles = explode('\n', $profiles);
	if (empty($profile)) $content .= '<option selected="selected" disabled="disabled">TAUX</option>';
	foreach ($profiles as $project_profile) {
		$project_profile = trim($project_profile);
		if (empty($project_profile)) continue;
		$project_profile = explode(':', $project_profile);
		if ($project_profile == $profile) {
			$content .= '<option selected="selected" '.$select_disabled.' value="' . trim($project_profile[1]) . '">' . trim($project_profile[1]) . ' € HT / jour - ' . trim($project_profile[0]) . '</option>';
		} else {
			$content .= '<option '.$select_disabled.' value="' . trim($project_profile[1]) . '">' . trim($project_profile[1]) . ' € HT / jour - ' . trim($project_profile[0]) . '</option>';
		}
	}
	$content .= '</select>';
	return $content;
}


/* Ajoute une colonne d'entêtes pour les saisies + somme production par ligne */
function time_tracker_add_header_col($year, $month, $user_guid, $validated = '') {
	global $time_tracker_displayed_datelabel;
	$content = '<div style="border:1px solid #000; border-bottom:0; padding:2px 1px 2px 1px; margin:0px 0px 0px 0px; float:left;">';
	$content .= '<div style="font-size:10px; height:18px; margin:0; padding:0; color:darkred;">Retirer un projet &rarr;</div>';
	//$content .= '<div style="height:50px;">Production</div>';
	$content .= '<div style="width:100%; height:15ex; font-size:10px;">';
	$content .= '<div style="background-color:#CCF; width:50px; height:15ex; float:right; margin-left:4px;" />Total Production</div>';
	$content .= '</div>';
	$days = time_tracker_get_date_table('days', true);
	// Date d'aujourd'hui
	$now_year = date('Y', time());
	$now_month = date('m', time());
	$now_day = date('d', time());
	
	$date_timestamp = mktime(0, 0, 0, (int)$month, 1, $year); // timestamp au 1er du mois
	$count_days_in_month = date('t', $date_timestamp);
	// Calcul timestamp du dernier jour ouvré du mois
	$last_day_of_month = $count_days_in_month;
	while ( (time_tracker_jour_ouvrable($year, $month, $last_day_of_month) != 1) && ($last_day_of_month > 1)) { $last_day_of_month--; }
	$end_of_month = mktime(0, 0, 0, $month, $last_day_of_month, $year);
	$nb_open_days = 0; // Pas la peine de compter 2 fois : on additionne ici directement
	for ($i = 1; $i <= $count_days_in_month; $i++) {
		$day_class = '';
		// Date d'aujourd'hui ?
		if ($i == $now_day) {
			if (($month == $now_month) && ($year == $now_year)) { $day_class .= 'time_tracker_today '; }
		}
		// timestamp à 00:00 du jour donné
		$date_timestamp = mktime(0, 0, 0, (int)$month, $i, (int)$year);
		// w : Jour de la semaine au format numérique 	0 (pour dimanche) à 6 (pour samedi)
		$day_of_week = date('w', $date_timestamp);
		// Jour ouvrable ou pas
		$is_workableday = time_tracker_jour_ouvrable($year, $month, $i);
		if ($is_workableday == 0) { $day_class .= 'time_tracker_notworkable '; } else $nb_open_days++;
		$content .= '<div style="border-top:1px solid #000; height:24px; margin:0; padding:0;" class="' . $day_class . '">';
		$content .= '<input class="time_tracker_line_total" id="time_tracker_line_total_'.$i.'" value="" disabled="disabled" style="background-color:#CCF; width:50px; float:right; margin-left:12px;" />';
		$add_month_label = $days[$day_of_week] . ' ';
		if (strlen($i) == 1) $content .= $add_month_label . '0' . $i;
		else $content .= $add_month_label . $i;
		$content .= '</div>';
	}
	
	$content .= '<br />';
	$content .= '<span style="font-size:11px;">' . $nb_open_days . ' jours ouvrés</span><br />Total';
	$content .= '<input id="time_tracker_global_total" value="" disabled="disabled" style="background-color:#CCF; width:50px; float:right; margin-left:12px;" />';
	$content .= '<br />';
	$content .= '<div style="margin:0; padding:0; max-width:100px;">';
	// Nb de jours saisis
	$total_days = time_tracker_monthly_time($year, $month, false, $user_guid, false, false);
	if ($total_days >= $nb_open_days) $display_validation = true;
	// @TODO : Ssi Date de fin du mois passée et/ou Nombre de jours OK => on peut valider la saisie
	if ($display_validation || (time() >= $end_of_month)) {
		$content .= '<strong>' . elgg_echo('time_tracker:validate:ready') . '</strong><br />';
		$validate_style = '';
		$cancel_style = 'display:none;';
		if ($validated == 1) {
			$validate_style = 'display:none;';
			$cancel_style = '';
		}
		$content .= '<a href="javascript:void(0);" id="time_tracker_validation_global" value="" style="color:darkgreen; font-weight:bold; '.$validate_style.'" onClick="time_tracker_validation(\'validate\','.$year.','.$month.','.$user_guid.');"><span class="elgg-icon elgg-icon-checkmark"></span> ' . elgg_echo('time_tracker:validate') . '</a><br />';
		// Seuls les admins peuvent annuler la validation
		if (elgg_is_admin_logged_in()) {
			$content .= '<a href="javascript:void(0);" id="time_tracker_validation_global_cancel" value="" style="color:red; '.$cancel_style.'" onClick="time_tracker_validation(\'cancel\','.$year.','.$month.','.$user_guid.');"><span class="elgg-icon elgg-icon-undo"></span> ' . elgg_echo('time_tracker:validate:cancel') . '</a><br />';
		}
	} else {
		$content .= '<span style="font-size:11px; font-weight:bold;">Validation impossible (Total ' . $total_days . ' < jours ouvrés)</span><br />';
	}
	
	$content .= '</div>';
	
	$time_tracker_displayed_datelabel = true;
	$content .= '</div>';
	return $content;
}

/* Renvoie le nom complet d'un projet à partir de la valeur project_guid du time_tracker
 * option : $project_guid peut aussi être un ElggObject
*/
function time_tracker_get_projectname($project_guid = false) {
	if (!$project_guid) return false;
	if ($project_guid instanceof ElggObject) {
		$project = $project_guid;
		$project_guid = $project->guid;
	} else if ($project = get_entity($project_guid)) {}
	global $project_manager_projects_names;
	if (isset($project_manager_projects_names[$project_guid])) return $project_manager_projects_names[$project_guid];
	// Maintenant on peut composer le nom du projet
	if ($project instanceof ElggObject) {
		$project_code = $project->project_code;
		if (empty($project->project_code)) $project_code = elgg_echo('time_tracker:code:undefined');
		$project_name = $project_code . ' : ' . $project->title;
	} else if ($project instanceof ElggUser) {
		$project_name = elgg_echo('time_tracker:otherproject');
	} else {
		switch($project_guid) {
			case 'P': $project_name = elgg_echo('time_tracker:production'); break;
			case 'A': $project_name = elgg_echo('time_tracker:avantvente'); break;
			case 'T': $project_name = elgg_echo('time_tracker:travauxtechniques'); break;
			case 'G': $project_name = elgg_echo('time_tracker:gestion'); break;
			case 'C': $project_name = elgg_echo('time_tracker:conge'); break;
		}
	}
	$project_manager_projects_names[$project_guid] = $project_name;
	return $project_name;
}


/* Prépare une liste de tous les projets affectés aux membres
 * Avec ou sans filtre, on prépare une liste complète
 * Renvoie une liste de projets : $user_guid => $projects
 */
//function time_tracker_sort_time_trackers_by_projects() {
function time_tracker_sort_projects_by_users() {
	// Principe : on liste toutes les saisies, puis on prépare un tableau global par membre
	global $project_manager_projects;
	$ia = elgg_set_ignore_access(true);
	// Liste globale de tous les membres
	$all_members = project_manager_get_consultants();
	foreach ($all_members as $ent) { $project_manager_projects[$ent->guid] = array(); }
	// Liste globale de tous les projets
	$all_projects = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'limit' => false));
	$project_manager_projects['all'] = $all_projects;
	if ($all_projects) foreach ($all_projects as $ent) { $projects[$ent->guid] = $ent; }
	// Liste et tri des saisies
	$options = array(
			'types' => 'object', 'subtypes' => 'time_tracker',
			'limit' => false, 'offset' => 0, 'order_by' => '', 'count' => false,
		);
	$time_trackers = elgg_get_entities($options);
	$count_time_trackers = count($time_trackers);
	$double_projects = array();
	if ($time_trackers) foreach ($time_trackers as $ent) {
		// On ajoute la saisie au tableau, si elle n'y est pas déjà
		if (!isset($double_projects[$ent->owner_guid][$ent->project_guid])) {
			$project_manager_projects[$ent->owner_guid][] = $projects[$ent->project_guid];
			$double_projects[$ent->owner_guid] = $ent->project_guid; // Dédoublonnage
		}
	}
	elgg_set_ignore_access($ia);
	return $project_manager_projects;
}


function time_tracker_get_projects($user_guid = false) {
	// Principe : on liste les projets (tous ou du membre), et pour chacun on regarde s'il y a au moins une saisie 
	// (moins de requêtes que lister les saisies et dédoublonner les projets)
	// Note : du point de vue mise en cache, on a plutôt intérêt à lister toutes les saisies par projet
	global $project_manager_projects;
	
	// Attention à ne pas initialiser d'ailleurs sinon le contenu risque de ne pas être complet !
	// Intérêt très discutable en terme de performance... Ca ralentit sensiblement en fait !
	// Mieux vaut mettre en cache au fur et à mesure
	//if (!isset($project_manager_projects)) $project_manager_projects = time_tracker_sort_projects_by_users();
	
	if (!$user_guid && isset($project_manager_projects['all'])) { return $project_manager_projects['all']; }
	else if (isset($project_manager_projects[$user_guid])) { return $project_manager_projects[$user_guid]; }
	
	$ia = elgg_set_ignore_access(true);
	$all_projects = elgg_get_entities(array('types' => 'object', 'subtypes' => 'project_manager', 'limit' => false));
	if ($all_projects) {
		if (!$user_guid) {
			$project_manager_projects['all'] = $projects;
			$projects = $all_projects;
		} else {
			foreach ($all_projects as $project) {
				$options = array(
						'metadata_names' => 'project_guid', 'metadata_values' => $project->guid, 
						'types' => 'object', 'subtypes' => 'time_tracker',
						'owner_guids' => $user_guid,
						'limit' => 10, 'offset' => 0, 'order_by' => '', 'count' => true,
					);
				$has_time_tracker = elgg_get_entities_from_metadata($options);
				// S'il y a au moins 1 saisie pour ce membre, on ajoute à la liste
				if ($has_time_tracker && ($has_time_tracker > 0)) { $projects[] = $project; }
			}
			$project_manager_projects[$user_guid] = $projects;
		}
	}
	elgg_set_ignore_access($ia);
	return $projects;
}


/* Renvoie la liste des noms des projets sous la forme GUID => Nom
 * Note : pas de filtrage sinon il faut des noms différents
 */
function project_manager_get_projects_names($code = false) {
	global $project_manager_projects_names;
	global $project_manager_projects_codes;
	if ($code) {
		if (isset($project_manager_projects_codes)) { return $project_manager_projects_codes; }
	} else {
		if (isset($project_manager_projects_names)) { return $project_manager_projects_names; }
	}
	$all_projects = time_tracker_get_projects(false, true);
	if ($all_projects) foreach ($all_projects as $ent) {
		$projects[$ent->guid] = $ent->title;
		$projects_codes[$ent->guid] = project_manager_get_project_code($ent);
	}
	// Add generic names
	$projects['P'] = elgg_echo('time_tracker:production');
	$projects['A'] = elgg_echo('time_tracker:avantvente');
	$projects['T'] = elgg_echo('time_tracker:travauxtechniques');
	$projects['G'] = elgg_echo('time_tracker:gestion');
	$projects['C'] = elgg_echo('time_tracker:conge');
	// Set static vars
	$project_manager_projects_names = $projects;
	$project_manager_projects_codes = $projects_codes;
	if ($code) return $projects_codes;
	else return $projects;
}

/* Returns project code */
function project_manager_get_project_code($project) {
	global $project_manager_projects_codes;
	if (isset($project_manager_projects_codes[$project->guid])) return $project_manager_projects_codes[$project->guid];
	$project_code = $project->project_code;
	if (empty($project_code)) $project_code = substr($project->title, 0, 7) . '…';
	if (empty($project_code)) $project_code = elgg_echo('time_tracker:code:undefined');
	return $project_code;
}



/* Renvoie la liste des consultants
 * $project_guid : (option) permet de lister les consultants ayant effectués des saisies sur un projet précis
*/
function project_manager_get_consultants($project_guid = false, $guid_only = false, $alpha_sort = true) {
	$members = array();
	global $project_manager_consultants;
	$pm_meta = project_manager_get_user_metadata();
	$special_status = project_manager_get_special_status();
	$ia = elgg_set_ignore_access(true);
	// Principe : si pas de projet, on liste les consultants puis on filtre
	if (!$project_guid) {
		if (isset($project_manager_consultants['all'])) return $project_manager_consultants['all'];
		$all_members = elgg_get_entities(array('types' => 'user', 'limit' => false));
		$count_all_members = count($all_members);
		if ($all_members) foreach ($all_members as $ent) {
			if (!empty($ent->{$pm_meta}) && in_array($ent->{$pm_meta}, $special_status)) $members[$ent->guid] = $ent;
		}
		if ($alpha_sort) { usort($members, create_function('$a,$b', 'return strcmp($a->name,$b->name);')); }
		$project_manager_consultants['all'] = $members;
		
	} else {
		// Limitation des requêtes avec une variable globale
		if (isset($project_manager_consultants[$project_guid])) return $project_manager_consultants[$project_guid];
		// Si projet défini, on liste les saisies pour ce projet puis on regarde les consultants
		// (moins de requêtes que lister toutes les saisies et dédoublonner les projets)
		$options = array(
				'metadata_names' => 'project_guid', 'metadata_values' => $project_guid, 
				'types' => 'object', 'subtypes' => 'time_tracker',
				'limit' => false, 'offset' => 0, 'order_by' => '', 'count' => false,
			);
		$time_trackers = elgg_get_entities_from_metadata($options);
		$count_time_trackers = count($time_trackers);
		if ($time_trackers) foreach ($time_trackers as $ent) {
			// Si pas déjà listé, on ajoute à la liste
			if (!in_array($ent->owner_guid, $members)) { $members[$ent->owner_guid] = get_entity($ent->owner_guid); }
		}
		if ($alpha_sort) { usort($members, create_function('$a,$b', 'return strcmp($a->name,$b->name);')); }
		$project_manager_consultants[$project_guid] = $members;
	}
	elgg_set_ignore_access($ia);
	return $members;
}


/* Renvoie la liste des noms des consultants sous la forme GUID => Nom
 * Note : pas de filtrage sinon il faut des noms différents
 */
function project_manager_get_members_names() {
	$members = array();
	global $project_manager_members_names;
	if (isset($project_manager_members_names)) { return $project_manager_members_names; }
	$all_members = project_manager_get_consultants(false, false, false);
	if ($all_members) foreach ($all_members as $ent) { $members[$ent->guid] = $ent->name; }
	$project_manager_members_names = $members;
	return $members;
}


// FONCTIONS DE CALCUL

/* Retourne le temps passé un mois donné
 * param : année et mois
 * (optionnel) sur un projet précis
 * (optionnel) par un membre précis
*/
function time_tracker_monthly_time($year, $month, $project_guid = false, $user_guid = false, $exclude_meta = false, $exclude_other = false) {
	$total_hours = 0;
	// Affichage des saisies du projet pour le mois demandé
	if (strlen($month) == 1) $date_stamp = (string)$year.'0'.$month;
	else $date_stamp = (string)$year.$month;
	$options = array(
			'metadata_names' => 'date_stamp', 'metadata_values' => $date_stamp, 
			'types' => 'object', 'subtypes' => 'time_tracker',
			'limit' => false, 'offset' => 0, 'order_by' => '', 'count' => false,
		);
	// Option : filtre par consultant
	if ($user_guid) $options['owner_guids'] = $user_guid;
	$time_trackers = elgg_get_entities_from_metadata($options);
	$count_time_trackers = count($time_trackers);
	//error_log("TEST : $year, $month, $date_stamp, $project_guid, $user_guid, $count_time_trackers : $count_time_trackers");
	// Décompte du temps passé pour chaque saisie
	if (is_array($time_trackers)) foreach ($time_trackers as $ent) {
		// Option : filtre par projet
		if (!empty($project_guid) && ($ent->project_guid != $project_guid)) continue;
		// Option : filtre par type de projet
		if ($exclude_meta && in_array($ent->project_guid, array('P', 'A', 'T', 'G', 'C'))) continue;
		// Option : filtre par consultant
		if ($exclude_other && $user_guid && ($user_guid != $ent->owner_guid)) continue;
		// Ajout du temps
		$total_hours += time_tracker_get_total_time_tracker($ent);
	}
	return round($total_hours, 3);
}

// Sums up monthly times to yearly times
function time_tracker_yearly_time($year, $project_guid = false, $user_guid = false, $exclude_meta = false, $exclude_other = false) {
	$yearly_time = 0;
	$max_month = 12;
	if ($year == date('Y')) $max_month = date('m');
	for ($month = 1; $month <= $max_month; $month++) {
		$yearly_time += time_tracker_monthly_time($year, $month, $project_guid, $user_guid, $exclude_meta, $exclude_other);
	}
	return $yearly_time;
}

/* V1 basée sur les frais notés directement sur chaque saisie
function time_tracker_monthly_frais($year, $month, $project_guid = false, $user_guid = false, $exclude_meta = false, $exclude_other = false) {
	$total_frais = 0;
	// Affichage saisies pour projets déjà déclarés du mois demandé
	if (strlen($month) == 1) $date_stamp = (string)$year.'0'.$month;
	else $date_stamp = (string)$year.$month;
	$options = array(
			'metadata_names' => 'date_stamp', 'metadata_values' => $date_stamp, 
			'types' => 'object', 'subtypes' => 'time_tracker',
			'limit' => 10, 'offset' => 0, 'order_by' => '', 'count' => true,
		);
	// Option : filtre par consultant
	if ($user_guid) $options['owner_guids'] = $user_guid;
	$count_time_trackers = elgg_get_entities_from_metadata($options);
	$options['count'] = false;
	$options['limit'] = $count_time_trackers;
	$time_trackers = elgg_get_entities_from_metadata($options);
//error_log("TEST : $year, $month, $date_stamp, $project_guid, $user_guid, $count_time_trackers : " . sizeof($time_trackers));
	if (is_array($time_trackers)) foreach ($time_trackers as $ent) {
		// Option : filtre par projet
		if (!empty($project_guid) && ($ent->project_guid != $project_guid)) continue;
		if ($exclude_meta && in_array($ent->project_guid, array('P', 'A', 'T', 'G', 'C'))) continue;
		if ($exclude_other && $user_guid && ($user_guid == $ent->owner->guid)) continue;
		$total_frais += $ent->cost;
	}
	return round($total_frais, 3);
}
*/

// V2 qui s'appuie sur les saisies des frais par projet (hors des feuilles de temps)
function time_tracker_monthly_frais($year, $month, $project_guid = false, $user_guid = false, $exclude_meta = false, $exclude_other = false, $validated = false) {
	$total_frais = 0;
	// 1. Construction de la liste des projets concernés (dépend paramètres projet et membre)
	// Liste de tous les frais pour une personne : frais propres + ceux des projets
	if ($user_guid && ($user = get_entity($user_guid))) {
		if ($project_guid && ($project = get_entity($project_guid)) ) {
			// Si projet particulier : on restreint le champ au projet choisi seulement (pas de frais non-affecté)
			$projects = array($project);
		} else {
			// sinon tous projets + frais non-affectés
			$projects = time_tracker_get_projects($user_guid);
			$projects[] = $user;
		}
	// Liste globale = frais de tous les consultants
	} else {
		if ($project_guid && ($project = get_entity($project_guid)) ) {
			// Si projet particulier : on restreint le champ au projet choisi seulement (pas de frais non-affecté)
			$projects = array($project);
		} else {
			// sinon tous les projets + frais non-affectés
			$projects = time_tracker_get_projects();
			$consultants = project_manager_get_consultants();
			foreach ($consultants as $guid => $ent) { $projects[] = $ent; }
		}
	}
	
	// 2. Récupération des frais : de tous les projets + tous les membres, ou d'un projet/membre si défini
	// A ce stade, on a déjà filtré les saisies par projet, mais chaque saisie affectée doit être filtrée par membre
	if ($projects) 
	foreach ($projects as $ent) {
		// Données source récupérées via les données des projets
		$project_expenses = unserialize($ent->project_expenses);
		
		// Si le projet est un membre, pas besoin de filtrer par membre
		if ($ent instanceof ElggUser) {
			// Pour chacun des membres ayant saisi (donc ici forcément 1 seul)
			if (is_array($project_expenses)) 
			foreach ($project_expenses as $guid => $member_expenses) {
				// Pour chacune des saisies
				if (is_array($member_expenses)) 
				foreach ($member_expenses as $id => $expenses) {
					$total_frais += project_manager_add_expenses($expenses, $year, $month, $validated);
				}
			}
			
		// Si le projet est un projet, on doit filtrer par membre
		} else {
			// Si filtre par membre : somme pour ce membre seulement
			if ($user) {
				// Ssi ce membre a des frais sur ce projet
				if (is_array($project_expenses[$user_guid])) 
				// Ajout de chacun des frais
				foreach ($project_expenses[$user_guid] as $id => $expenses) {
					$total_frais += project_manager_add_expenses($expenses, $year, $month, $validated);
				}
				
			// Pas de filtre par membre : on additionne tout
			} else {
				// Somme pour tous les membres ayant eu des saisies sur ce projet
				// Pour chacun des membres ayant saisi
				if (is_array($project_expenses)) 
				foreach ($project_expenses as $guid => $member_expenses) {
					foreach ($member_expenses as $id => $expenses) {
						$total_frais += project_manager_add_expenses($expenses, $year, $month, $validated);
					}
				}
			}
			
		}
		
	}
	
	//return round($total_frais, 3);
	return round($total_frais, 2);
	//return $total_frais;
}

function project_manager_add_expenses($expenses, $year = false, $month = false, $validated = false) {
	// Si demandé, on saute les saisies non validées
	if ($validated && ($expenses['status'] != 'validated')) return 0;
	// Filtre par date
	// Extraction des dates (YYYY-MM-DD)
	if ($year || $month) {
		$dates = explode('-', $expenses['date']);
	}
	// Si demandé, on filtre par année (doit être identique ou on saute)
	if ($year && ($dates[0] != $year)) return 0;
	// Si demandé, on filtre par mois (doit être identique ou on saute)
	if ($month && ($dates[1] != $month)) return 0;
	// On peut ajouter les frais
	// Note : filtre par mois sans année possible (= toutes les frais en janvier)
	return $expenses['frais'];
}

// Calcule le temps passé pour un mois donné, à partir de l'entité de saisie
function time_tracker_get_total_time_tracker($time_tracker = false) {
	if (!$time_tracker) return false;
	// If already computed data, return it.
	if (isset($time_tracker->total_hours)) return $time_tracker->total_hours;
	// Otherwise, let's compute and store it, + update datamodel
	$total_hours = 0;
	/* Simplification pour gagner du temps de calcul..
	// Comptage des temps du mois
	$date_timestamp = mktime(0, 0, 0, $time_tracker->month, 1, $time_tracker->year); // timestamp au 1er du mois
	$count_days_in_month = date('t', $date_timestamp);
	for ($i = 1; $i <= $count_days_in_month; $i++) {
	*/
	$ent->time_tracker = null; // Suppression des données redondantes (ancien datamodel)
	for ($i = 1; $i <= 31; $i++) {
		if (!isset($time_tracker->{'day'.$i.'_hours'})) continue;
		$total_hours += (float)$time_tracker->{'day'.$i.'_hours'};
		// Use following to clean empty values
		//if (empty($time_tracker->{'day'.$i.'_hours'})) $time_tracker->{'day'.$i.'_hours'} = null;
		$time_tracker->{'day'.$i.'_extra_hours'} = null; // Clean unused metadata
	}
	$time_tracker->total_hours = $total_hours;
	return $total_hours;
}

// Calcule le coût total d'un consultant sur un mois donné, sur la base d'un taux journalier
function time_tracker_monthly_cost($user_guid, $project = false) {
	$user = get_entity($user_guid);
	if (!elgg_instanceof($user, 'user')) { return false; }
	$pm_meta = project_manager_get_user_metadata();
	switch($ent->{$pm_meta}) {
		case 'salarie':
			$rate = $user->daily_cost;
			break;
		case 'non-salarie':
			$rate = (($ent->yearly_global_cost / 12) * $coef_salarial) + ($ent->yearly_variable_part * $coef_pv / 12);
			break;
		default:
	}
	// @TODO : cette fonction utilise année et mois, pas l'user et le project !
	//return time_tracker_monthly_time($user_guid, $project) * $rate;
	return time_tracker_monthly_time($year, $month, $project, $user_guid) * $rate;
}


// Calcule le CJM d'un consultant salarié
function time_tracker_get_user_daily_cost($user) {
	$pm_meta = project_manager_get_user_metadata();
	if ($user->{$pm_meta} == 'salarie') {
		$coef_salarial = elgg_get_plugin_setting('coefsalarie', 'project_manager');
		$coef_pv = elgg_get_plugin_setting('coefpv', 'project_manager');
		$days_per_month = elgg_get_plugin_setting('dayspermonth', 'project_manager');
		$monthly_global_cost = $user->yearly_global_cost / 12;
		$monthly_cost = ($monthly_global_cost * $coef_salarial) + ($user->yearly_variable_part * $coef_pv / 12);
		$dailycost = round(($monthly_cost / $days_per_month), 3);
		return $dailycost;
	}
	return false;
}

/* Liste les temps passés sur un projet donné, par tranche de temps et par personne
 * $project_guid : GUID du projet
 * $return_array : renvoyer le tableau de valeurs plutôt que le texte
*/
function time_tracker_project_times($project_guid = false, $return_array = false) {
	if (empty($project_guid)) { return false; }
	$content = '';
	$months = time_tracker_get_date_table('months');
	$options = array(
			'metadata_names' => 'project_guid', 'metadata_values' => $project_guid, 
			'types' => 'object', 'subtypes' => 'time_tracker',
			'limit' => false, 'offset' => 0, 'order_by' => 'time_created asc', 'count' => false,
		);
	$time_trackers = elgg_get_entities_from_metadata($options);
	$count_time_trackers = count($time_trackers);
	$project_times = array(); // year -> month -> member -> days
	if (is_array($time_trackers)) foreach($time_trackers as $ent) {
		// @todo : regrouper par date et par personne
		//$project_times[$ent->year][$ent->month][$ent->owner_guid] = $ent->days + (round(($ent->hours / 7), 1));
		$project_times[$ent->year][$ent->month][$ent->owner_guid] = time_tracker_get_total_time_tracker($ent);
	}
	if ($return_array) return $project_times;
	
	$total_project = 0;
	if (is_array($project_times)) {
		$content .= '<table class="project_manager" style="width:100%;">';
		// Pour chaque année
		foreach ($project_times as $year => $year_project_times) {
			//$content .= "<h4>$year</h4>";
			$content .= '<tr><th scope="colgroup" colspan="4">' . $year . '</th></tr>';
			$total_year = 0;
			if (is_array($year_project_times)) {
				// Pour chaque mois de l'année
				foreach ($year_project_times as $month => $month_project_times) {
					//$content .= "<h5>" . $months[(int)$month] . "</h5>";
					$content .= '<tr>';
					$content .= '<th rowspan="' . (1+sizeof($month_project_times)) . '" scope="rowgroup">' . $months[(int)$month] . '</th>';
					$total_month = 0;
					$month_content = '';
					if (is_array($month_project_times)) {
						// Pour chaque saisie du mois
						foreach ($month_project_times as $user_guid => $days) {
							$user = get_entity($user_guid);
							$month_content .= '<tr><td scope="row">' . $user->name . ' &nbsp; <a href="' . elgg_get_site_url() . 'time_tracker/owner/Facyla/' . $year . $month . '" target="_blank">' . elgg_echo('time_tracker:display_user_month') . '</a></td><td>' . $days . '</td></tr>';
							$total_month += (float)$days;
						}
						//$content .= "<strong>" . elgg_echo('time_tracker:total:permonth') . " " . $months[(int)$month] . ": " . round($total_month, 2) . "</strong><br /><br />";
						$content .= '<td colspan="2" scope="col"><strong>' . elgg_echo('project_manager:report:saisies') . '</strong></td><td class="inner-result" rowspan="' . (1+sizeof($month_project_times)) . '">' . round($total_month, 2) . '</td></tr>';
						$content .= $month_content;
					} else $content .= '<tr><td colspan="4">' . elgg_echo('time_tracker:noinput') . '</td></tr>';
					$content .= '</tr>';
					$total_year += $total_month;
				}
			} else $content .= '<tr><td colspan="4">' . elgg_echo('time_tracker:noinput') . '</td></tr>';
			$content .= '<tr><th scope="row" colspan="3">' . elgg_echo('time_tracker:total:peryear') . ' ' . $year . '</th><td class="result">' . round($total_year, 2) . '</td></tr>';
			$content .= '<tr><td colspan="4">&nbsp;</td></tr>';
			$total_project += $total_year;
		}
		$content .= '<tr><th scope="row" colspan="3">' . elgg_echo('time_tracker:total:perproject') . '</th><td class="result">' . round($total_project, 2) . '</td></tr>';
		$content .= '</table>';
	} else {
		$content .= '<p>' . elgg_echo('time_tracker:noinput') . '</p>';
	}
	
	if (!empty($content)) return $content;
	return elgg_echo('time_tracker:noinput');
}

/* Renvoie le temps total passé sur un projet
 * $project_guid : GUID du projet
 * $year : (optionnel) filtre sur une année particulière
 * $month : (optionnel) filtre sur un mois particulier
*/
function time_tracker_project_total_time($project_guid = false, $year = false, $month = false) {
	if (empty($project_guid)) return false;
	$total_time = 0;
	$options = array(
			'metadata_names' => 'project_guid', 'metadata_values' => $project_guid, 
			'types' => 'object', 'subtypes' => 'time_tracker',
			'limit' => false, 'offset' => 0, 'order_by' => 'time_created asc', 'count' => false,
		);
	$time_trackers = elgg_get_entities_from_metadata($options);
	$count_time_trackers = count($time_trackers);
	if (is_array($time_trackers)) foreach($time_trackers as $ent) {
		// Filtre selon les cas
		if ($year && $month) {
			if (($year == $ent->year) && ($month == $ent->month)) $total_time += time_tracker_get_total_time_tracker($ent);
		} else if ($year) {
			if ($year == $ent->year) $total_time += time_tracker_get_total_time_tracker($ent);
		} else if ($month) {
			if ($month == $ent->month) $total_time += time_tracker_get_total_time_tracker($ent);
		} else {
			$total_time += time_tracker_get_total_time_tracker($ent);
		}
	}
	return $total_time;
}



// FONCTIONS UTILES (DATES)

/* Calcul du nombre de jours ouvrés dans un an ou dans un mois donné
 * Année obligatoire
 * Mois optionnel
*/
function time_tracker_nb_jours_ouvrable($year = false, $month = false) {
	$total_ouvrables = 0;
	if (!$year) return false;
	// Comptage mensuel seulement
	if ($month) {
		$date_timestamp = mktime(0, 0, 0, (int)$month, 1, $year);
		$days_in_month = date('t', $date_timestamp);
		for ($day = 1; $day <= $days_in_month; $day++) {
			$total_ouvrables += time_tracker_jour_ouvrable($year, $month, $day);
		}
	// Comptage annuel
	} else {
		for ($month = 1; $month <= 12; $month++) {
			$date_timestamp = mktime(0, 0, 0, (int)$m, 1, $year);
			$days_in_month = date('t', $date_timestamp);
			for ($day = 1; $day <= $days_in_month; $day++) {
				$total_ouvrables += time_tracker_jour_ouvrable($year, $month, $day);
			}
		}
	}
	return $total_ouvrables;
}

/* Déterminer si une date donnée est un jour ouvrable
 * Renvoie 0 si non ouvré, et 1 si ouvrable, false si date invalide
 * $weekend : si true, inclut les weekend dans les jours non ouvrés (sinon seulement jours fériés spéciaux)
 * 
*/
function time_tracker_jour_ouvrable($year, $month, $day, $weekend = true) {
	if (!($year && $month && $day)) return false;
	$comp_date = (int)$day . '-' . (int)$month; // format 'j-n'
	// Jours fériés fixes
	// 1er janvier, 1er mai, 8 mai, 14 juillet, 15 août, 1er novembre, 11 novembre, 25 décembre
	$ferie_fixes = array( '1-1', '1-5', '8-5', '14-7', '15-8', '1-11', '11-11', '25-12');
	if (in_array($comp_date, $ferie_fixes)) return 0;
	if ($weekend) {
		// Dimanche(0) ou Samedi(6) - on prend à midi
		$date = mktime(12, 0, 0, (int)$month, $day, (int)$year);
		if ((date('w',$date)==0) || (date('w',$date)==6) ) { return 0; }
	}
	// Pâques et dates liées
	if (($year < 1970) || ($year > 2037)) {
		error_log("DEBUG : fonction non valide dans cet intervale $year");
	} else {
		$date_paques = @easter_date((int)$year);
		$date_ascension = $date_paques + 3369600;
		$date_pentecote = $date_paques + 4320000;
		// En 2013 : bug pascal cf. http://dev.webpulser.com/tips/ya-un-bug-pascal-tes-pas-a-lheure/
		if (date('w', $date_paques) == 0) { $date_paques += 86400; }
		$comp_paques = date('j-n',$date_paques);
		if ($comp_date == $comp_paques) { return 0; }
		// Ascension (40 jours après Pâques)
		$comp_ascension = date('j-n',$date_ascension);
		if ($comp_date == $comp_ascension) { return 0; }
		// Pentecote (50 jours après Pâques)
		$comp_pentecote = date('j-n',$date_pentecote);
		if ($comp_date == $comp_pentecote) { return 0; }
	}
	// Si aucun jour spécial => c'est bien un jour ouvré
	return 1;
}


// CONVERSION DE DEVISES
function project_manager_convert_toeuro($value = 0, $from_code = 'EUR', $invert = false) {
	$site = elgg_get_site_entity();
	if ($from_code == 'EUR') return $value;
	
	// On récupère ou on met en cache quotidiennement ces infos
	if ($site->project_manager_currencies_ts >= (time() - 3600*24)) {
		$currency_array = unserialize($site->project_manager_currencies);
		
	// On récupére les taux de change stockés sur le site, ou on les met à jour si elles ont plus de X secondes (1 jour)
	} else {
		$currency_array = array();
		// http://www.ecb.europa.eu/stats/exchange/eurofxref/html/index.en.html#info
		//Read eurofxref-daily.xml file in memory 
		//For this command you will need the config option allow_url_fopen=On (default)
		$XMLContent = file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
		//the file is updated daily between 2.15 p.m. and 3.00 p.m. CET
		foreach($XMLContent as $line){
			if(preg_match("/currency='([[:alpha:]]+)'/",$line,$currencyCode)){
				if(preg_match("/rate='([[:graph:]]+)'/",$line,$rate)){
					$currency_array[$currencyCode[1]] = $rate[1];
				}
			}
		}
		// Si données valides => sauvegarde, sinon on récupère les anciennes
		if (sizeof($currency_array) > 0) {
error_log("CURENCIES : MAJ des taux de conversion des devises fait le " . date("d/m/Y à h", time()));
			$site->project_manager_currencies_ts = time();
			$site->project_manager_currencies = serialize($currency_array);
		} else {
			$currency_array = unserialize($site->project_manager_currencies);
		}
	}
	// Conversion
	$rate = $currency_array[$from_code];
	if (empty($rate)) return false;
	if ($invert) $euro_value = $value / $rate; else $euro_value = $value * $rate;
	return $euro_value;
}



