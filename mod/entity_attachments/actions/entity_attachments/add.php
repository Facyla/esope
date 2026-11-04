<?php

$guid = (int) get_input('guid');
$entity = get_entity($guid);

$type = get_input('type');
$params = elgg_extract($type, get_input('params'));

if (!$entity instanceof \ElggObject || empty($params)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$required_fields = elgg_extract($type, [
	'custom_link' => ['href', 'title'],
	'download_link' => ['href', 'title'],
	'linked_entity' => ['entity_guid'],
	'linked_group' => ['entity_guid'],
	'linked_user' => ['entity_guid'],
], []);

foreach ($required_fields as $field) {
	if (!empty(elgg_extract($field, $params))) {
		continue;
	}
	
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$attachment = new \EntityAttachment();
$attachment->owner_guid = $guid;
$attachment->container_guid = $guid;
$attachment->order = time();

$attachment->attachment_type = $type;

foreach ($params as $key => $value) {
	if (in_array($key, \EntityAttachment::PRIMARY_ATTR_NAMES)) {
		// prevent abuse
		continue;
	}
	
	$attachment->$key = $value;
}

$attachment->save();

$attachments = elgg_list_entities([
	'type' => 'object',
	'subtype' => \EntityAttachment::SUBTYPE,
	'container_guid' => $guid,
	'limit' => false,
	'list_class' => 'entity-attachments',
	'sort_by' => [
		'property' => 'order',
		'direction' => 'asc',
		'signed' => true,
	],
]);

return elgg_ok_response($attachments, elgg_echo('save:success'));
