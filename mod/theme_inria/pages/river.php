<?php
/**
 * Main activity stream list page
 */

gatekeeper();

$user = elgg_get_logged_in_user_entity();

$options = array();

$options['no_results'] = '<p class="esope-search-noresult">' . elgg_echo('search:no_results') . '</p>';


// Iris : enable parameters interception if no JS
$river_selector = get_input('river_selector');
if (!empty($river_selector)) {
	//$river_selector = urldecode($river_selector);
	$river_selector = str_replace('&amp;', '&', $river_selector);
	$selector = $river_selector;
	$river_selector = explode('&', $river_selector);
	foreach($river_selector as $s) {
		$s = explode('=', $s);
		$name = $s[0];
		$value = $s[1];
		if ($name == 'type') { set_input('type', $value); }
		else if ($name == 'subtype') { set_input('subtype', $value); }
		else if ($name == 'action_types') { set_input('action_types', $value); }
	}
}


$page_type = preg_replace('[\W]', '', get_input('page_type', 'all'));
$username = get_input('username', $vars);
if (($page_type == 'owner') && !empty($username)) {
	$ent = get_user_by_username($username);
	if (elgg_instanceof($ent, 'user')) {
		$user = $ent;
	} else {
		$page_type = 'mine';
	}
	elgg_set_page_owner_guid($user->guid);
}
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
$date_filter = preg_replace('[\W]', '', get_input('date_filter', 'all'));
$action_types = get_input('action_types', '');
if (!empty($action_types)) { $action_types = explode(',', $action_types); } else { $action_types = false; }

// Dernier login : si aucun, depuis la création du site
$site = elgg_get_site_entity();
$last_login = $user->prev_last_login;
if ($last_login < 1) { $last_login = $user->last_login; }
if ($last_login < 1) { $last_login = $site->time_created; }


// If no JS, pass raw selector instead
if (empty($river_selector)) {
	if ($subtype) {
		$selector = "type=$type&subtype=$subtype";
	} else {
		$selector = "type=$type";
	}
}

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		if ($subtype == 'pages') { $subtype = array('page_top', 'page'); }
		$options['subtype'] = $subtype;
	}
}

// Owner filter : mine, friends, all
switch($page_type) {
	case 'mine':
		$title = elgg_echo('river:mine');
		$page_filter = 'mine';
		$options['subject_guid'] = $user->guid;
		break;
	/*
	case 'owner':
		$title = elgg_echo('river:mine');
		$page_filter = 'owner';
		$options['subject_guid'] = $user->guid;
		break;
	*/
	case 'friends':
		$title = elgg_echo('river:friends');
		$page_filter = 'friends';
		$options['relationship_guid'] = $user->guid;
		$options['relationship'] = 'friend';
		break;
	default:
		//$title = elgg_echo('river:all');
		$title = elgg_echo('theme_inria:home:river');
		$page_filter = 'all';
		break;
}

// Date filter
switch($date_filter) {
	case 'today':
		$options['posted_time_upper'] = time();
		$options['posted_time_lower'] = strtotime('today midnight');
		break;
	case 'yesterday':
		$options['posted_time_upper'] = strtotime('today midnight')-1;
		$options['posted_time_lower'] = strtotime('yesterday midnight')-1;
		break;
	case 'lastweek':
		$options['posted_time_upper'] = time();
		$options['posted_time_lower'] = time()-7*24*60;
		break;
	case 'lastlogin':
		//error_log("Date : " . date('d-m-Y H:i:s', $last_login));
		$options['posted_time_upper'] = time();
		$options['posted_time_lower'] = $last_login;
		break;
	case 'all':
	default:
}

// Action types filter
if ($action_types) {
	$options['action_types'] = $action_types;
}

$activity = elgg_list_river($options);
if (!$activity) { $activity = elgg_echo('river:none'); }


$sidebar = elgg_view('core/river/sidebar');
$sidebar .= '<div class="clearfloat"></div>';
$sidebar .= '<h3>' . elgg_echo('theme_inria:search:filters') . '</h3>';

$sidebar .= elgg_view('core/river/filter', array('selector' => $selector));


$content = '';
/*
if ($page_type != 'mine') {
	$content .= '<blockquote class="river-inria-info">'.elgg_echo('theme_inria:activity:explanations').'</blockquote>';
	//$content .= '<div class="clearfloat"></div>';
}
*/
//$content .= elgg_view('core/river/filter', array('selector' => $selector));
$content .= '<div class="iris-box">' . $activity . '</div>';


$params = array(
	'title' => $title,
	'content' =>  $content,
	'sidebar' => $sidebar,
	'filter_context' => $page_filter,
	'class' => 'elgg-river-layout',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

