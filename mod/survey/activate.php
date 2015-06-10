<?php
/**
 * Register the Poll class for the object/survey subtype
 */

if (get_subtype_id('object', 'survey')) {
	update_subtype('object', 'survey', 'Survey');
} else {
	add_subtype('object', 'survey', 'Survey');
}
