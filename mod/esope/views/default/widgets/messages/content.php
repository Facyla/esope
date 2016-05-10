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

$content = elgg_view_entity_list('', array('entities' => messages_get_unread(), 'limit' => $num, 'full_view' => false, 'list_type_toggle' => false, 'pagination' => true));
// @TODO : pass guids and not entities to list them...
//$content = elgg_list_entities(array('entities' => messages_get_unread(), 'limit' => $num, 'full_view' => false, 'list_type_toggle' => false, 'pagination' => true));

echo $content;

$new_message_url = "messages/add/" . elgg_get_page_owner_guid();
$new_message_link = elgg_view('output/url', array(
		'href' => $new_message_url,
		'text' => elgg_echo('messages:new'),
		'is_trusted' => true,
	));
if ($content) {
	$messages_url = "messages/inbox/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $messages_url . '?unread=true',
		'text' => elgg_echo('messages:moremessages'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
	echo "<span class=\"elgg-widget-more\">$new_message_link</span>";
} else {
	echo elgg_echo('messages:nomessages') . '<br /><br />';
	echo "<span class=\"elgg-widget-more\">$new_message_link</span>";
}

