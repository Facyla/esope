<?php

/**
* Shows the newest members in the Digest
*
*/
global $digest_site_profile_body;

$interval = elgg_extract("interval", $vars);
$site_guid = elgg_get_site_entity()->getGUID();

$key = md5($interval . $site_guid);

if(!isset($digest_site_profile_body)){
	$digest_site_profile_body = array();
}

if(isset($digest_site_profile_body[$key])){
	// return from memory
	if(!empty($digest_site_profile_body[$key])){
		$title = elgg_view("output/url", array(
			"text" => elgg_echo("theme_inria:digest:members"),
			"href" => "members"
		));
		echo elgg_view_module("digest", $title , $digest_site_profile_body[$key]);
	}		
} else {
	$ts_lower = (int) elgg_extract("ts_lower", $vars);
	$ts_upper = (int) elgg_extract("ts_upper", $vars);
	
	// Display profiles or count only ?
	$display_count = true;
	$count_inria_only = true;
	$display_profiles = false;
	
	$member_options = array(
			"type" => "user",
			"limit" => 6,
			//"limit" => 0, // Iris : show all new users
			"relationship" => "member_of_site",
			"relationship_guid" => elgg_get_site_entity()->getGUID(),
			"inverse_relationship" => true,
			"order_by" => "r.time_created DESC",
			"wheres" => array("(r.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper . ")"),
			'count' => true,
	);
	// Total count
	//$total_members_count = elgg_get_entities_from_relationship($member_options);
	// Filter only Inria members
	if ($count_inria_only) {
		$member_options['metadata_name_value_pairs'][] = ['name' => 'custom_profile_type', 'value' => 'inria'];
	}
	$members_count = elgg_get_entities_from_relationship($member_options);
	if ($members_count > 0) {
		if ($count_inria_only) {
			$title = elgg_view("output/url", array("text" => elgg_echo("theme_inria:digest:members:inria"), "href" => "members", "is_trusted" => true));
		} else {
			$title = elgg_view("output/url", array("text" => elgg_echo("theme_inria:digest:members"), "href" => "members", "is_trusted" => true));
		}
	// Guests count
	//$guests_count = $total_members_count - $members_count;
	
		$content = '<div class="digest-profile">';
		
			// New members count
			if ($display_count) {
				$content .= '<span class="new-members-count" style="font-size:2rem; float:left; margin-right:2rem;">' . $members_count . '</span>';
				if ($count_inria_only) {
					$content .= '<p>' . elgg_echo('theme_inria:digest:newmembers:inria', array($members_count)) . '</p><p><a href="' . elgg_get_site_url() . 'members?order_by=desc">' . elgg_echo('theme_inria:digest:welcomenewmembers', array($members_count)) . '</a></p>';
				} else {
					$content .= '<p>' . elgg_echo('theme_inria:digest:newmembers', array($members_count)) . '</p><p><a href="' . elgg_get_site_url() . 'members?order_by=desc">' . elgg_echo('theme_inria:digest:welcomenewmembers', array($members_count)) . '</a></p>';
				}
			}
			
			// New members profiles
			if ($display_profiles) {
				$newest_members = elgg_get_entities_from_relationship(['count'=>false] + $member_options);
				foreach($newest_members as $index => $mem) {
					$profile_type = esope_get_user_profile_type($mem);
					if (empty($profile_type)) { $profile_type = 'external'; }
					$content .= '<div class="table-item">';
					//$content .= elgg_view_entity_icon($mem, 'medium', array('use_hover' => false)) . "<br />";
					$content .= '<div class="elgg-avatar elgg-avatar-medium profile-type-' . $profile_type . '"><a href="' .  $mem->getURL() . '"><img src="' . $mem->getIconUrl('medium') .  '" /></div><br />' . $mem->name . '</a><br />';
					$content .= $mem->briefdescription;
					// Add profile type badge, if defined
					if ($profile_type == 'external') { $content .= '<span class="iris-badge"><span class="iris-badge-' . $profile_type . '" title="' . elgg_echo('profile:types:'.$profile_type.':description') . '">' . elgg_echo('profile:types:'.$profile_type) . '</span></span>'; }
					$content .= "</div>";
				}
				$content .= '<div class="clearfloat"></div>';
			}
			
		$content .= '</div>';
	
		// Set global var for later reuse
		$digest_site_profile_body[$key] = $content;
		// View module if not empty
		echo elgg_view_module("digest", $title , $digest_site_profile_body[$key]);
	} else {
		$digest_site_profile_body[$key] = false;
	}
}

