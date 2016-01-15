<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// Get input data
$guid = (int) get_input('guid');
$imagenum = (int) get_input('img');

// Make sure we actually have permission to edit
$post = get_entity($guid);
if ($post->getSubtype() == "market" && $post->canEdit()) {
	
	elgg_load_library('market');

	// Delete the market post
	$return = market_delete_image($post, $imagenum);
	if ($return) {
		// Success message
		system_message(elgg_echo("market:image:deleted"));
	} else {
		// Error message
		register_error(elgg_echo("market:image:notdeleted"));
	}
} else {
	register_error(elgg_echo("market:image:notdeleted"));
}

forward(REFERER);	
