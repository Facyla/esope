<?php
/**
* Read a message page
*
* @package ElggMessages
*/

gatekeeper();

$message = get_entity(get_input('guid'));
if (!$message || !elgg_instanceof($message, "object", "messages")) {
	forward('messages/inbox/' . elgg_get_logged_in_user_entity()->username);
}

// mark the message as read
$message->readYet = true;

// Page owner is logged in user (can't view anyone else' messages)
$ownuser = elgg_get_logged_in_user_entity();
$ownuser_guid = $ownuser->guid;
//elgg_set_page_owner_guid($message->getOwnerGUID());
elgg_set_page_owner_guid($ownuser_guid);

// Allow some filtering of the message : all/sent/inbox + current (or any other means nothing but current message)
$filter = get_input('filter', 'all');
// Should we list all messages, or only the conversation this message is in ? : user/conversation
$conversation = get_input('conversation', 'conversation');

$title = str_replace('RE: ', '', $message->title);

// Tell own and other user, and inbox msg, depending on the current message
$is_inbox_msg = false;
if ($ownuser_guid == $message->toId) {
	$is_inbox_msg = true;
	$otheruser_guid = $message->fromId;
	elgg_push_breadcrumb(elgg_echo('messages:inbox'), 'messages/inbox/' . $ownuser->username);
} else {
	$otheruser_guid = $message->toId;
	elgg_push_breadcrumb(elgg_echo('messages:sent'), 'messages/sent/' . $ownuser->username);
}
elgg_push_breadcrumb($title);
$otheruser = get_user($otheruser_guid);

$content = '';

// Form de réponse : différenciation selon qu'on réponde au message de son interlocuteur, à l'un de ses propres messages
if ($is_inbox_msg) {
	$form_params = array('id' => 'messages-reply-form', 'class' => 'hidden mtl', 'action' => 'action/messages/send');
	$body_params = array('message' => $message);
	$content .= elgg_view_form('messages/reply', $form_params, $body_params);
	$from_user = get_user($message->fromId);
	if ((elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) && $from_user) {
		elgg_register_menu_item('title', array(
			'name' => 'reply', 'href' => '#messages-reply-form',
			'text' => elgg_echo('messages:answer') . ' ' . strtolower(elgg_echo('messages:to')) . ' ' . $from_user->name,
			'link_class' => 'elgg-button elgg-button-action', 'rel' => 'toggle',
		));
	}
} else {
	$form_params = array('id' => 'messages-reply-form', 'class' => 'hidden mtl', 'action' => 'action/messages/send');
	$body_params = array('message' => $message, 'send_to_sender' => true);
	$content .= elgg_view_form('messages/reply', $form_params, $body_params);
	$to_user = get_user($message->toId);
	if ((elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) && $to_user) {
		elgg_register_menu_item('title', array(
			'name' => 'reply', 'href' => '#messages-reply-form',
			'text' => elgg_echo('messages:answer') . ' ' . strtolower(elgg_echo('messages:to')) . ' ' . $to_user->name,
			'link_class' => 'elgg-button elgg-button-action', 'rel' => 'toggle',
		));
	}
}


// 1. RECUPERATION DES MESSAGES DE LA CONVERSATION

// Message envoyés par l'autre membre à l'auteur = messages reçus
if (in_array($filter, array('inbox', 'all'))) {
	$messages_inbox = elgg_get_entities_from_metadata(array('type' => 'object', 'subtype' => 'messages', 'metadata_names' => 'fromId', 'metadata_values' => $otheruser->guid, 'owner_guid' => $ownuser_guid, 'limit' => false));
	foreach ($messages_inbox as $ent) { $messages[$ent->time_created] = $ent; }
}
// Message envoyés par l'auteur à l'autre membre = messages envoyés
if (in_array($filter, array('sent', 'all'))) {
	$messages_sent = elgg_get_entities_from_metadata(array('type' => 'object', 'subtype' => 'messages', 'metadata_names' => 'toId', 'metadata_values' => $otheruser_guid, 'owner_guid' => $ownuser_guid, 'limit' => false));
	foreach ($messages_sent as $ent) { $messages[$ent->time_created] = $ent; }
}
// Add asked message at the end - just in case there could be another message at the exact same timestamp
$messages[$message->time_created] = $message;


// 2. TRI ET AFFICHAGE
krsort($messages);
$content .= '<ul class="elgg-list elgg-list-entity">';
foreach ($messages as $timestamp => $ent) {
	$ent_title = str_replace('RE: ', '', $ent->title);
	// Similarités et affichage d'une "conversation" : pas plus de 6 carac de diff, sachant qu'on enlève les "RE : " avant...
	//if (($conversation != 'user') && levenshtein($message->title, $ent_title) > 6) continue;
	// Note : un titre exact est plus précis, à moins de vouloir relier des sujets proches...
	if (($conversation != 'user') && ($message->title != $ent_title)) continue;
	if ($ent->fromId == $ownuser_guid) $class = 'message-sent'; else $class = 'message-inbox';
	// Différenciation du message sur lequel on est
	if ($ent->guid == $message->guid) {
		$selected = ' selected-message';
		$toggle = '';
	} else {
		$toggle = '<a href="javascript:void(0);" onClick="$(\'#elgg-message-'.$ent->guid.'\').toggle(); $(this).hide();" class="message-item-toggle"><p>' . elgg_view_friendly_time($timestamp) . '</p></a>';
		$selected = '';
	}
	$content .= '<li id="elgg-object-'.$ent->guid.'" class="elgg-item elgg-item-message '.$class.$selected.'">' . $toggle;
	$content .= '<div id="elgg-message-'.$ent->guid.'" class="message-content '.$selected.'">';
	$content .= elgg_view_entity($ent, array('full_view' => true));
	$content .= '</div>';
	$content .= '</li>';
}
$content .= '</ul>';

//$content = elgg_view_entity($message, array('full_view' => true));


$body = elgg_view_layout('content', array('content' => $content, 'title' => $title, 'filter' => ''));

echo elgg_view_page($title, $body);

