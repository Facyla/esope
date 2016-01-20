<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// If there are any posts to view, view them
if (is_array($vars['posts']) && sizeof($vars['posts']) > 0) {
			
	foreach($vars['posts'] as $post) {
				
		echo elgg_view_entity($post);
				
	}
			
}


