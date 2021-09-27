<?php
/**
* Shows the latests thewires in the Digest
*
*/

$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
$limit = (int) elgg_extract("limit", $vars, 5);
$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

// Exclude params: self|[groups|site]
// Note : if both 'groups' and 'site' are set, only groups exclude will be applied - otherwise this would exclude all content
$exclude = elgg_extract("exclude", $vars, array('self'));

$dbprefix = elgg_get_config("dbprefix");

$thewire_options = array(
	"type" => "object",
	"subtype" => "thewire",
	"limit" => $limit,
	"created_time_lower" => $ts_lower,
	"created_time_upper" => $ts_upper,
);

// exclude own content
if ($user && in_array('self', $exclude)) {
	$thewire_options['wheres'][] = "e.owner_guid != " . $user->guid;
}
// exclude messages published in groups
if (in_array('groups', $exclude)) {
	$thewire_options['wheres'][] = "e.owner_guid = e.container_guid";
} else if (in_array('site', $exclude)) {
	$thewire_options['wheres'][] = "e.owner_guid != e.container_guid";
}

if ($thewires = elgg_get_entities($thewire_options)){
	$title = elgg_view("output/url", array(
		"text" => elgg_echo("theme_adf:digest:thewire"),
		"href" => "thewire/all",
		"is_trusted" => true
	));
	
	$latest_thewires = "";
	
	foreach($thewires as $thewire){
		$thewire_url = $thewire->getURL();
		
		$latest_thewires .= "<div class='digest-blog'>";
		$owner = $thewire->getOwnerEntity();
		if ($owner) {
			$latest_thewires .= "<a href='" . $thewire_url. "'><img src='". $owner->getIconURL("small") . "' style='border-radius: 5px; padding: 0; margin: 0 5px 0 0;' /></a>";
		}
		$latest_thewires .= "<span>";
		$latest_thewires .= "<a href='" . $thewire_url. "'>&laquo;&nbsp;" . $thewire->description . "&nbsp;&raquo;</a>";
		$latest_thewires .= "</span>";
		$latest_thewires .= "</div>";
	}
	
	echo elgg_view_module("digest", $title, $latest_thewires);
}

