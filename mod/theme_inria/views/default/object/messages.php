<?php
/**
 * Message renderer.
 *
 * @package ElggMessages
 */

$full = elgg_extract('full_view', $vars, false);
$message = elgg_extract('entity', $vars, false);
$bulk_actions = (bool) elgg_extract('bulk_actions', $vars, false);

if (!$message) { return true; }

if ($message->toId == elgg_get_page_owner_guid()) {
	// received
	//$user = get_user($message->fromId);
	// ESOPE : can actually be a group, or even site
	$user = get_entity($message->fromId);
	if (elgg_instanceof($user, 'user')) {
		$icon = '<img src="' . $user->getIconUrl(array('size' => 'tiny')) . '" class="float" />';
		/*
		$user_link = elgg_view('output/url', array(
			'href' => "messages/compose?send_to=$user->guid",
			'text' => $user->name,
			'is_trusted' => true,
		));
		*/
		$user_link = elgg_view('output/url', array(
			'href' => $user->getURL(),
			'text' => $icon . '&nbsp;' . $user->name,
			'is_trusted' => true,
		));
	} else if (elgg_instanceof($user)) {
		$icon = '<img src="' . $user->getIconUrl(array('size' => 'tiny')) . '" class="float" />';
		$user_link = $user->name;
		if (empty($user_link)) { $user_link = $user->title; }
		$user_link = $icon . '&nbsp;' . $user_link;
	} else {
		$user_link = elgg_echo('messages:deleted_sender');
	}

	if ($message->readYet) { $class = 'message read'; } else { $class = 'message unread'; }

} else {
	// sent (always to a user)
	$user = get_user($message->toId);
	if ($user) {
		$icon = '<img src="' . $user->getIconUrl(array('size' => 'tiny')) . '" class="float" />';
		/*
		$user_link = elgg_view('output/url', array(
			'href' => "messages/compose?send_to=$user->guid",
			'text' => elgg_echo('messages:to_user', array($user->name)),
			'is_trusted' => true,
		));
		*/
		$user_link = elgg_view('output/url', array(
			'href' => $user->getURL(),
			'text' => $icon . '&nbsp;' . $user->name,
			'is_trusted' => true,
		));
	} else {
		$user_link = elgg_echo('messages:deleted_sender');
	}
	$class = 'message read';
}

$timestamp = elgg_view_friendly_time($message->time_created);

$subject_info = elgg_view('output/url', array(
	'href' => $message->getURL(),
	'text' => $message->title,
	'is_trusted' => true,
));

$delete_link = elgg_view("output/url", array(
		'href' => "action/messages/delete?guid=" . $message->getGUID() . "&full=$full",
		'text' => elgg_view_icon('delete', 'float-alt'),
		'confirm' => elgg_echo('deleteconfirm'),
		'encode_text' => false,
		'is_action' => true,
	));

$body = <<<HTML
<div class="messages-delete">$delete_link</div>
<div class="messages-owner">$user_link</div>
<div class="messages-subject"><h3>$subject_info</h3></div>
<div class="messages-timestamp">$timestamp</div>
HTML;


if ($full) {
	//echo elgg_view_image_block($icon, $body, array('class' => $class));
	echo elgg_view_image_block('', $body, array('class' => $class));
	echo elgg_view('output/longtext', array('value' => $message->description));
	
} else {
	
	$excerpt = elgg_get_excerpt($message->description);
	if (strlen($excerpt) != strlen(trim(elgg_strip_tags($message->description)))) {
		$excerpt .= elgg_view('output/url', array(
			'href' => $message->getUrl(),
			'text' => elgg_echo('theme_inria:readmore'),
			'class' => 'readmore',
		));
	}
	$body .= elgg_view("output/longtext", array("value" => $excerpt, "class" => "elgg-subtext clearfloat"));
	
	if (elgg_instanceof($user, 'user') && ($user->guid != elgg_get_page_owner_guid())) {
		$reply_link = elgg_view('output/url', array(
				'href' => $message->getUrl() . '#messages-reply-form',
				'text' => elgg_echo('theme_inria:reply'),
				'class' => 'elgg-button elgg-button-action reply',
			));
		$body .= '<div class="messages-reply">' . $reply_link . '</div>';
	}
	
	if ($bulk_actions) {
		$checkbox = elgg_view('input/checkbox', array(
			'name' => 'message_id[]',
			'value' => $message->guid,
			'default' => false
		));
	
		//$user_listing = elgg_view_image_block($icon, $body, array('class' => $class));
		$user_listing = elgg_view_image_block('', $body, array('class' => $class));
		
		echo elgg_view_image_block($checkbox, $user_listing);
	} else {
		//echo elgg_view_image_block($icon, $body, array('class' => $class));
		echo elgg_view_image_block('', $body, array('class' => $class));
	}
}

