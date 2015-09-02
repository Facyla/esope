<?php
global $CONFIG;
gatekeeper();

$base_url = elgg_get_site_url() . 'feedback/';

elgg_set_context('feedback');
elgg_push_breadcrumb('feedback', $base_url);


// FEEDBACKS LIST
//$content = elgg_view('feedback/list_feedbacks', array());
// Note : the view is replaced by its content here, because we have the counters in it


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

//$count_all = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'count' => true));
//$all_feedbacks = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => $count_all));
$all_feedbacks = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => false));
$feedbacks = array();
$open = 0;
$closed = 0;
$other = 0; // Non défini
$count_all = count($all_feedbacks);
$about_enabled = feedback_is_about_enabled();
$about_values = feedback_about_values();

if ($all_feedbacks) foreach ($all_feedbacks as $ent) {
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
		$open++;
		// Sort feedbacks in undefined vs specific about category
		if (!$about_enabled || empty($ent->about) || in_array($ent->about, array('other', 'feedback'))) {
			$other++;
		} else {
			if (isset(${"feedback_" . $ent->about})) {
				${"feedback_" . $ent->about}++;
			} else {
				${"feedback_" . $ent->about} = 1;
			}
		}
		
	} else if ($ent->status == 'closed') { $closed++; }
	// Filter : if filter(s) set, add only corresponding feedbacks
	if (
		(!isset($ent->status) || !$status_filter || ($ent->status == $status_filter)) 
		&& (!isset($ent->about) || !$about_filter || ($ent->about == $about_filter))
		) { $feedbacks[] = $ent; }
}
$count = count($feedbacks);

// Paginate feedbacks
$displayed_feedbacks = array_slice($feedbacks, $offset, $limit);
$content .= elgg_view_entity_list($displayed_feedbacks, array('count' => $count, 'offset' => $offset, 'limit' => $limit, 'full_view' => false, 'list_type_toggle' => false, 'pagination' => true));
$content .= '<div class="clearfloat"></div>';



// Sidebar menu - Menu latéral
$sidebar = '<div id="site-categories">';
$sidebar .= '<h2>' . elgg_echo('feedback'). '</h2>';
$sidebar .= '<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-categories elgg-menu-owner-block-default">';
if (full_url() == $base_url) $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url.'feedback">' . elgg_echo('feedback:menu:total', array($count_all)) . '</a></li>';
if (full_url() == $base_url . 'status/open') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'status/open">' . elgg_echo('feedback:menu:open', array($open)) . '</a></li>';
if (full_url() == $base_url . 'status/closed') $selected = ' class="elgg-state-selected"'; else $selected = '';
$sidebar .= '<li' . $selected . '><a href="'.$base_url . 'status/closed">' . elgg_echo('feedback:menu:closed', array($closed)) . '</a></li>';
$sidebar .= '</ul>';

// Add open filter only if there are about categories
if ($about_enabled && (sizeof($about_values) > 1)) {
	$sidebar .= '<h2>' . elgg_echo('feedback:status:open'). '</h2>';
	$sidebar .= '<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-categories elgg-menu-owner-block-default">';

	foreach ($about_values as $about) {
		if (!in_array($about, array('other', 'feedback'))) {
			if ($about == $about_filter) {
				$sidebar .= '<li class="elgg-state-selected">';
			} else {
				$sidebar .= '<li>';
			}
			$sidebar .= '<a href="'.$base_url . 'about/' . $about . '">' . elgg_echo("feedback:menu:$about", array(${"feedback_$about"})) . '</a></li>';
		}
	}
	// Always add "other" (undefined) feedbacks
	if (!$about_filter || in_array($about_filter, array('other', 'feedback'))) {
		$sidebar .= '<li class="elgg-state-selected"><a href="'.$base_url . 'about/other">' . elgg_echo("feedback:menu:other", array($other)) . '</a></li>';
	} else {
		$sidebar .= '<li><a href="'.$base_url . 'about/other">' . elgg_echo("feedback:menu:other", array($other)) . '</a></li>';
	}
	$sidebar .= '</ul>';
}
$sidebar .= '</div>';


// Titre de la page
$title = '<i class="fa fa-bullhorn"></i> ' . elgg_echo('feedback:admin:title') . " ($count)";
if (!empty($status_filter)) {
	$title .= ' ' . elgg_echo('feedback:status:'.$status_filter);
}
if (!empty($about_filter)) {
	$title .= ' ' . elgg_echo('feedback:about') . ' &laquo;&nbsp;' . elgg_echo('feedback:about:'.$about_filter) . '&nbsp;&raquo;';
}


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

echo elgg_view_page(strip_tags($title), $body);

