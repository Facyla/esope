<?php
/**
 * Elgg Market Plugin
 * @package market
 */

$full = elgg_extract('full_view', $vars, FALSE);
$post = $vars['entity'];

if (!$post) {
	return TRUE;
}

$currency = elgg_get_plugin_setting('market_currency', 'market');

$owner = $post->getOwnerEntity();
$tu = $post->time_updated;
$container = $post->getContainerEntity();
$category = "<b>" . elgg_echo('market:category') . ":</b> " . elgg_echo("market:category:{$post->marketcategory}");
$type = "<b>" . elgg_echo('market:type') . ":</b> " . elgg_echo("market:type:{$post->market_type}");
$excerpt = elgg_get_excerpt($post->description);

$owner_link = elgg_view('output/url', array(
	'href' => "market/owned/{$owner->username}",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

$image = elgg_view('market/thumbnail', array(
			'guid' => $post->guid,
			'imagenum' => 1,
			'size' => 'medium',
			'class' => '',
			'tu' => $tu
			));
$market_img = elgg_view('output/url', array(
	'href' => "market/view/$owner->username",
	'text' => $image,
));

$tags = elgg_view('output/tags', array('tags' => $post->tags));
$date = elgg_view_friendly_time($post->time_created);

$custom = '';
if(isset($marketpost->custom) && elgg_get_plugin_setting('market_custom', 'market') == 'yes'){
	$custom = "<br><b>" . elgg_echo('market:custom:text') . ": </b>" . elgg_echo($post->custom);
}

$location = '';
if (elgg_get_plugin_setting('location', 'market') == 'yes') {
	$location = elgg_view('output/location', array(
						'entity' => $post,
						'value' => $post->location,
						));
	$location = "<br><b>" . elgg_echo('market:location') . ": </b>$location";
}

$comments_count = $post->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $post->getURL() . '#market-comments',
		'text' => $text,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $post,
	'handler' => 'market',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

if ($full) {
	$post_body = '';

	$post_body .= "<div class='mbm mts'><span class='market_pricetag'><b>" . elgg_echo('market:price') . "</b> {$currency} {$post->price}</span></div>";

	$thumbnail = elgg_view('output/img', array(
					'src' => "market/image/{$post->guid}/1/large/{$tu}.jpg",
					'class' => 'elgg-photo',
					'alt' => $post->guid,
					));
	$img = elgg_view('output/url', array(
					'href' => "market/image/{$post->guid}/1/master/{$tu}.jpg",
					'text' => $thumbnail,
					'class' => "elgg-lightbox-photo market-thumbnail",
					'rel' => 'market-gallery',
					));

	$obs_img = elgg_view('output/img', array(
				'src' => "market/image/{$post->guid}/1/large/{$tu}",
				'class' => 'elgg-photo',
				'alt' => $post->guid,
				));

	$images = unserialize($post->images);
	if (is_array($images)) {
		$post_images = '';
		foreach ($images as $key => $value) {
			if ($value) {
				$post_img = elgg_view('output/img', array(
								'src' => "market/image/{$post->guid}/$key/small/{$tu}.jpg",
								'class' => 'elgg-photo',
								'alt' => $post->guid,
								));
				$post_images .= elgg_view('output/url', array(
								'href' => "market/image/{$post->guid}/$key/master/{$tu}.jpg",
								'text' => $post_img,
								'class' => "elgg-lightbox-photo market-thumbnail",
								'rel' => 'market-gallery',
								'data-colorboxOpts' => "{slideshow: true, rel: 'group'}",
								));
			}
		}
	}
	if ($post_images) {
		$post_body .= "<div>$post_images</div>";
	}
	if (elgg_get_plugin_setting('market_allowhtml', 'market') != 'yes') {
		$post_body .= elgg_autop(parse_urls(strip_tags($post->description)));
	} else {
		$post_body .= elgg_view('output/longtext', array('value' => $post->description));
	}

	if (elgg_get_plugin_setting('market_pmbutton', 'market') == 'yes') {
		if ($owner->guid != elgg_get_logged_in_user_guid()) {
			$post_body .= elgg_view('output/url', array(
							'class' => 'elgg-button elgg-button-action mtm',
							'href' => "messages/compose?send_to={$owner->guid}",
							'text' => elgg_echo('market:pmbuttontext'),
							));
		}
	}

	$marketpost = elgg_view_image_block($img, $post_body, array('class' => 'market-image-block'));

	$subtitle = "{$author_text} {$date} {$comments_link}";
	$subtitle .= "<br>{$category}<br>{$type}{$custom}{$location}";

	$params = array(
		'entity' => $post,
		'header' => $header,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	$owner_icon = elgg_view_entity_icon($owner, 'small');
	$marketpost_info = elgg_view_image_block($owner_icon, $list_body);

	echo $marketpost_info;
	echo $marketpost;
	echo "<script>$( document ).ready(function() { $('a.market-thumbnail').colorbox(); })</script>";

} else {
	// brief view
	$img = elgg_view('output/img', array(
				'src' => "market/image/{$post->guid}/1/medium/{$tu}",
				'class' => 'market-image-list',
				'alt' => $post->guid,
				));
	$market_img = elgg_view('output/url', array(
			'href' => "market/view/{$post->guid}/" . elgg_get_friendly_title($post->title),
			'text' => $img,
			));

	$subtitle = "{$author_text} {$date} {$comments_link}";
	$subtitle .= "<br>{$category}<br>{$type}<br>";
	$subtitle .= "<b>" . elgg_echo('market:price') . ":</b> {$currency} {$post->price}{$custom}{$location}";

	if (elgg_in_context('widgets')) {
		$metadata = '';
		$tags = false;
	}

	$params = array(
		'entity' => $post,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($market_img, $list_body, array('class' => 'market-list-block'));
}

