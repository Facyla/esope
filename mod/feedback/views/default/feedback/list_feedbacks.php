<?php
$base_url = elgg_get_site_url() . 'feedback/';

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
		$base_url .= 'group/' . $feedbackgroup;
		if (!elgg_in_context('feedback')) $limit = get_input('limit', 3);
	} else elgg_set_page_owner_guid($CONFIG->site->guid);
}



//$all_feedback_count = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'count' => true));
//$all_feedback = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => $all_feedback_count));
$all_feedback = elgg_get_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => false));
$feedbacks = array();
$open = 0;
$closed = 0;
$other = 0; // Non défini
$about_enabled = feedback_is_about_enabled();
// Set filters counters
/*
if (feedback_is_about_enabled()) {
	$about_values = feedback_about_values();
	foreach($about_values as $about) { ${"feedback_$about"} = 0; }
}
*/

foreach ($all_feedback as $ent) {
	// Uncomment to update 1.6 version to 1.8 version metadata - use once if needed, then comment again
	//if (!empty($ent->state)) { $ent->status = $ent->state; $ent->state = null; }
	// Uncomment to correct title bug retroactively - use once if needed, then comment again
	/*
	global $is_admin; $ignore_admin = $is_admin; $is_admin = true;
	if (!empty($ent->description)) {
		$ent->title = substr(strip_tags($ent->description), 0, 50);
		$ent->save();
	}
	$is_admin = $ignore_admin;
	*/
	
	// Stats
	if ($ent->status == 'closed') {
		$closed++;
	} else {
	//} else if (!isset($ent->status) || empty($ent->status) || ($ent->status == 'open')) {
		$open++;
		/* Not used here
		if (!$about_enabled || !isset($ent->about) || empty($ent->about) || ($ent->about == 'other') || ($ent->about == 'feedback')) { $other++; } 
		// Sort feedbacks
		if (feedback_is_about_enabled()) {
			if (isset(${"feedback_$about"})) {
				${"feedback_$about"}++;
			} else {
				${"feedback_$about"} = 1;
			}
		}
		*/
	}
	
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

echo $content;

