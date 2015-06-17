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

$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

// river item header
// Use that function to trigger the hook
$timestamp = elgg_get_friendly_time($item->getPostedTime());

// Esope : User profile gatekeeper block
$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();
$subject_allowed = esope_user_profile_gatekeeper($subject, false);
$object_allowed = esope_user_profile_gatekeeper($object, false);
if (!$subject_allowed || !$object_allowed) {
	$summary = elgg_echo('InvalidParameterException:NoEntityFound');
echo <<<RIVER
$menu
<div class="elgg-river-summary">$summary $group_string <span class="elgg-river-timestamp">$timestamp</span></div>
$message
RIVER;
return;
}

$summary = elgg_extract('summary', $vars, elgg_view('river/elements/summary', array('item' => $vars['item'])));
if ($summary === false) {
	$summary = elgg_view('output/url', array(
		'href' => $subject->getURL(),
		'text' => $subject->name,
		'class' => 'elgg-river-subject',
		'is_trusted' => true,
	));
}

$message = elgg_extract('message', $vars, false);
if ($message !== false) {
	$message = "<div class=\"elgg-river-message\">$message</div>";
}

$attachments = elgg_extract('attachments', $vars, false);
if ($attachments !== false) {
	$attachments = "<div class=\"elgg-river-attachments clearfix\">$attachments</div>";
}

$responses = elgg_view('river/elements/responses', $vars);
if ($responses) {
	$responses = "<div class=\"elgg-river-responses\">$responses</div>";
}

$use_hide_block = elgg_get_plugin_setting('river_hide_block', 'adf_public_platform');
if ($use_hide_block == 'yes') {
	// Toutes ces infos habituellement affichées sont regroupées sous forme de bloc dépliable
	$urlicon = $vars['url'] . 'mod/adf_public_platform/img/theme/';
	//$object = get_entity($item->object_guid);
	if (elgg_in_context('widgets')) {
		$plus_content = $message . $attachments . $responses;
		$plus_textcontent = strip_tags($plus_content);
		if (!empty($plus_textcontent)) {
			$message = '<a class="ouvrir" href="javascript:void(0);" title="' . elgg_echo('adf_platform:moreinfoon', array($object->title)) . '"><img src="' . $urlicon . 'ensavoirplus.png" alt="' . elgg_echo('adf_platform:expand') . '" /></a><div class="plus">' . $plus_content . '</div>';
		}
	} else {
		$message = $message . $attachments;
		$plus_content = $responses;
		$plus_textcontent = strip_tags($plus_content);
		if (!empty($plus_textcontent)) {
			$message .= '<a class="ouvrir" href="javascript:void(0);" title="' . elgg_echo('adf_platform:moreinfoon', array($object->title)) . '"><img src="' . $urlicon . 'ensavoirplus.png" alt="' . elgg_echo('adf_platform:expand') . '" /></a><div class="plus">' . $plus_content . '</div>';
		}
	}
} else {
	// Regular view
	$message .= $attachments . $responses;
}

$group_string = '';
$container = $object->getContainerEntity();
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	));
	$group_string = elgg_echo('river:ingroup', array($group_link));
}


// Affichage de la page
echo <<<RIVER
$menu
<div class="elgg-river-summary">$summary $group_string <span class="elgg-river-timestamp">$timestamp</span></div>
$message
RIVER;
