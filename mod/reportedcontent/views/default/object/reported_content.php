<?php
/**
 * Elgg reported content object view
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggReportedContent) {
	return;
}

$params = $vars;
$params['content'] = $entity->description;
$params['access'] = false;

$params['title'] = elgg_view('output/url', [
	'text' => $entity->getDisplayName(),
	'href' => $entity->address,
	'is_trusted' => true,
	'class' => [
		'elgg-lightbox',
	],
	'data-colorbox-opts' => json_encode([
		'width' => '85%',
		'height' => '85%',
		'iframe' => true,
	]),
]);

echo elgg_view('object/elements/summary', $params);
