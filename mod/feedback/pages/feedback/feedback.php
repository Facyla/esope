<?php
global $CONFIG;
gatekeeper();

$base_url = $CONFIG->url . 'feedback/';

elgg_set_context('feedback');
elgg_push_breadcrumb('feedback', $CONFIG->url . 'feedback');


// FEEDBACKS LIST
//$content = elgg_view('feedback/list_feedbacks', array());
// Note : the view is replaced by its content here, because we have the counters in it

//$base_url = $vars['url'] . 'feedback/';

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$status_filter = get_input('status', false); // Status filter
$about_filter = get_input('about', false); // About/type filter
$mood_filter = get_input('mood', false); // Mood filter

// Allow members to read feedbacks ?
$memberview = elgg_get_plugin_setting("memberview", "feedback");
if ($memberview != 'yes') { admin_gatekeeper(); }

$feedbackgroup = elgg_get_plugin_setting('feedbackgroup', 'feedback');
if (!empty($feedbackgroup) && ($feedbackgroup != 'no') && ($feedbackgroup != 'grouptool')) {
	if ($group = get_entity($feedbackgroup)) {
		elgg_set_page_owner_guid($feedbackgroup);
		//$base_url .= 'group/' . $feedbackgroup;
		if (!elgg_in_context('feedback')) $limit = get_input('limit', 3);
	} else elgg_set_page_owner_guid($CONFIG->site->guid);
}

//$all_feedback_count = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'count' => true));
//$all_feedback = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => $all_feedback_count));
$all_feedback = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => false));
$feedbacks = array();
$feedback_open = 0; $feedback_closed = 0;
$feedback_content = 0; $feedback_bug = 0; $feedback_suggestion = 0; $feedback_question = 0;
$feedback_feedback = 0; // Non défini
$all_feedback_count = count($all_feedback);

foreach ($all_feedback as $ent) {
	// Uncomment to update 1.6 version to 1.8 version metadata - use once if needed, then comment again
	//if (!empty($ent->state)) { $ent->status = $ent->state; $ent->state = null; }
	// Uncomment to correct title bug retroactively - use once if needed, then comment again
	/*
	global $is_admin; $ignore_admin = $is_admin; $is_admin = true;
	if (!empty($ent->txt)) {
		$ent->title = substr(strip_tags($ent->txt), 0, 50);
		$ent->save();
	}
	$is_admin = $ignore_admin;
	*/
	
	// Stats
	if (!isset($ent->status) || empty($ent->status) || ($ent->status == 'open')) {
		$feedback_open++;
		if (!isset($ent->about) || empty($ent->about) || ($ent->about == 'other')) { $feedback_feedback++; } 
		else if ($ent->about == 'content') { $feedback_content++; }
		else if ($ent->about == 'bug_report') { $feedback_bug++; } 
		else if ($ent->about == 'suggestions') { $feedback_suggestion++; }
		else if ($ent->about == 'compliment') { $feedback_compliment++; }
		else if ($ent->about == 'question') { $feedback_question++; }
	} else if ($ent->status == 'closed') { $feedback_closed++; }
	// Filter : if filter(s) set, add only corresponding feedbacks
	if ( (!isset($ent->status) || !$status_filter || ($ent->status == $status_filter)) 
		&& (!isset($ent->about) || !$about_filter || ($ent->about == $about_filter)) ) { $feedbacks[] = $ent; }
}
$feedbacks_count = count($feedbacks);

// Paginate feedbacks
$displayed_feedbacks = array_slice($feedbacks, $offset, $limit);
$content .= elgg_view_entity_list($displayed_feedbacks, array('count' => $feedbacks_count, 'offset' => $offset, 'limit' => $limit, 'full_view' => false, 'list_type_toggle' => false, 'pagination' => true));
$content .= '<div class="clearfloat"></div>';



// Sidebar menu - Menu latéral
$sidebar = '<div id="site-categories">';
$sidebar .= '<h2>Feedbacks</h2>';
$sidebar .= '<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-categories elgg-menu-owner-block-default">';
if (full_url() == $base_url) $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url.'feedback">'.$all_feedback_count.' feedbacks</a></li>';
if (full_url() == $base_url . 'status/open') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'status/open">'.$feedback_open.' à traiter</a></li>';
if (full_url() == $base_url . 'status/closed') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'status/closed">'.$feedback_closed.' fermés</a></li>';
$sidebar .= '</ul>';
$sidebar .= '<h2>A traiter</h2>';
$sidebar .= '<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-categories elgg-menu-owner-block-default">';
if (full_url() == $base_url . 'about/content') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'about/content">'.$feedback_content.' signalements</a></li>';
if (full_url() == $base_url . 'about/bug_report') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'about/bug_report">'.$feedback_bug.' dysfonctionnements</a></li>';
if (full_url() == $base_url . 'about/suggestions') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'about/suggestions">'.$feedback_suggestion.' suggestions</a></li>';
if (full_url() == $base_url . 'about/question') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'about/question">'.$feedback_question.' questions</a></li>';
if (full_url() == $base_url . 'about/compliment') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'about/compliment">'.$feedback_feedback.' compliments</a></li>';
if (full_url() == $base_url . 'about/other') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'about/other">'.$feedback_feedback.' non classés</a></li>';
$sidebar .= '</ul>';
$sidebar .= '</div>';


// Titre de la page
$title = elgg_echo('feedback:admin:title') . " ($feedbacks_count)";
if (!empty($status_filter)) $title .= ' ' . elgg_echo('feedback:status:'.$status_filter);
if (!empty($about_filter)) $title .= ' ' . elgg_echo('feedback:about') . ' &laquo;&nbsp;' . elgg_echo('feedback:about:'.$about_filter) . '&nbsp;&raquo;';


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

echo elgg_view_page(strip_tags($title), $body);

