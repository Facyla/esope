<?php
/**
 * New videos river entry
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

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

$video_url = $object->video_url;
$guid = $object->getGUID();
/*
$params = array(
	'href' => $object->getURL(),
	'text' => $object->title,
);
$link = elgg_view('output/url', $params);

$group_string = '';
$container = $object->getContainerEntity();
if ($container instanceof ElggGroup) {
	$params = array(
		'href' => $container->getURL(),
		'text' => $container->name,
	);
	$group_link = elgg_view('output/url', $params);
	$group_string = elgg_echo('river:ingroup', array($group_link));
}

$link = elgg_echo('videos:river:created', array($link));

echo " $link $group_string";


if ($excerpt) {
	echo '<div class="elgg-river-content">';
	echo "<div style='width: 160px;float:left; '>";
	echo videoembed_create_embed_object($video_url, $guid,150); 
	echo "</div>";
	echo "<div style='margin:-100px 0 0 200px;float:left;width:500px;'>";
	echo $excerpt;
	echo '</div>';
	echo '</div>';
}
*/

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'attachments' => videoembed_create_embed_object($video_url, $guid,150),
));
