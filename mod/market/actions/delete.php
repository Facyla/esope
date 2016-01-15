<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// Get input data
$guid = (int) get_input('guid');
		
// Make sure we actually have permission to edit
$post = get_entity($guid);
if ($post->getSubtype() == "market" && $post->canEdit()) {
	
	elgg_load_library('market');

	// Delete the market post
	$return = market_delete_post($post);
	if ($return) {
		// Success message
		system_message(elgg_echo("market:deleted"));
	} else {
		// Error message
		register_error(elgg_echo("market:notdeleted"));
	}
				
	// Forward to the main market page
	forward(elgg_get_site_url() . "market");
}
		
