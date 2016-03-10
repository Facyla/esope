<?php
/**
* Shows the latests market offers in the Digest
*
*/

//$ts_lower = (int) elgg_extract("ts_lower", $vars);
//$ts_upper = (int) elgg_extract("ts_upper", $vars);

// only show markets that are published
$dbprefix = elgg_get_config("dbprefix");

//$offer_status_name_id = elgg_get_metastring_id("status");
//$offer_published_value_id = elgg_get_metastring_id("published");

$offer_options = array(
	"type" => "object",
	"subtype" => "market",
	"limit" => 2,
	/*
	"created_time_lower" => $ts_lower,
	"created_time_upper" => $ts_upper,
	*/
	/*
	"joins" => array(
		"JOIN " . $dbprefix . "metadata bm ON e.guid = bm.entity_guid"
	),
	"wheres" => array(
		"bm.name_id = " . $offer_status_name_id,
		"bm.value_id = " . $offer_published_value_id
	)
	*/
);

$offers = elgg_get_entities($offer_options);
if (!empty($offers)) {
	$title = elgg_view("output/url", array(
		"text" => elgg_echo("market:title"),
		"href" => "market/all",
		"is_trusted" => true
	));
	
	$content = '';
	
	foreach ($offers as $offer) {
		$offer_content = "";
		$offer_url = $offer->getURL();
		$owner = $offer->getOwnerEntity();
		$container = $offer->getContainerEntity();
		$category = "<b>" . elgg_echo('market:category') . "&nbsp;:</b> " . elgg_echo("market:category:{$offer->marketcategory}") . '<br />';
		$type = "<b>" . elgg_echo('market:type') . "&nbsp;:</b> " . elgg_echo("market:type:{$offer->market_type}") . '<br />';
		$excerpt = elgg_get_excerpt($offer->description);
		
		
		$offer_content .= "<div class='digest-market'>";
		/*
		if ($offer->icontime) {
			$icon = elgg_view("output/img", array(
					"src" => $offer->getIconURL("medium")
				));
		}
		*/
		$icon = elgg_view('output/img', array(
				'src' => "market/image/{$offer->guid}/1/medium/{$offer->time_updated}",
				'class' => 'market-image-list',
				'alt' => $offer->guid,
			));
		$offer_img = elgg_view('output/url', array(
			'text' => $icon,
			'href' => market_url,
			'is_trusted' => true,
			));
		
		$offer_content .= "<span>";
		$offer_content .= "<h4>";
		$offer_content .= elgg_view("output/url", array(
			"text" => $offer->title,
			"href" => $offer_url,
			"is_trusted" => true
		));
		$offer_content .= "</h4>";
		$offer_content .= $category;
		$offer_content .= $type;
		$offer_content .= $excerpt;
		$offer_content .= "</span>";
		$offer_content .= "</div>";
		
		/*
		$params = array(
			'entity' => $post,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags,
			'content' => $excerpt,
		);
		$params = $params + $vars;
		$offer_content = elgg_view('object/elements/summary', $params);
		*/
		
		$content .= elgg_view_image_block($offer_img, $offer_content, array('class' => 'market-list-block'));
	}
	
	echo elgg_view_module("digest", $title, $content);
}
