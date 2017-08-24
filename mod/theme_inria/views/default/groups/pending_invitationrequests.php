<?php
/**
 * A user's group join requests
 *
 * @uses $vars['requests'] Optional. Array of ElggGroups
 */

if (isset($vars['requests'])) {
	$requests = $vars['requests'];
	unset($vars['requests']);
} else {
	$user = elgg_get_page_owner_entity();
	$vars['limit'] = get_input('limit', elgg_get_config('default_limit'));
	$vars['offset'] = get_input('offset', 0);
	$vars['count'] = esope_groups_get_requested_groups($user->guid, false, array('count' => true));
	$requests = esope_groups_get_requested_groups($user->guid, false, array(
		'limit' => $limit,
		'offset' => $offset
			));
}

$vars['items'] = $requests;
$vars['item_view'] = 'group/format/pending_invitationrequest';
$vars['no_results'] = elgg_echo('groups:invitations:pending:none');

echo elgg_view('page/components/list', $vars);
