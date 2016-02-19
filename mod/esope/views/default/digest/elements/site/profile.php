<?php

/**
* Shows the newest members in the Digest
*
*/
global $digest_site_profile_body;

$interval = elgg_extract("user_interval", $vars);
$site_guid = elgg_get_site_entity()->getGUID();

$key = md5($interval . $site_guid);

if (!isset($digest_site_profile_body)){
	$digest_site_profile_body = array();
}

if (!isset($digest_site_profile_body[$key])){
	// Set default, then override it if there are results
	$digest_site_profile_body[$key] = false;
	
	$ts_lower = (int) elgg_extract("ts_lower", $vars);
	$ts_upper = (int) elgg_extract("ts_upper", $vars);
	
	$member_options = array(
			"type" => "user",
			"limit" => 6,
			"relationship" => "member_of_site",
			"relationship_guid" => elgg_get_site_entity()->getGUID(),
			"inverse_relationship" => true,
			"order_by" => "r.time_created DESC",
			"wheres" => array("(r.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper . ")")
	);
	
	if ($newest_members = elgg_get_entities_from_relationship($member_options)){
		$content = "<div class='digest-profile'>";
		
		foreach ($newest_members as $key => $user) {
			$content .= '<div class="table-item">';
			//$content .= elgg_view_entity_icon($user, 'medium', array('use_hover' => false)) . "<br />";
			$content .= '<div class="elgg-avatar elgg-avatar-medium"><a href="' .  $user->getURL() . '"><img src="' . $user->getIconUrl('medium') .  '" /></a></div><br />';
			$content .= '<a href="' .  $user->getURL() . '">' . $user->name . '</a><br />';
			$content .= $user->briefdescription;
			$content .= "</div>";
		}
		
		$content .= "</div>";
		
		// Set global var for later reuse
		$digest_site_profile_body[$key] = $content;
	}
}

// View module if not empty
if (!empty($digest_site_profile_body[$key])) {
	$title = elgg_view("output/url", array("text" => elgg_echo("esope:digest:members"), "href" => "members"));
	echo elgg_view_module("digest", $title , $digest_site_profile_body[$key]);
}

