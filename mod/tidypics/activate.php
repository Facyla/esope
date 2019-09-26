<?php
/**
 * Activate Tidypics
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

// register classes
if (get_subtype_id('object', TidypicsAlbum::SUBTYPE)) {
	update_subtype('object', TidypicsAlbum::SUBTYPE, 'TidypicsAlbum');
} else {
	add_subtype('object', TidypicsAlbum::SUBTYPE, 'TidypicsAlbum');
}
if (get_subtype_id('object', TidypicsImage::SUBTYPE)) {
	update_subtype('object', TidypicsImage::SUBTYPE, 'TidypicsImage');
} else {
	add_subtype('object', TidypicsImage::SUBTYPE, 'TidypicsImage');
}
if (get_subtype_id('object', TidypicsBatch::SUBTYPE)) {
	update_subtype('object', TidypicsBatch::SUBTYPE, 'TidypicsBatch');
} else {
	add_subtype('object', TidypicsBatch::SUBTYPE, 'TidypicsBatch');
}

// set default settings
$plugin = elgg_get_plugin_from_id('tidypics');

$defaults = [
	'tagging' => false,
	'restrict_tagging' => false,
	'view_count' => true,
	'uploader' => true,
	'exif' => false,
	'download_link' => true,
	'slideshow' => false,

	'maxfilesize' => 5,
	'image_lib' => 'GD',

	'img_river_view' => 'batch',
	'album_river_view' => 'cover',
	'river_album_number' => 7,
	'river_comments_thumbnails' => 'none',
	'river_thumbnails_size' => 'tiny',
	'river_tags' => 'show',

	'notify_interval' => 60 * 60 * 24,

	'client_resizing' => false,
	'remove_exif' => false,
	'client_image_width' => 2000,
	'client_image_height' => 2000,
];

foreach ($defaults as $name => $value) {
	if ($plugin->getSetting($name) === null) {
		$plugin->setSetting($name, $value);
	}
}

// check for existence of thumbnail size configuration and set what is necessary separately
$image_sizes = elgg_get_plugin_setting('image_sizes', 'tidypics');
if ($image_sizes) {
	$image_sizes = unserialize($image_sizes);
	$image_sizes['tiny_image_width'] = isset($image_sizes['tiny_image_width']) ? $image_sizes['tiny_image_width']: 60;
	$image_sizes['tiny_image_height'] = isset($image_sizes['tiny_image_height']) ? $image_sizes['tiny_image_height']: 60;
	$image_sizes['tiny_image_square'] = isset($image_sizes['tiny_image_square']) ? $image_sizes['tiny_image_square']: true;
	$image_sizes['small_image_width'] = isset($image_sizes['small_image_width']) ? $image_sizes['small_image_width']: 153;
	$image_sizes['small_image_height'] = isset($image_sizes['small_image_height']) ? $image_sizes['small_image_height']: 153;
	$image_sizes['small_image_square'] = isset($image_sizes['small_image_square']) ? $image_sizes['small_image_square']: true;
	$image_sizes['large_image_width'] = isset($image_sizes['large_image_width']) ? $image_sizes['large_image_width']: 600;
	$image_sizes['large_image_height'] = isset($image_sizes['large_image_height']) ? $image_sizes['large_image_height']: 600;
	$image_sizes['large_image_square'] = isset($image_sizes['large_image_square']) ? $image_sizes['large_image_square']: false;
} else {
	$image_sizes = [];
	$image_sizes['tiny_image_width'] = 60;
	$image_sizes['tiny_image_height'] = 60;
	$image_sizes['tiny_image_square'] = true;
	$image_sizes['small_image_width'] = 153;
	$image_sizes['small_image_height'] = 153;
	$image_sizes['small_image_square'] = true;
	$image_sizes['large_image_width'] = 600;
	$image_sizes['large_image_height'] = 600;
	$image_sizes['large_image_square'] = false;
}
$image_sizes = serialize($image_sizes);
elgg_set_plugin_setting('image_sizes', $image_sizes, 'tidypics');
