<?php
/**
 * videos helper functions
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

/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $video A video object.
 * @return array
 */
 
function videos_prepare_form_vars($video = null) {
	// input names => defaults
	$values = array(
		'title' => get_input('title', ''), // videolet support
		'video_url' => get_input('video_url', ''),
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $video,
	);

	if ($video) {
		foreach (array_keys($values) as $field) {
			if (isset($video->$field)) {
				$values[$field] = $video->$field;
			}
		}
	}

	if (elgg_is_sticky_form('videos')) {
		$sticky_values = elgg_get_sticky_values('videos');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('videos');

	return $values;
}