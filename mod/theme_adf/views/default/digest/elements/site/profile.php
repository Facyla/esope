<?php
/**
* Shows the newest members in the Digest
*
*/
use Elgg\Database\Clauses\OrderByClause;

global $digest_site_profile_body;

$interval = elgg_extract('interval', $vars);
$site_guid = elgg_get_site_entity()->getGUID();

$key = md5($interval . $site_guid);

if (!isset($digest_site_profile_body)) {
	$digest_site_profile_body = [];
}

if (isset($digest_site_profile_body[$key])) {
	// return from memory
	if (!empty($digest_site_profile_body[$key])) {
		$title = elgg_view("output/url", array(
			"text" => elgg_echo("esope:digest:members"),
			"href" => "members"
		));
		
		echo elgg_view_module("digest", $title , $digest_site_profile_body[$key]);
	}
} else {
	$ts_lower = (int) elgg_extract("ts_lower", $vars);
	$ts_upper = (int) elgg_extract("ts_upper", $vars);

	$member_options = array(
			"type" => "user",
			"limit" => 6,
			"relationship" => "member_of_site",
			"relationship_guid" => elgg_get_site_entity()->getGUID(),
			"inverse_relationship" => true,
			"order_by" => "r.time_created DESC",
			"wheres" => array("(r.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper . ")"), // @todo rewrite for 3.3+
	);
	
	$newest_members = elgg_get_entities($member_options);
	if (!empty($newest_members)) {
		$title = elgg_view("output/url", array(
			"text" => elgg_echo("esope:digest:members"),
			"href" => "members",
			"is_trusted" => true
		));

		$content = "<div class='digest-profile'>";
		foreach ($newest_members as $index => $mem) {
			$content .= '<div class="table-item">';
			//$content .= elgg_view_entity_icon($mem, 'medium', array('use_hover' => false)) . "<br />";
			$content .= '<div class="elgg-avatar elgg-avatar-medium"><a href="' .  $mem->getURL() . '"><img src="' . $mem->getIconUrl('medium') .  '" /></a></div><br />';
			$content .= '<a href="' .  $mem->getURL() . '">' . $mem->name . '</a><br />';
			$content .= $mem->briefdescription;
			$content .= "</div>";
		}
		$content .= '<div class="clearfloat"></div>';
		$content .= "</div>";
	
		// Set global var for later reuse
		$digest_site_profile_body[$key] = $content;
		// View module if not empty
		echo elgg_view_module("digest", $title , $digest_site_profile_body[$key]);
	} else {
		$digest_site_profile_body[$key] = false;
	}
}

