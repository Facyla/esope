<?php
/**
 * videos English language file
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

$english = array(

	/**
	 * Menu items and titles
	 */
	'videos' => "Videos",
	'videos:add' => "Add video",
	'videos:embed' => "Embed video",
	'videos:embedurl' => "Enter video URL",
	'videos:edit' => "Edit video",
	'videos:owner' => "%s's videos",
	'videos:friends' => "Friends' videos",
	'videos:everyone' => "All site videos",
	'videos:this:group' => "Videos in %s",
	'videos:morevideos' => "More videos",
	'videos:more' => "More",
	'videos:with' => "Share with",
	'videos:new' => "A new video",
	'videos:via' => "via videos",
	'videos:none' => 'No videos',

	'videos:delete:confirm' => "Are you sure you want to delete this video?",

	'videos:numbertodisplay' => 'Number of videos to display',

	'videos:shared' => "videos shared",
	'videos:recent' => "Recent videos",

	'videos:river:created' => 'added video %s',
	'videos:river:annotate' => 'a comment on this video',
	'videos:river:item' => 'an item',
	'river:commented:object:videos' => 'a video',

	'river:create:object:videos' => '%s added a video %s',
	'river:comment:object:videos' => '%s commented on a video %s',
	'videos:river:annotate' => 'a comment on this video',
	'videos:river:item' => 'an item',
	
	
	
	'item:object:videos' => 'Videos',

	'videos:group' => 'Group videos',
	'videos:enablevideos' => 'Enable group videos',
	'videos:nogroup' => 'This group does not have any videos yet',
	'videos:more' => 'More videos',

	'videos:no_title' => 'No title',
	'videos:file' => 'Select the video file to upload',

	/**
	 * Widget
	 */
	'videos:widget:description' => "Display your latest videos.",

	/**
	 * Status messages
	 */

	'videos:save:success' => "Your video was successfully saved.",
	'videos:delete:success' => "Your video item was successfully deleted.",

	/**
	 * Error messages
	 */

	'videos:save:failed' => "Your video could not be saved. Make sure you've entered a title and description and then try again.",
	'videos:delete:failed' => "Your video could not be deleted. Please try again.",
	'videos:noembedurl' => 'Video URL empty',
	 /**
	  * Temporary loading of Cash's Video languages
	  */
	  'embedvideo:novideo' => 'No video',
	  'embedvideo:unrecognized' => 'Unrecognised video',
	  'embedvideo:parseerror' => 'Error processing the video',
);

add_translation('en', $english);