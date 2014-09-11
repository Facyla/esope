<?php
// Derniers articles mis en Une
// Note : on n'utilise pas la date de création car ils ont probablement été épinglés a posteriori

/*
$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);
$params = array('metadata_name' => 'highlight', 'types' => 'object', 'limit' => 0, "created_time_lower" => $ts_lower, "created_time_upper" => $ts_upper);
*/

$params = array('metadata_name' => 'highlight', 'types' => 'object', 'limit' => 3);
$pins = elgg_get_entities_from_metadata($params);

if (!empty($pins)) {
	$title = elgg_view("output/url", array("text" => elgg_echo("theme_fing:digest:pin"), "href" => "pin"));
	
	$latest_pins = "";
	
	foreach ($pins as $ent) {
		$ent_url = $ent->getURL();
		
		$latest_pins .= "<div class='digest-blog'>";
		
		$image_url = '';
		if ($ent->icontime) { $image_url = $ent->getIconURL("small"); }
		if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
			$container = $ent->getOwnerEntity();
			$image_url = $container->getIconURL('small');
		}
		
		$latest_pins .= "<a href='" . $ent_url . "'><img src='" . $image_url . "' /></a>";
		$latest_pins .= "<span>";
		$latest_pins .= "<h4><a href='" . $ent_url . "'>" . $ent->title . "</a></h4>";
		$latest_pins .= elgg_get_excerpt($ent->description);
		$latest_pins .= "</span>";
		$latest_pins .= "</div>";
	}
	
	echo elgg_view_module("digest", $title, $latest_pins);
}

