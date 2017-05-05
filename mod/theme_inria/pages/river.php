<?php
/**
 * Main activity stream list page
 */

$options = array();

$page_type = preg_replace('[\W]', '', get_input('page_type', 'all'));
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
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

switch ($page_type) {
	case 'mine':
		$title = elgg_echo('river:mine');
		$page_filter = 'mine';
		$options['subject_guid'] = elgg_get_logged_in_user_guid();
		break;
	case 'friends':
		$title = elgg_echo('river:friends');
		$page_filter = 'friends';
		$options['relationship_guid'] = elgg_get_logged_in_user_guid();
		$options['relationship'] = 'friend';
		break;
	default:
		//$title = elgg_echo('river:all');
		$title = elgg_echo('theme_inria:home:wire');
		$page_filter = 'all';
		break;
}

$activity = elgg_list_river($options);
if (!$activity) {
	$activity = elgg_echo('river:none');
}



$sidebar = elgg_view('core/river/sidebar');
$sidebar .= '<div class="clearfloat"></div>';
$sidebar .= '<h3>' . "Filtres avancés" . '</h3>';

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

