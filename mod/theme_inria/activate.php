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



