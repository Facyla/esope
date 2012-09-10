<?php
/**
 * Save (edit or create) an announcement
 */

$guid = get_input('guid');
$container_guid = get_input('container_guid');
$title = get_input('title', '', FALSE);
$description = get_input('description', '');
$access_id = get_input('access_id', ACCESS_DEFAULT);

$announcement = new ElggAnnouncement($guid);

$editing = !$guid;
$creating = !$editing;

$container = get_entity($container_guid);
if (!$container instanceof ElggEntity) {
	register_error("Error posting announcement: Could not find the target specified");
	forward(REFERER);
}

if ($creating && !$container->canWriteToContainer(0, 'object', 'announcement')) {
	register_error(elgg_echo('object:announcement:save:permissiondenied'));
	forward(REFERER);
} elseif ($editing && !$announcement->canEdit()) {
	register_error(elgg_echo('object:announcement:save:permissiondenied'));
	forward(REFERER);
}

if (empty($description)) {
	register_error(elgg_echo('object:announcement:save:descriptionrequired'));
	forward(REFERER);
}

$announcement->container_guid = $container_guid;
$announcement->title = $title;
$announcement->description = $description;
$announcement->access_id = $access_id;

if ($announcement->save()) {
	add_to_river('object/announcement/create', 'create', elgg_get_logged_in_user_guid(), $announcement->guid);
	system_message(elgg_echo('object:announcement:save:success'));
	forward("/announcements/view/$announcement->guid");
} else {
	register_error("Error: we could not save the announcement.  You probably do not have the correct permissions");
	forward(REFERER);
}
