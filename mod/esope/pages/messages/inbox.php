<?php
/**
 * Elgg messages inbox page
 *
 * @package ElggMessages
*/

elgg_gatekeeper();

$page_owner = elgg_get_page_owner_entity();

if (!$page_owner || !$page_owner->canEdit()) {
	$guid = 0;
	if($page_owner){
		$guid = $page_owner->getGUID();
	}
	register_error(elgg_echo("pageownerunavailable", array($guid)));
	forward();
}

elgg_push_breadcrumb(elgg_echo('messages:inbox'));

elgg_register_title_button();

$title = elgg_echo('messages:user', array($page_owner->name));

// ESOPE : add unread filter
$unread = get_input('unread', false);
if ($unread) {
	// We need to set limit and offset because we must use this direct function
	$limit = get_input('limit', 10);
	$offset = get_input('offset', 0);
	$count_unread_messages = messages_get_unread($page_owner->guid, $limit, 0, true);
	$unread_messages = messages_get_unread($page_owner->guid, $limit, $offset);
	//$list = elgg_view_entity_list($unread_messages, array('list_type_toggle' => false, 'pagination' => true, 'full_view' => false, 'count' => $count_unread_messages, 'limit' => $limit, 'offset' => $offset));
	if ($count_unread_messages > 0) {
		$guids = array();
		foreach($unread_messages as $ent) { $guids[] = $ent->guid; }
		$list = elgg_list_entities(array('guids' => $guids, 'list_type_toggle' => false, 'pagination' => true, 'full_view' => false, 'count' => $count_unread_messages, 'limit' => $limit, 'offset' => $offset, 'preload_owners' => true, 'bulk_actions' => true));
	}
} else {
	$list = elgg_list_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => 'messages',
		'metadata_name' => 'toId',
		'metadata_value' => elgg_get_page_owner_guid(),
		'owner_guid' => elgg_get_page_owner_guid(),
		'full_view' => false,
		'preload_owners' => true,
		'bulk_actions' => true
	));
}

$body_vars = array(
	'folder' => 'inbox',
	'list' => $list,
);

$content = '<p>';
if ($unread) {
	$content .= '<a href="' . elgg_get_site_url() . 'messages/inbox/' . $page_owner->username . '">' . elgg_echo('esope:messages:allinbox') . '</a> &nbsp; <strong>' . elgg_echo('esope:messages:unreadonly') . '</strong>';
} else {
	$content .= '<strong>' . elgg_echo('esope:messages:allinbox') . '</strong> &nbsp; <a href="?unread=true">' . elgg_echo('esope:messages:unreadonly') . '</a>';
}
$content .= '</p>';
$content .= elgg_view_form('messages/process', array(), $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => elgg_echo('messages:inbox'),
	'filter' => '',
));

echo elgg_view_page($title, $body);
