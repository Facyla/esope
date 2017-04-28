<?php
/* Helpers and other Inria specific functions
 * 
 */

// INDEX PAGES

// Theme inria logged in index page
function theme_inria_index($page) {
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/loggedin_homepage.php');
	return true;
}

// Theme inria public index page
function theme_inria_public_index($page) {
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/public_homepage.php');
	return true;
}



// New "inria/" page handler
function inria_page_handler($page) {
	$base = elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/';
	switch($page[0]){
		case "userimage":
			include($base . 'userimage.php');
			break;
		case "userprofile":
			include($base . 'userprofile.php');
			break;
		case "usergroups":
			include($base . 'usergroups.php');
			break;
		case "linkedin":
			include($base . 'linkedin_profile_update.php');
			break;
		/*
		case "invite":
			include($base . 'invite_external.php');
			break;
		*/
		case "animation":
			include($base . 'admin_tools.php');
			break;
		case "share_url_generator":
			include($base . 'share_url_generator.php');
			break;
		case 'admin_cron':
			if (elgg_is_admin_logged_in()) {
				theme_inria_daily_cron('cron', 'daily', '', array('force' => 'yes'));
			}
			break;
		default:
			include($base . 'index.php');
	}
	return true;
}

// New "ressources/" page handler
function inria_ressources_page_handler($page) {
	//elgg_load_library('elgg:groups');
	$base = elgg_get_plugins_path() . 'theme_inria/pages/ressources/';
	$page_type = $page[0];
	// Only valid URL model : ressources/group/GUID/all (or without 'all')
	if (isset($page[1])) set_input('guid', $page[2]);
	switch ($page_type) {
		case 'group':
			include $base . 'group_ressources.php';
			break;
		default:
			return false;
	}
	return true;
}

// Override pour ajouter une explication sur la page thewire/all
function theme_inria_thewire_page_handler($page) {
	$base = elgg_get_plugins_path() . 'thewire/pages/thewire/';
	$esope_base = elgg_get_plugins_path() . 'esope/pages/thewire/';
	$inria_base = elgg_get_plugins_path() . 'theme_inria/pages/thewire/';
	if (!isset($page[0])) {
		$page = array('all');
	}

	switch ($page[0]) {
		case "all":
			include $inria_base . "everyone.php";
			break;

		case "friends":
			include $base . "friends.php";
			break;

		case "owner":
			include $base . "owner.php";
			break;

		case "group":
			//if (isset($page[1])) { set_input('guid', $page[1]); }
			include $esope_base . "group.php";
			break;

		case "view":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include $base . "view.php";
			break;

		case "thread":
			if (isset($page[1])) {
				set_input('thread_id', $page[1]);
			}
			include $base . "thread.php";
			break;

		case "reply":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include $base . "reply.php";
			break;

		case "tag":
			if (isset($page[1])) {
				set_input('tag', $page[1]);
			}
			include $base . "tag.php";
			break;

		case "previous":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include $base . "previous.php";
			break;

		default:
			return false;
	}
	return true;
}


// Override river PH to add an info block
function theme_inria_elgg_river_page_handler($page) {
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

	// make a URL segment available in page handler script
	$page_type = elgg_extract(0, $page, 'all');
	$page_type = preg_replace('[\W]', '', $page_type);
	if ($page_type == 'owner') {
		$page_type = 'mine';
	}
	set_input('page_type', $page_type);

	require_once(elgg_get_plugins_path() . "theme_inria/pages/river.php");
	return true;
}


// New "ressources/" page handler
function theme_inria_members_page_handler($page) {
	//elgg_load_library('elgg:groups');
	$base = elgg_get_plugins_path() . 'theme_inria/pages/';
	$page_type = $page[0];
	//if (isset($page[1])) set_input('guid', $page[2]);
	/*
	switch ($page_type) {
		default:
			include $base . 'members.php';
			return false;
	}
	*/
	include $base . 'members.php';
	return true;
}


