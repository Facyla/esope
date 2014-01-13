<?php
/**
 * Profile info box
 */

$content = '';

$content  .= '<div class="profile">';
	$content  .= '<div class="elgg-inner clearfix">';
		$content  .= elgg_view('profile/owner_block');
		$content  .= elgg_view('profile/details');
	$content  .= '</div>';
$content  .= '</div>';

// Theme settings : Remove widgets ? (default: no)
if ($remove_profile_widgets != 'yes') {
	$params = array('content' => $content, 'num_columns' => 3);
	$content = elgg_view_layout('widgets', $params);
}
// Theme settings : Add activity feed ? (default: no)
if ($add_profile_activity == 'yes') {
	$db_prefix = elgg_get_config('dbprefix');
	$user = elgg_get_page_owner_entity();
	$activity = elgg_list_river(array('subject_guids' => $user->guid, 'limit' => 20, 'pagination' => true));
	$content .= '<div class="profile-activity-river">' . $activity . '</div>';
}

echo $content;

