<?php
/**
 * Register the ElggTransitions class for the object/transitions subtype
 */

if (get_subtype_id('object', 'transitions')) {
	update_subtype('object', 'transitions', 'ElggTransitions');
} else {
	add_subtype('object', 'transitions', 'ElggTransitions');
}
