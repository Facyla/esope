<?php
/**
 * Elgg video view
 *	Author : Sarath C | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : webgalli@gmail.com
 *	Web	: http://webgalli.com | http://plugingalaxy.com
 *	Skype : 'team.webgalli' or 'drsanupmoideen'
 *	@package Elgg-videos
 * 	Plugin info : Upload/ Embed videos. Save uploaded videos in youtube and save your bandwidth and server space
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */
elgg_load_library('elgg:videos:embed');

$full = elgg_extract('full_view', $vars, FALSE);
$video = elgg_extract('entity', $vars, FALSE);

if (!$video) {
	return;
}

$owner = $video->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $video->getContainerEntity();
$categories = elgg_view('output/categories', $vars);

$description = elgg_view('output/longtext', array('value' => $video->description, 'class' => 'pbl'));
$video_url = $video->video_url;
$video_id = $video->youtube_id;


$owner_link = elgg_view('output/url', array(
	'href' => "videos/owner/$owner->username",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

$tags = elgg_view('output/tags', array('tags' => $video->tags));
$date = elgg_view_friendly_time($video->time_created);

$comments_count = $video->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $video->getURL() . '#comments',
		'text' => $text,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'videos',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $categories $comments_link";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {
	$header = elgg_view_title($video->title);

	$params = array(
		'entity' => $video,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	$video_info = elgg_view_image_block($owner_icon, $list_body);

	echo <<<HTML
$header
$video_info
HTML;
?>

<div class="video elgg-content mts">
	<?php echo $description; ?>
	<div style="margin-left:100px;">
	<?php 
	echo videoembed_create_embed_object($video_url, $video->getGUID(),500); 
	?>
	</div>
</div>
<?php
} elseif (elgg_in_context('gallery')) {
	echo <<<HTML
<div class="videos-gallery-item">
	<h3>$video->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;
} else {
	// brief view
	$excerpt = elgg_get_excerpt($video->description);
	if ($excerpt) {
		$excerpt = "$excerpt";
	}
	$video_icon = videoembed_create_embed_object($video_url, $video->getGUID(),150); 

	$content = "$excerpt";

	$params = array(
		'entity' => $video,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $content,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($owner_icon, $body);

}