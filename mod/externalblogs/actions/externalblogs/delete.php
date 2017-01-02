<?php
/**
 * Elgg delete externalblog action
 *
 */

$guid = (int) get_input('guid');
$externalblog = get_entity($guid);
if (elgg_instanceof($externalblog, 'object', 'externablog') && $externalblog->canEdit()) {
	$externalblog->delete();
	system_message(elgg_echo("externalblog:deleted"));
	forward(elgg_get_site_url() . 'externalblog');
}

register_error(elgg_echo("externalblog:notdeleted"));
forward(REFERER);

