<?php
/**
 * Profile info box
 */

$content = '';


$profile = '<div class="profile">
	<div class="elgg-inner clearfix">' . elgg_view('profile/owner_block') . '</div>
</div>';

$profile_details = elgg_view('profile/details');

// Theme settings : Add activity feed ? (default: no)
//if ($add_profile_activity == 'yes') {
	$db_prefix = elgg_get_config('dbprefix');
	$user = elgg_get_page_owner_entity();
	elgg_set_context('widgets');
	$activity = elgg_list_river(array('subject_guids' => $user->guid, 'limit' => 6, 'pagination' => true));
	$activity = '<div class="profile-activity-river">' . $activity . '</div>';
	elgg_pop_context();
//}

// Theme settings : Remove widgets ? (default: no)
//if ($remove_profile_widgets != 'yes') {
	$params = array('num_columns' => 3);
	$widgets = elgg_view_layout('widgets', $params);
//}


echo '<div class="elgg-grid">
	<div style="float:left; width:24%;">' . $profile . '</div>
	<div style="float:left; width:50%;">' . $profile_details . '</div>
	<div style="float:right; width:24%;">' . $activity . '</div>
	<div class="clearfloat"></div>
</div>
<div class="profile-widgets">' . $widgets . '</div>';


