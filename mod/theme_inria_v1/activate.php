<?php
/**
 * Perform some (cleaning) actions when desactivating the plugin
 */


// De-register custom classes

if (!elgg_is_active_plugin('tidypics')) {
	update_subtype('object', 'image');
	update_subtype('object', 'album');
	//object	image	TidypicsImage
	//object	album	TidypicsAlbum
}

// Remove old plugin classes
//meeting	ElggMeeting
//filter	ElggFilter
//webinar	ElggWebinar
update_subtype('object', 'meeting');
update_subtype('object', 'filter');
update_subtype('object', 'webinar');



// Auto-enable plugin dependencies
$plugins = ['theme_inria'];
foreach ($plugins as $plugin) {
	//enable_plugin($plugin);
	echo esope_enable_plugin($plugin, true, false);
}

elgg_regenerate_simplecache();
elgg_reset_system_cache();


