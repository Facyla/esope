<?php
/**
* Shows the latests market offers in the Digest
*
*/

$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

// only show markets that are published
$dbprefix = elgg_get_config("dbprefix");

//$market_status_name_id = elgg_get_metastring_id("status");
//$market_published_value_id = elgg_get_metastring_id("published");

$market_options = array(
	"type" => "object",
	"subtype" => "market",
	"limit" => 3,
	/*
	"created_time_lower" => $ts_lower,
	"created_time_upper" => $ts_upper,
	*/
	/*
	"joins" => array(
		"JOIN " . $dbprefix . "metadata bm ON e.guid = bm.entity_guid"
	),
	"wheres" => array(
		"bm.name_id = " . $market_status_name_id,
		"bm.value_id = " . $market_published_value_id
	)
	*/
);

$markets = elgg_get_entities($market_options);
if (!empty($markets)) {
	$title = elgg_view("output/url", array(
		"text" => elgg_echo("market:markets"),
		"href" => "market/all",
		"is_trusted" => true
	));
	
	$latest_markets = "";
	
	foreach ($markets as $market) {
		$market_url = $market->getURL();
		
		$latest_markets .= "<div class='digest-market'>";
		if ($market->icontime) {
			$icon = elgg_view("output/img", array(
				"src" => $market->getIconURL("medium")
			));
			$latest_markets .= elgg_view("output/url", array(
				"text" => $icon,
				"href" => $market_url,
				"is_trusted" => true
			));
		}
		$latest_markets .= "<span>";
		$latest_markets .= "<h4>";
		$latest_markets .= elgg_view("output/url", array(
			"text" => $market->title,
			"href" => $market_url,
			"is_trusted" => true
		));
		$latest_markets .= "</h4>";
		$latest_markets .= elgg_get_excerpt($market->description);
		$latest_markets .= "</span>";
		$latest_markets .= "</div>";
	}
	
	echo elgg_view_module("digest", $title, $latest_markets);
}
