<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggObject) {
	return;
}

if (!$entity->hasCapability('searchable')) {
	return;
}

if ($entity->getContainerEntity() instanceof \ElggObject) {
	return;
}

$attachments = elgg_list_entities([
	'type' => 'object',
	'subtype' => \EntityAttachment::SUBTYPE,
	'container_guid' => $entity->guid,
	'limit' => false,
	'list_class' => 'entity-attachments',
	'sort_by' => [
		'property' => 'order',
		'direction' => 'asc',
		'signed' => true,
	],
]);

$module_vars = [];
if (empty($attachments)) {
	$module_vars['class'] = 'hidden';
}

$title = elgg_echo('entity_attachments:list:title');
if ($entity->canEdit()) {
	if (empty($attachments)) {
		$attachments = '&nbsp'; // required to force existence of body
	}
	
	elgg_import_esm('entity_attachments/list');

	elgg_register_event_handler('register', 'menu:entity', function(\Elgg\Event $event) use ($entity) {
		$event_entity = $event->getEntityParam();
		if (!$event_entity instanceof \ElggEntity) {
			return null;
		}

		if ($event_entity->guid !== $entity->guid) {
			return null;
		}

		$result = $event->getValue();
		$result[] = \ElggMenuItem::factory([
			'name' => 'entity_attachments:add',
			'text' => elgg_echo('item:object:entity_attachment:add'),
			'icon' => 'paperclip',
			'href' => elgg_http_add_url_query_elements('ajax/form/entity_attachments/add', [
				'guid' => $entity->guid,
			]),
			'class' => [
				'elgg-lightbox',
			],
			'data-colorbox-opts' => json_encode([
				'width' => 500,
			]),
		]);

		return $result;
	});
}

if (empty($attachments)) {
	return;
}

echo elgg_view_module('entity_attachments', $title, $attachments, $module_vars);
