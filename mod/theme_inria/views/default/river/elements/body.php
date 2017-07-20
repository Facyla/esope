<?php
/**
 * Body of river item
 *
 * @uses $vars['item']        ElggRiverItem
 * @uses $vars['summary']     Alternate summary (the short text summary of action)
 * @uses $vars['message']     Optional message (usually excerpt of text)
 * @uses $vars['attachments'] Optional attachments (displaying icons or other non-text data)
 * @uses $vars['responses']   Alternate responses (comments, replies, etc.)
 * @uses $vars['no_menu']     Removes menu
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

if (!elgg_in_context('river-responses')) {
	$menu = elgg_view_menu('river', array(
		'item' => $item,
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

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

$message = elgg_extract('message', $vars);
//if ($message !== null) {
if (!empty($message)) {
	$message = "<div class=\"elgg-river-message\">$message</div>";
}

$attachments = elgg_extract('attachments', $vars);
//if ($attachments !== null) {
if (!empty($attachments)) {
	$attachments = "<div class=\"elgg-river-attachments clearfix\">$attachments</div>";
}

// Iris v2 : pas d'affichage des réponses (elles sont dans le flux) => listing retiré dans river/elements/responses
elgg_push_context('widgets');
$responses = elgg_view('river/elements/responses', $vars);
//if ($responses) {
if (!empty($responses)) {
	$responses = "<div class=\"elgg-river-responses\">$responses</div>";
}
elgg_pop_context();

// Iris v2 : indication présente dans le menu inférieur
$group_string = '';
/*
$object = $item->getObjectEntity();
$container = $object->getContainerEntity();
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	));
	$group_string = ' ' . elgg_echo('river:ingroup', array($group_link));
}
*/

echo <<<RIVER
<span class="elgg-river-timestamp">$timestamp</span>
<div class="elgg-river-summary">$summary</div>
$message
$attachments
$responses
$menu
<div class="clearfloat"></div>
RIVER;
