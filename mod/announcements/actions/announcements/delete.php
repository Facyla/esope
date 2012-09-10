<?php
/**
 * Delete announcement entity
 *
 * @package Announcements
 */

$announcement_guid = get_input('guid');
$announcement = get_entity($announcement_guid);

if (!elgg_instanceof($announcement, 'object', 'announcement')) {
	register_error(elgg_echo('announcements:delete:nopermission'));
	forward(REFERER);	
}

if (!$announcement->canEdit()) {
	register_error(elgg_echo('announcements:delete:nopermission'));
	forward(REFERER);
}


$container = get_entity($announcement->container_guid);
if (!$announcement->delete()) {
	register_error(elgg_echo('announcements:delete:failure'));
	forward(REFERER);
}

system_message(elgg_echo('announcements:delete:sucess'));
if (elgg_instanceof($container, 'group')) {
	forward("announcements/group/$container->guid/all");
} else {
	forward("announcements/owner/$container->username");
}

forward(REFERER);