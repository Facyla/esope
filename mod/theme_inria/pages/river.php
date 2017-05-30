<?php
/**
 * Main activity stream list page
 */

$own = elgg_get_logged_in_user_entity();
$options = array();

$options['no_results'] = '<p class="esope-search-noresult">' . elgg_echo('search:no_results') . '</p>';

$page_type = preg_replace('[\W]', '', get_input('page_type', 'all'));
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
$date_filter = preg_replace('[\W]', '', get_input('date_filter', 'all'));

if ($subtype) {
	$selector = "type=$type&subtype=$subtype";
} else {
	$selector = "type=$type";
}

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

// Owner filter : mine, friends, all
switch($page_type) {
	case 'mine':
		$title = elgg_echo('river:mine');
		$page_filter = 'mine';
		$options['subject_guid'] = $own->guid;
		break;
	case 'friends':
		$title = elgg_echo('river:friends');
		$page_filter = 'friends';
		$options['relationship_guid'] = $own->guid;
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
		$options['posted_time_lower'] = strtotime('today midnight');;
		break;
	case 'yesterday':
		$options['posted_time_upper'] = time()-24*60;
		$options['posted_time_lower'] = time()-2*24*60;
		break;
	case 'lastweek':
		$options['posted_time_upper'] = time();
		$options['posted_time_lower'] = time()-7*24*60;
		break;
	case 'lastlogin':
		//error_log("Date : " . date('d-m-Y H:i:s', $own->last_login) . "/ " . date('d-m-Y H:i:s', $own->prev_last_login));
		$options['posted_time_upper'] = time();
		$options['posted_time_lower'] = $own->prev_last_login;
		break;
	case 'all':
	default:
}


$activity = elgg_list_river($options);
if (!$activity) {
	$activity = elgg_echo('river:none');
}



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

