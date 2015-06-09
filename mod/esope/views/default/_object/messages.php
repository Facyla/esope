<?php
/**
 * Message renderer.
 *
 * @package ElggMessages
 */

$full = elgg_extract('full_view', $vars, false);
$message = elgg_extract('entity', $vars, false);

if (!$message) { return true; }

$page_owner_guid = elgg_get_page_owner_guid();
$fromuser = get_entity($message->fromId);
$touser = get_entity($message->toId);

$icon = '';
$class = 'message ';

// Determine the real context (messages plugin don't tell us)
$fullurl = full_url();
$context = 'read';
if (strpos($fullurl, 'messages/inbox')) $context = 'inbox';
else if (strpos($fullurl, 'messages/sent')) $context = 'sent';

if ($fromuser) {
	$fromicon = elgg_view_entity_icon($fromuser, 'tiny');
	if ($fromuser->guid == $page_owner_guid) {
		$fromuser_link = $fromuser->name;
	} else {
		$fromuser_link = elgg_view('output/url', array('href' => "messages/compose?send_to=$fromuser->guid", 'text' => $fromuser->name, 'is_trusted' => true));
	}
} else {
	$fromuser_link = elgg_echo('messages:deleted_sender');
}

if ($touser) {
	$toicon = elgg_view_entity_icon($touser, 'tiny');
	if ($touser->guid == $page_owner_guid) {
		$touser_link = $touser->name;
	} else {
		$touser_link = elgg_view('output/url', array('href' => "messages/compose?send_to=$touser->guid", 'text' => $touser->name, 'is_trusted' => true));
	}
} else {
	$touser_link = elgg_echo('messages:deleted_sender');
}


// Only check unread messages received by the page owner (sent message *are* read)
if (($message->toId == elgg_get_page_owner_guid()) && !$message->readYet) { $class .= 'unread'; } else { $class .= 'read'; }

//$user_link = elgg_echo('messages:from') . " $fromuser_link " . strtolower(elgg_echo('messages:to')) . " $touser_link";
if ($context == 'inbox') {
	$user_link = $fromuser_link;
	$icon = $fromicon;
} else if ($context == 'sent') {
	$user_link = $touser_link;
	$icon = $toicon;
} else {
	$user_link = "$fromuser_link " . strtolower(elgg_echo('messages:to')) . " $touser_link";
	$icon = $fromicon . ' ' . $toicon;
}

$timestamp = elgg_view_friendly_time($message->time_created);

$subject_info = '';
if (!$full) {
	$subject_info .= "<input type='checkbox' name=\"message_id[]\" value=\"{$message->guid}\" />";
}
$subject_info .= elgg_view('output/url', array(
		'href' => $message->getURL(),
		'text' => $message->title,
		'is_trusted' => true,
	));

$delete_link = elgg_view("output/confirmlink", array(
		'href' => "action/messages/delete?guid=" . $message->getGUID(),
		'text' => "<span class=\"elgg-icon elgg-icon-delete float-alt\"></span>",
		'confirm' => elgg_echo('deleteconfirm'),
		'encode_text' => false,
	));

$body = <<<HTML
<div class="messages-owner">$user_link</div>
<div class="messages-subject">$subject_info</div>
<div class="messages-timestamp">$timestamp</div>
<div class="messages-delete">$delete_link</div>
HTML;

if ($full) {
	echo elgg_view_image_block($icon, $body, array('class' => $class));
	echo elgg_view('output/longtext', array('value' => $message->description));
} else {
	echo elgg_view_image_block($icon, $body, array('class' => $class));
}

