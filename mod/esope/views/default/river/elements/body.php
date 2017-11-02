<?php
/**
 * Body of river item
 *
 * @uses $vars['item']        ElggRiverItem
 * @uses $vars['summary']     Alternate summary (the short text summary of action)
 * @uses $vars['message']     Optional message (usually excerpt of text)
 * @uses $vars['attachments'] Optional attachments (displaying icons or other non-text data)
 * @uses $vars['responses']   Alternate responses (comments, replies, etc.)
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

// river item header
$timestamp = elgg_view_friendly_time($item->getTimePosted());

// Esope : User profile gatekeeper block
$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();
$subject_allowed = esope_user_profile_gatekeeper($subject, false);
$object_allowed = esope_user_profile_gatekeeper($object, false);
if (!$subject_allowed || !$object_allowed) {
	//$summary = elgg_echo('InvalidParameterException:NoEntityFound');
	$summary = elgg_echo('esope:group_activity:notloggedin');
echo <<<RIVER
$menu
<div class="elgg-river-summary">$summary $group_string <span class="elgg-river-timestamp">$timestamp</span></div>
$message
RIVER;
return;
}

$urlicon = elgg_get_site_url() . 'mod/esope/img/theme/';

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
if ($message !== null) {
	$message = "<div class=\"elgg-river-message\">$message</div>";
}

$attachments = elgg_extract('attachments', $vars);
if ($attachments !== null) {
	$attachments = "<div class=\"elgg-river-attachments clearfix\">$attachments</div>";
}

$responses = elgg_view('river/elements/responses', $vars);
//if (!empty(trim(strip_tags($responses)))) {   // fails with old php versions
$response_text = trim(strip_tags($responses));
if (!empty($responses_text)) {
	$use_hide_block = elgg_get_plugin_setting('river_hide_block', 'esope');
	if ($use_hide_block == 'yes') {
		$responses = elgg_view('output/url', array(
				//'text' => '<img src="' . $urlicon . 'ensavoirplus.png" alt="' . elgg_echo('esope:showresponses') . '" />',
				'text' => elgg_echo('esope:showresponses'),
				'title' => elgg_echo('esope:showresponses:title', array($object->title)),
				'href' => '#river-responses-' . $item->id,
				'rel' => 'toggle',
				//'class' => 'ouvrir',
				'class' => 'esope-toggle',
			))
			. '<div class="elgg-river-responses hidden" id="river-responses-' . $item->id . '">' . $responses . '</div>';
		/*
		$responses = '<a class="ouvrir" href="javascript:void(0);" title="' . elgg_echo('esope:showresponses:title', array($object->title)) . '"><img src="' . $urlicon . 'ensavoirplus.png" alt="' . elgg_echo('esope:showresponses') . '" /></a>'
			. '<div class="plus">'
			. '<div class="elgg-river-responses">' . $responses . '</div>'
			. '</div>';
		*/
	} else {
		$responses = '<div class="elgg-river-responses">' . $responses . '</div>';
	}
}

/*
// Toutes ces infos habituellement affichées sont regroupées sous forme de bloc dépliable
$urlicon = $elgg_get_site_url() . 'mod/esope/img/theme/';
$object = get_entity($item->object_guid);
if (elgg_in_context('widgets')) {
	$plus_content = $message . $attachments . $responses;
	$plus_textcontent = strip_tags($plus_content);
	if (!empty($plus_textcontent)) {
		$message = '<a class="ouvrir" href="javascript:void(0);" title="' . elgg_echo('esope:moreinfoon', array($object->title)) . '"><img src="' . $urlicon . 'ensavoirplus.png" alt="' . elgg_echo('esope:expand') . '" /></a><div class="plus">' . $plus_content . '</div>';
	}
} else {
	$message = $message . $attachments;
	$plus_content = $responses;
	$plus_textcontent = strip_tags($plus_content);
	if (!empty($plus_textcontent)) {
		$message .= '<a class="ouvrir" href="javascript:void(0);" title="' . elgg_echo('esope:moreinfoon', array($object->title)) . '"><img src="' . $urlicon . 'ensavoirplus.png" alt="' . elgg_echo('esope:expand') . '" /></a><div class="plus">' . $plus_content . '</div>';
	}
}
*/

$group_string = '';
$object = $item->getObjectEntity();
$container = $object->getContainerEntity();
// Esope : always tell the container group (of the commented object)
if (elgg_instanceof($object, 'object', 'comment')) {
	$container = $container->getContainerEntity();
}
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	));
	$group_string = elgg_echo('river:ingroup', array($group_link));
}

echo <<<RIVER
$menu
<div class="elgg-river-summary">$summary $group_string <span class="elgg-river-timestamp">$timestamp</span></div>
$message
$attachments
$responses
RIVER;
