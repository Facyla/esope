<?php
/**
 * Embeddable content list item view
 *
 * @uses $vars['entity'] ElggEntity object
 */

$entity = $vars['entity'];

$title = $entity->title;
if (!$title) {
	$title = $entity->name;
}

// different entity types have different title attribute names.
$title = isset($entity->name) ? $entity->name : $entity->title;
// don't let it be too long
$title = elgg_get_excerpt($title);

$owner = $entity->getOwnerEntity();
if ($owner) {
	$author_text = elgg_echo('byline', array($owner->name));
	$date = elgg_view_friendly_time($entity->time_created);
	$subtitle = "$author_text $date";
} else {
	$subtitle = '';
}

$params = array(
	'title' => $title,
	'entity' => $entity,
	'subtitle' => $subtitle,
	'tags' => FALSE,
);
$body = elgg_view('object/elements/summary', $params);

// This lets editors add images in a reasonnable size, and uncroped
if (elgg_instanceof($entity, 'object', 'file') && (file_get_general_file_type($entity->mimetype))) {
	$image = elgg_view_entity_icon($entity, 'small', array('link_class' => ''));
	$image .= '<span class="hidden">' . elgg_view_entity_icon($entity, 'large', array('link_class' => 'embed-insert')) . '</span>';
} else {
	$image = elgg_view_entity_icon($entity, 'small', array('link_class' => 'embed-insert'));
}

echo elgg_view_image_block($image, $body);
