<?php
if (!elgg_is_logged_in()) { return; }

$time = elgg_extract('seconds', $vars, 600);
$time = time() - $time;
// No limit (0) is fine for small sites but have to limit displayed results on big ones
$limit = elgg_extract('limit', $vars, 0);
$group = elgg_get_page_owner_entity();

// Get group members who where active in a specific timeframe
// Note: when processing huge sites this is much more efficient than the other method (get active users then filter by group membership)
$dbprefix = elgg_get_config('dbprefix');
$options = array(
	'type' => 'user',
	'relationship' => 'member',
	'relationship_guid' => $group->guid,
	'inverse_relationship' => true,
	'joins' => array("join {$dbprefix}users_entity u on e.guid = u.guid"),
	'wheres' => array(
		"u.last_action >= {$time}",
		theme_inria_active_members_where_clause()
	),
	'order_by' => "u.last_action desc",
	'limit' => $limit,
);

$members_count = elgg_get_entities_from_relationship($options + array('count' => true));
$online_members = elgg_get_entities_from_relationship($options);
foreach($online_members as $ent) {
	$body .= '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIconURL(array('size' => 'small')) . '" title="' . $ent->name . '" /></a>';
}
if (($limit > 0) && ($members_count > $limit)) {
	$members_more_count = $members_count - $limit;
		$content .= elgg_view('output/url', array(
			'href' => 'javascript:void(0);',
			'text' => "+".$members_more_count,
			'is_trusted' => true, 'class' => 'members-more',
		));
}

//echo elgg_view_module('aside', '<h3>' . elgg_echo('theme_inria:groups:online', array($members_count)) . '</h3>', $body);
echo '<div class="group-members-online">';
echo '<h3>' . elgg_echo('theme_inria:groups:online', array($members_count)) . '</h3>';
echo $body;
echo '</div>';


