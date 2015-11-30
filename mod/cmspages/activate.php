<?php
/**
 * Register the ElggCMSPage class for the object/cmspage subtype
 */

if (get_subtype_id('object', 'cmspage')) {
	update_subtype('object', 'cmspage', 'ElggCMSPage');
} else {
	add_subtype('object', 'cmspage', 'ElggCMSPage');
}
