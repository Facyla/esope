<?php
// Ensure that only logged-in users can see this page
gatekeeper();

$user_guid = elgg_get_logged_in_user_guid();
$user = elgg_get_logged_in_user_entity();

// Set context and title
elgg_set_page_owner_guid($user_guid);
//$title = elgg_echo('dashboard');
$title = elgg_echo('groups:membershiprequests');

$body = '';

$base_group_requests_url = elgg_get_site_url() . 'groups/requests/';

// Set to true to view actual requests, false to count
$view_requests = get_input('view_requests', 'yes');
$body .= '<p><em><a href="?view_requests=yes">View requests</a> &nbsp; <a href="?view_requests=no">Hide requests</a> &nbsp (' . $view_requests . ')</em></p>';


// User mode = own groups (where user is admin)
$body .= "<h3>Demandes d'adhésion dans les groupes font je suis reponsable</h3>";
$admin_groups = esope_get_owned_groups();
foreach ($admin_groups as $ent) {
	$url = elgg_get_site_url() . "groups/requests/{$ent->guid}";
	if ($view_requests == 'yes') {
		$requests = elgg_get_entities_from_relationship(array(
			'type' => 'user',
			'relationship' => 'membership_request',
			'relationship_guid' => $ent->guid,
			'inverse_relationship' => true,
			'limit' => 0,
		));
		if ($requests) {
			$text = elgg_echo('groups:membershiprequests:pending', array(count($requests)));
			$body .= '<p><strong>' . $ent->name . '&nbsp;:</strong> <a href="' . $url . '">' . $text . '</a></p>';
			// View group requests
			$body .= elgg_view('groups/membershiprequests', array('requests' => $requests, 'entity' => $group));
		}
	} else {
		$count = elgg_get_entities_from_relationship(array(
			'type' => 'user',
			'relationship' => 'membership_request',
			'relationship_guid' => $ent->guid,
			'inverse_relationship' => true,
			'count' => true,
		));
		if ($count) {
			$text = elgg_echo('groups:membershiprequests:pending', array($count));
			$body .= '<p><strong>' . $ent->name . '&nbsp;:</strong> <a href="' . $url . '">' . $text . '</a></p>';
		}
	}
}
$body .= '<div class="clearfloat"></div><br />';


// Admin mode = all groups
// @TODO : toutes les demandes d'adhésion en attente
if (elgg_is_admin_logged_in()) {
	
	// Nombre de groupes dans lesquels il y a des demandes en attente
	$count = elgg_get_entities_from_relationship(array(
		'type' => 'group',
		'relationship' => 'membership_request',
		'count' => true,
	));
	$body .= "<h3>Groupes dans lesquels il y a des demandes en attente : $count</h3>";
	$groups = elgg_get_entities_from_relationship(array(
		'type' => 'group',
		'relationship' => 'membership_request',
		'limit' => 0,
	));
	$body .= "<p>Nombre de demandes totales : " . count($groups) . "</p>";
	foreach ($groups as $ent) {
		$body .= '<a href="' . $base_group_requests_url . $ent->guid . '">' . $ent->name . '</a> &nbsp; ';
	}
	$body .= '<div class="clearfloat"></div><br />';
	
	// Nombre de membres ayant des demandes en attente
	$count = elgg_get_entities_from_relationship(array(
		'type' => 'user',
		'relationship' => 'membership_request',
		'inverse_relationship' => true,
		'count' => true,
	));
	$body .= "<h3>Membres ayant des demandes en attente : $count</h3>";
	$users = elgg_get_entities_from_relationship(array(
		'type' => 'user',
		'relationship' => 'membership_request',
		'inverse_relationship' => true,
		'limit' => 0,
	));
	$body .= "<p>Nombre de demandes totales : " . count($users) . "</p>";
	// No use to add a link (cannot validate from profile)
	foreach ($users as $ent) { $body .= '' . $ent->name . ' &nbsp; '; }
	$body .= '<div class="clearfloat"></div><br />';
	
	
	$body .= "<h3>Demandes d'adhésion dans tous les groupes (admin)</h3>";
	$groups = elgg_get_entities(array('types' => 'group', 'limit' => 0));
	foreach ($groups as $ent) {
		if ($ent->canEdit() && !$ent->isPublicMembership()) {
			$url = elgg_get_site_url() . "groups/requests/{$ent->guid}";
			if ($view_requests == 'yes') {
				$requests = elgg_get_entities_from_relationship(array(
					'type' => 'user',
					'relationship' => 'membership_request',
					'relationship_guid' => $ent->guid,
					'inverse_relationship' => true,
					'limit' => 0,
				));
				if ($requests) {
					$text = elgg_echo('groups:membershiprequests:pending', array(count($requests)));
					$body .= '<h4>' . $ent->name . '&nbsp;:</strong> <a href="' . $url . '">' . $text . '</h4>';
					// View group requests
					$body .= elgg_view('groups/membershiprequests', array('requests' => $requests, 'entity' => $group));
				}
			} else {
				$count = elgg_get_entities_from_relationship(array(
					'type' => 'user',
					'relationship' => 'membership_request',
					'relationship_guid' => $ent->guid,
					'inverse_relationship' => true,
					'count' => true,
				));
				if ($count) {
					$text = elgg_echo('groups:membershiprequests:pending', array($count));
					$body .= '<p><strong>' . $ent->name . '&nbsp;:</strong> <a href="' . $url . '">' . $text . '</a></p>';
				}
			}
		}
	}
}
$body .= '<div class="clearfloat"></div><br />';




// @TODO use code from view to make a more usable global list
/**
 * A group's member requests
 *
 * @uses $vars['entity']   ElggGroup
 * @uses $vars['requests'] Array of ElggUsers
 */
/*
if (!empty($vars['requests']) && is_array($vars['requests'])) {
	echo '<ul class="elgg-list">';
	foreach ($vars['requests'] as $user) {
		$icon = elgg_view_entity_icon($user, 'tiny', array('use_hover' => 'true'));

		$user_title = elgg_view('output/url', array(
			'href' => $user->getURL(),
			'text' => $user->name,
			'is_trusted' => true,
		));

		$url = "action/groups/addtogroup?user_guid={$user->guid}&group_guid={$vars['entity']->guid}";
		$url = elgg_add_action_tokens_to_url($url);
		$accept_button = elgg_view('output/url', array(
			'href' => $url,
			'text' => elgg_echo('accept'),
			'class' => 'elgg-button elgg-button-submit',
			'is_trusted' => true,
			'confirm' => true,
		));

		$url = 'action/groups/killrequest?user_guid=' . $user->guid . '&group_guid=' . $vars['entity']->guid;
		$delete_button = elgg_view('output/url', array(
				'href' => $url,
				'confirm' => elgg_echo('groups:joinrequest:remove:check'),
				'text' => elgg_echo('delete'),
				'class' => 'elgg-button elgg-button-delete mlm',
		));

		$body = "<h4>$user_title</h4>";
		$alt = $accept_button . $delete_button;

		echo '<li class="pvs">';
		echo elgg_view_image_block($icon, $body, array('image_alt' => $alt));
		echo '</li>';
	}
	echo '</ul>';
} else {
	echo '<p class="mtm">' . elgg_echo('groups:requests:none') . '</p>';
}
*/


$body .= '<div class="clearfloat"></div>';

// Rendu dans la page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $body));

// Affichage
echo elgg_view_page($title, $body);

