<?php
/**
 * Profile info box
 */

$content = '';

// Viewing a profile as someone else doesn't mean antyhing if you're not connected
if (elgg_is_logged_in()) {
	$own_user = elgg_get_logged_in_user_entity();
	$owner = elgg_get_page_owner_entity();
	
	// If viewed as someone else (or public), add some links to switch view
	// Get a random user for viewing
	$newest_members = elgg_get_entities(array('types' => 'user', 'limit' => 5));
	foreach ($newest_members as $ent) {
		if ($ent->isAdmin() || ($ent->guid == $own_user->guid)) continue;
		$random_member = $ent;
		$random_member_username = $random_member->username;
		break;
	}
	
	
	// Viewing a profile as someone else is limited to self profile (could lead to unwanted info leak if not..)
	if ($owner->guid == $own_user->guid) {
		$view_as = get_input('view_as', false);
		if ($view_as) {
			if ($view_as == 'public-profile') {
				// View public profile
				 //logout();
				// Note : can't use logout because it triggers the CAS logout event, which is not the attended result
				// We do not actually need to logout the user, but only lets logged in user have a view of his public profile
				theme_inria_temp_logout();
				$viewas_notes = '<strong>' . elgg_echo('esope:viewprofileas:public') . '</strong><br />';
				
			} else if ($view_as == 'member') {
				// Site member view
				theme_inria_temp_logout();
				if (theme_inria_temp_login($random_member)) {
					$viewas_notes = '<strong>' . elgg_echo('esope:viewprofileas:member') . '</strong><br />';
				} else { $view_as = false; }
				
			/*
			// @TODO : add if used - not yet
			} else if ($view_as == 'contact') {
				theme_inria_temp_logout();
				if (theme_inria_temp_login($random_member)) {
					$viewas_notes = '<strong>' . elgg_echo('esope:viewprofileas:contact') . '</strong><br />';
				}
			*/
				
			} else if ($view_as = get_user_by_username($view_as)) {
				// Specific user view
				theme_inria_temp_logout();
				if (theme_inria_temp_login($other_user)) {
					$viewas_notes = '<strong>' . elgg_echo('esope:viewprofileas:user') . '</strong><br />';
				} else { $view_as = false; }
			} else { $view_as = false; }
		}
		
		// View as switch links
		$viewas_notes .= elgg_echo('esope:viewprofileas:title') . '&nbsp;: ';
		if (!empty($view_as)) $viewas_notes .= '<a href="' . $own_user->getURL() . '">' . elgg_echo('esope:viewprofileas:yourself') . '</a> &nbsp; ';
		if ($view_as != 'member') $viewas_notes .= '<a href="' . $own_user->getURL() . '?view_as=member">' . elgg_echo('esope:viewprofileas:someonelse') . '</a> &nbsp; ';
		//$viewas_notes .= '<a href="' . $own_user->getURL() . '?view_as=friend">' . elgg_echo('esope:viewprofileas:acontact') . '</a> &nbsp; ';
		if ($view_as != 'public-profile') $viewas_notes .= '<a href="' . $own_user->getURL() . '?view_as=public-profile">' . elgg_echo('esope:viewprofileas:nonuser') . '</a>';
		
		echo '<div class="view-profile-as">' . $viewas_notes . '</div><div class="clearfloat"></div><br />';
	}
}

$profile = '<div class="profile"><div class="elgg-inner clearfix">' . elgg_view('profile/owner_block') . '</div></div>';

$profile_details = elgg_view('profile/details');

// Fil d'activité réservé aux membres
if (elgg_is_logged_in()) {
	// Theme settings : Add activity feed ? (default: no)
	//if ($add_profile_activity == 'yes') {
		$db_prefix = elgg_get_config('dbprefix');
		$user = elgg_get_page_owner_entity();
		elgg_set_context('widgets');
		$activity = elgg_list_river(array('subject_guids' => $user->guid, 'limit' => 8, 'pagination' => true));
		$activity = '<div class="profile-activity-river">' . $activity . '</div>';
		elgg_pop_context();
	//}
}

// Theme settings : Remove widgets ? (default: no)
//if ($remove_profile_widgets != 'yes') {
	$params = array('num_columns' => 3);
	$widgets = elgg_view_layout('widgets', $params);
//}


echo '<div class="elgg-grid">';
if (elgg_is_logged_in) {
	echo '<div style="float:left; width:24%;">' . $profile . '</div>';
	echo '<div style="float:left; width:50%;">' . $profile_details . '</div>';
	echo '<div style="float:right; width:24%;">' . $activity . '</div>';
} else {
	echo '<div style="float:left; width:24%;">' . $profile . '</div>';
	echo '<div style="float:right; width:72%;">' . $profile_details . '</div>';
}
echo '<div class="clearfloat"></div>';
echo'</div>';
echo'<div class="profile-widgets">' . $widgets . '</div>';

// Restore original user
if ($view_as) { theme_inria_temp_login($own_user); }

