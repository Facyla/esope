<?php
gatekeeper();

$base_url = elgg_get_site_url() . 'feedback/';
$site = elgg_get_site_entity();

elgg_set_context('feedback');
elgg_push_breadcrumb('feedback', $base_url);


// FEEDBACKS LIST
//$content = elgg_view('feedback/list_feedbacks', array());
// Note : the view is replaced by its content here, because we have the counters in it


// Allow members to read feedbacks ?
$memberview = elgg_get_plugin_setting("memberview", "feedback");
if ($memberview != 'yes') { admin_gatekeeper(); }

$feedbackgroup = elgg_get_plugin_setting('feedbackgroup', 'feedback');
if (!empty($feedbackgroup) && ($feedbackgroup != 'no') && ($feedbackgroup != 'grouptool')) {
	if ($group = get_entity($feedbackgroup)) {
		elgg_set_page_owner_guid($feedbackgroup);
		//$base_url .= 'group/' . $feedbackgroup;
		if (!elgg_in_context('feedback')) $limit = get_input('limit', 3);
	} else elgg_set_page_owner_guid($site->guid);
}

// Useful vars
$feedbacks = array();
$status_values = array('open', 'closed', 'total');
foreach ($status_values as $status) { $$status = 0; }
$all_feedbacks = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => 0));
//$all_feedbacks = elgg_get_entities_from_metadata(array('type' => 'object', 'subtype' => 'feedback', 'limit' => false));
//$total = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'count' => true));
$total = count($all_feedbacks);
// Catégories de feedback
$about_enabled = feedback_is_about_enabled();
$about_values = feedback_about_values();
// Init all "about" counters (so we can have a 0 value instead of nothing)
foreach ($about_values as $about) { ${"feedback_$about"} = 0; }
// Catégorie de feedback non définie
$undefined_values = array('other', 'feedback', 'undefined');
$other = 0;

// Filters and params
$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$status_filter = get_input('status', ''); // Status filter
$about_filter = get_input('about', false); // About/type filter
$mood_filter = get_input('mood', false); // Mood filter
if (!in_array($status_filter, $status_values) && !empty($about_filter)) { $status_filter = 'open'; }
if ($status_filter == 'total') { $status_filter = ''; }

if ($all_feedbacks) foreach ($all_feedbacks as $ent) {
	// TOOL : Uncomment to update 1.6 version to 1.8 version metadata - use once if needed, then comment again
	//if (!empty($ent->state)) { $ent->status = $ent->state; $ent->state = null; }
	// TOOL : Uncomment to correct title bug retroactively - use once if needed, then comment again
	/*
	global $is_admin; $ignore_admin = $is_admin; $is_admin = true;
	if (!empty($ent->txt)) {
		$ent->title = substr(strip_tags($ent->txt), 0, 50);
		$ent->save();
	}
	$is_admin = $ignore_admin;
	*/
	
	
	// Filter : if filter(s) set, filter only corresponding feedbacks
	if (
		(!$status_filter || ($status_filter != 'total') && ($ent->status == $status_filter)) 
		&& (!$about_filter || ($ent->about == $about_filter) || (($about_filter == 'other') && (empty($ent->about) || in_array($ent->about, $undefined_values)))) 
		&& (!$mood_filter || ($ent->mood == $mood_filter)) 
		) {
			$feedbacks[] = $ent;
		}
}
$count = count($feedbacks);

// Paginate feedbacks
$displayed_feedbacks = array_slice($feedbacks, $offset, $limit);
$content .= elgg_view_entity_list($displayed_feedbacks, array('count' => $count, 'offset' => $offset, 'limit' => $limit, 'full_view' => false, 'list_type_toggle' => false, 'pagination' => true));
$content .= '<div class="clearfloat"></div>';



// Sidebar menu - Menu latéral
$sidebar = elgg_view('feedback/sidebar');



// Titre de la page
$title = '<i class="fa fa-bullhorn"></i> ' . elgg_echo('feedback:admin:title');
if (!empty($status_filter) && ($status_filter != 'total')) {
	$title .= ' ' . strtolower(elgg_echo('feedback:status:'.$status_filter));
}
if (!empty($about_filter)) {
	$title .= ' ' . elgg_echo('feedback:about') . ' &laquo;&nbsp;' . elgg_echo('feedback:about:'.$about_filter) . '&nbsp;&raquo;';
}
$title .= " ($count)";


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

echo elgg_view_page(strip_tags($title), $body);

