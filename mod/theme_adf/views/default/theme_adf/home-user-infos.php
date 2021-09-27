<?php
use Elgg\Database\Clauses\OrderByClause;
$user = elgg_extract('user', $vars);

$page_owner = elgg_get_page_owner_entity();
elgg_set_page_owner_guid($user->guid);

$infos = '';
if (!elgg_in_context('digest') && !elgg_in_context('cron')) {
	$infos .= "<p>Actuellement &nbsp;: " . elgg_count_entities(['type' => 'user']) . ' membres';
	$infos .= ', ' . find_active_users(['seconds' => 1800, 'count' => true]) . ' connectés';
	$infos .= '</p>';
}

// Invitations : groupes, contacts
$group_invitations = elgg_call(ELGG_IGNORE_ACCESS, function() use ($user) {
	return elgg_get_relationships([
		'relationship' => 'invited',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => true,
		'no_results' => elgg_echo('groups:invitations:none'),
		'count' => true,
	]);
});
if ($group_invitations > 0) {
	if ($group_invitations > 1) {
		$infos .= '<p><a href="' . elgg_get_site_url() . 'groups/invitations/' . $user->username . '"><i class="fa fa-users"></i>&nbsp;' . "$group_invitations invitations à rejoindre un espace de travail" . '</a></p>';
	} else {
		$infos .= '<p><a href="' . elgg_get_site_url() . 'groups/invitations/' . $user->username . '"><i class="fa fa-users"></i>&nbsp;' . "$group_invitations invitation à rejoindre un espace de travail" . '</a></p>';
	}
}
//if ($group_invitations > 0) { $infos .= elgg_view('groups/invitationrequests') . '</p>'; }

// Gestion des demandes d'adhésion (admin groupe)
// Pour tous les groupes dont on est admin
$owned_groups = elgg_get_entities([
	'type' => 'group', 'owner_guid' => $user->guid,
	'order_by_metadata' => ['name' => 'name', 'direction' => 'ASC'],
]);
$owned_groups_requests = '';
foreach($owned_groups as $group) {
	// Demandes d'adhésion à examiner
	$requests = elgg_get_entities([
		'relationship' => 'membership_request',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'order_by' => new OrderByClause('r.time_created', 'ASC'),
		'count' => true,
	]);
	if ($requests > 0) {
		if ($requests > 1) {
			$owned_groups_requests .= '<li>' . elgg_view('output/url', ['href' => "groups/requests/{$group->guid}", 'text' => '<i class="fa fa-cogs"></i>&nbsp;' . "<strong>{$group->name}&nbsp;:</strong> $requests demandes d'adhésion"]) . '</li>';
		} else {
			$owned_groups_requests .= '<p>' . elgg_view('output/url', ['href' => "groups/requests/{$group->guid}", 'text' => '<i class="fa fa-cogs"></i>&nbsp;' . "<strong>{$group->name}&nbsp;:</strong> $requests demande d'adhésion"]) . '</p>';
		}
	}
}
if (!empty($owned_groups_requests)) {
	if ($requests > 1) {
		$infos .= '<ul>' . $owned_groups_requests . '</ul>';
	} else {
		$infos .= $owned_groups_requests;
	}
}
// @TODO faire une vue pour chaque groupe dont on est propriétaire ou co-administrateur
/* elgg_list_relationships([
	'relationship' => 'membership_request',
	'relationship_guid' => $group->guid,
	'inverse_relationship' => true,
	'order_by' => new OrderByClause('er.time_created', 'ASC'),
	'no_results' => elgg_echo('groups:requests:none'),
]);
*/

//$infos .= elgg_view('groups/membershiprequests') . '</p>';
$infos .= '</p>';

// set the correct context and page owner
elgg_set_page_owner_guid($user->guid);
if (elgg_is_active_plugin('friend_request')) {
	elgg_push_context('friends');
	$friend_requests_received = elgg_get_entities([
		'type' => 'user',
		'relationship' => 'friendrequest',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => true,
		'offset_key' => 'offset_received',
		'no_results' => elgg_echo('friend_request:received:none'),
		'item_view' => 'friend_request/item',
		'count' => true,
	]);
	if ($friend_requests_received > 0) {
		if ($friend_requests_received > 1) {
			$infos .= '<p><a href="' . elgg_get_site_url() . 'friend_request/' . $user->username . '"><i class="fa fa-user"></i>&nbsp;' . "$friend_requests_received demandes de contact reçues" . '</a></p>';
		} else {
			$infos .= '<p><a href="' . elgg_get_site_url() . 'friend_request/' . $user->username . '"><i class="fa fa-user"></i>&nbsp;' . "$friend_requests_received demande de contact reçue" . '</a></p>';
		}
	}
	//if ($friend_requests_received > 0) { $infos .= elgg_view('friend_request/received'); }
	$friend_requests_sent = elgg_get_entities([
		'type' => 'user',
		'relationship' => 'friendrequest',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => false,
		'offset_key' => 'offset_sent',
		'no_results' => elgg_echo('friend_request:sent:none'),
		'item_view' => 'friend_request/item',
		'count' => true,
	]);
	if ($friend_requests_sent > 0) {
		if ($friend_requests_sent > 1) {
				$infos .= '<p><a href="' . elgg_get_site_url() . 'friend_request/' . $user->username . '"><i class="fa fa-user-plus"></i>&nbsp;' . "$friend_requests_sent demandes de contact envoyées" . '</a></p>';
		} else {
			$infos .= '<p><a href="' . elgg_get_site_url() . 'friend_request/' . $user->username . '"><i class="fa fa-user-plus"></i>&nbsp;' . "$friend_requests_sent demande de contact envoyée" . '</a></p>';
		}
	}
	//if ($friend_requests_sent > 0) { $infos .= elgg_view('friend_request/sent'); }
	elgg_pop_context();
}


$infos .= '<p>' . elgg_view('output/url', ['href' => "friends/{$user->username}/invite", 'text' => '<i class="fa fa-user-plus"></i>&nbsp;' . "Inviter des collègues à rejoindre Départements en Réseaux", 'class' => ""]) . '</p>';

elgg_set_page_owner_guid($page_owner->guid);

echo $infos;

