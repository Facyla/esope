<?php
/**
 * File river view.
 */

// Emojis note : update filter to handle properly emojis

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();
$excerpt = strip_tags($object->description);
//$excerpt = thewire_filter($excerpt);
$excerpt = emojis_thewire_filter($excerpt); // emojis

$subject = $item->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$object_link = elgg_view('output/url', array(
	'href' => "thewire/owner/$subject->username",
	'text' => elgg_echo('thewire:wire'),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$summary = elgg_echo("river:create:object:thewire", array($subject_link, $object_link));

echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'message' => $excerpt,
	'summary' => $summary,

	// truthy value to bypass responses rendering
	'responses' => ' ',
));
