<?php
/**
 * Announcement river view.
 */

$item = $vars['item'];

$object = $item->getObjectEntity();

// Remove comments if disabled
$can_comment = elgg_get_plugin_setting('can_comment', 'announcements');


$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

// river item header
$timestamp = elgg_view_friendly_time($item->getTimePosted());

$summary = elgg_extract('summary', $vars);
if ($summary === null) {
	$summary = elgg_view('river/elements/summary', array(
		'item' => $vars['item'],
	));
}

if ($summary === false) {
	$subject = $item->getSubjectEntity();
	$summary = elgg_view('output/url', array(
		'href' => $subject->getURL(),
		'text' => $subject->name,
		'class' => 'elgg-river-subject',
		'is_trusted' => true,
	));
}

$excerpt = strip_tags($object->excerpt);
$excerpt = elgg_get_excerpt($excerpt);
if ($excerpt !== null) {
	$excerpt = "<div class=\"elgg-river-message\">$excerpt</div>";
}

$attachments = elgg_extract('attachments', $vars);
if ($attachments !== null) {
	$attachments = "<div class=\"elgg-river-attachments clearfix\">$attachments</div>";
}

if ($can_comment == 'yes') {
	$responses = elgg_view('river/elements/responses', $vars);
	if ($responses) {
		$responses = "<div class=\"elgg-river-responses\">$responses</div>";
	}
}

$group_string = '';
$container = $object->getContainerEntity();
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	));
	$group_string = elgg_echo('announcements:river:togroup', array($group_link));
}

$body = <<<RIVER
$menu
<div class="elgg-river-summary">$summary $group_string <span class="elgg-river-timestamp">$timestamp</span></div>
$excerpt
$responses
RIVER;

echo elgg_view('page/components/image_block', array(
	'image' => elgg_view('river/elements/image', $vars),
	'body' => $body,
	'class' => 'elgg-river-item',
));


/* Non utilisé car utilise "dans le groupe" au lieu de "aux membres de"
echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'message' => $excerpt,
));
*/

