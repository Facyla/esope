<?php
/**
 * Elgg delete externalblog action
 *
 */
global $CONFIG;

$guid = (int) get_input('guid');
$externalblog = get_entity($guid);
if ($externalblog && $externalblog->canEdit()) {
	$externalblog->delete();
	system_message(elgg_echo("externalblog:deleted"));
  forward($CONFIG->url . 'externalblog');
}

register_error(elgg_echo("externalblog:notdeleted"));
forward(REFERER);

