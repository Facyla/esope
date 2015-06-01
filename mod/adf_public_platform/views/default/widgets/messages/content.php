<?php
/**
 * User messages widget display view
 */

$num = $vars['entity']->num_display;

/*
$options = array(
	'type' => 'object',
	'subtype' => 'messages',
	//'container_guid' => $vars['entity']->owner_guid,
	'owner_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);
*/

$owner_guid = elgg_get_page_owner_guid();

$count_unread_messages = messages_get_unread($owner_guid, 10, true);
$unread_messages = messages_get_unread($owner_guid, $num, false);
elgg_push_context('widgets');
$content = elgg_view_entity_list($unread_messages, array('full_view' => false, 'list_type_toggle' => false, 'pagination' => true));
elgg_pop_context();

if ($count_unread_messages > 1) {
	echo '<em>' . elgg_echo('messages:widget:unreadcount', array($count_unread_messages)) . '</em>';
} else if ($count_unread_messages === 1) {
	echo '<em>' . elgg_echo('messages:widget:unreadcount:singular') . '</em>';
} else {
	echo '<p>' . elgg_echo('messages:nomessages') . '</p>';
}

// Display messages
echo $content;

$new_message_url = "messages/add/" . $owner_guid;
$new_message_link = elgg_view('output/url', array(
		'href' => $new_message_url,
		'text' => elgg_echo('messages:new'),
		'is_trusted' => true,
	));

if ($count_unread_messages > 0) {
	$messages_url = "messages/inbox/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $messages_url,
		'text' => elgg_echo('messages:moremessages'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
}

echo "<span class=\"elgg-widget-more\">$new_message_link</span>";

