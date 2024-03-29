<?php
/**
 * Page edit form body
 */

$fields = elgg_get_config('pages');
if (empty($fields)) {
	return;
}

$entity = elgg_extract('entity', $vars);
$parent_guid = elgg_extract('parent_guid', $vars);

$can_change_access = true;
if ($entity instanceof ElggPage && $entity->getOwnerEntity()) {
	$can_change_access = $entity->getOwnerEntity()->canEdit();
}

foreach ($fields as $name => $type) {
	$field = [
		'name' => $name,
		'value' => $vars[$name],
		'#type' => $type,
		'#label' => elgg_echo("pages:$name"),
	];

	switch ($name) {
		case 'title' :
			$field['required'] = true;
			break;

		case 'access_id' :
		case 'write_access_id' :
			if (!$can_change_access) {
				// Only owner and admins can change access
				continue(2);
			}

			$field['entity'] = $entity;
			$field['entity_type'] = 'object';
			$field['entity_subtype'] = 'page';

			if ($name === 'write_access_id') {
				$field['purpose'] = 'write';
				// no access change warning for write access input
				$field['entity_allows_comments'] = false;
			}
			break;

		case 'parent_guid' :
			// ADF : do not skip for owner or admin
			//if ($parent_guid) {
			if ($parent_guid || $can_change_access) {
				$field['entity'] = $entity;
			} else {
				// skip field if there is no parent_guid
				continue(2);
			}
			break;
	}

	echo elgg_view_field($field);
}

if ($entity instanceof ElggPage) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'page_guid',
		'value' => $entity->guid,
	]);
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'container_guid',
	'value' => elgg_extract('container_guid', $vars),
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);
elgg_set_form_footer($footer);
