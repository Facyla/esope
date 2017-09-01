<?php
/**
 * File river view.
 */

$object = $vars['item']->getObjectEntity();
$parent = thewire_get_parent($object->guid);

$excerpt = strip_tags($object->description);
$excerpt = thewire_filter($excerpt);
if ($parent) {
	//$excerpt = elgg_view('output/url', array('href' => "thewire/thread/$object->wire_thread", 'text' => $excerpt));
	//$excerpt = elgg_view('output/url', array('href' => $object->getURL(), 'text' => $excerpt));
	$excerpt .= elgg_view('output/url', array('href' => "thewire/thread/$object->wire_thread", 'text' => elgg_echo('thewire:thread:view'), 'class' => 'elgg-river-target'));
} else {
	//$excerpt = elgg_view('output/url', array('href' => $object->getURL(), 'text' => $excerpt));
}
//$excerpt = '<div class="elgg-river-message">&laquo;&nbsp;' . $excerpt . '&nbsp;&raquo;</div>';
$excerpt = '<div class="elgg-river-message">' . $excerpt . '</div>';


$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

if ($parent) {
	$parent_text = strip_tags($parent->description);
	$parent_text = elgg_get_excerpt($parent_text, 30);
	$parent_text = thewire_filter($parent_text);
	$parent_link = ' &laquo;&nbsp;' . $parent_text . '&nbsp;&raquo;';
	/*
	$parent_link = elgg_view('output/url', array(
		'href' => $parent->getURL(),
		'text' => $parent_text,
		'class' => 'elgg-river-object',
		'is_trusted' => true,
	));
	*/
	$summary = elgg_echo("river:create:object:thewire:reply", array($subject_link, $parent_link));
	
} else {
	$summary = elgg_echo("river:create:object:thewire", array($subject_link));
}


echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => false, // replaced $excerpt by false to avoid hiding Wire content (very short anyway..)
	'summary' => $summary . '&nbsp;: ' . $excerpt,
));
