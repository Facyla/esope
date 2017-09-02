<?php
/* ESOPE topbar (override)
 * In ESOPE, the topbar is part of the header
 * See page/elements/header view for header and main navigation content
 * 
 * The topbar menu is defined and customized here
 */

$url = elgg_get_site_url();
$urlicon = $url . 'mod/esope/img/theme/';
$urlimg = $url . 'mod/theme_inria/graphics/';

$site = elgg_get_site_entity();
$title = $site->name;
//$prev_q = get_input('q', '');
$prev_q = ''; // Iris v2 switch to search page where there is an alternate input field

$lang = get_language();

elgg_push_context('topbar');


// SVG icons
$svg_mail = '<svg id="iris-mail" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 15"><path d="M21,4.5H3a1,1,0,0,0-1,1v13a1,1,0,0,0,1,1H21a1,1,0,0,0,1-1V5.5A1,1,0,0,0,21,4.5Zm-9,6.8L4.8,6.5H19.2ZM4,17.5V8.37l7.45,5,0,0,.17.08.08,0a1,1,0,0,0,.25,0h0a1,1,0,0,0,.25,0l.08,0,.18-.08,0,0,7.45-5V17.5Z" transform="translate(-2 -4.5)"/></svg>';
$svg_notifications = '<svg id="iris-notification" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.24 21.88"><path d="M21.12,18.82H20.2V11.66A8.21,8.21,0,0,0,13,3.53V2.06a1,1,0,1,0-2,0V3.53A8.21,8.21,0,0,0,3.8,11.66v7.16H2.88a1,1,0,1,0,0,2h6.2l.49.77a2.88,2.88,0,0,0,4.88,0l.49-.77h6.19a1,1,0,0,0,0-2ZM5.8,11.66a6.2,6.2,0,1,1,12.4,0v7.16H5.8Z" transform="translate(-1.88 -1.06)"/></svg>';
$svg_profile = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15 11.2c0.6-0.7 1-1.6 1-2.7 0-2.2-1.8-4.1-4.1-4.1S7.9 6.3 7.9 8.5c0 1 0.4 2 1 2.7 -2.9 1.2-4.9 4-4.9 7.3 0 0.6 0.4 1 1 1h13.8c0.6 0 1-0.4 1-1C19.9 15.2 17.9 12.4 15 11.2zM9.9 8.5c0-1.1 0.9-2.1 2.1-2.1s2.1 0.9 2.1 2.1 -0.9 2.1-2.1 2.1S9.9 9.7 9.9 8.5zM6.2 17.5c0.5-2.8 2.9-4.9 5.8-4.9 2.9 0 5.4 2.1 5.8 4.9H6.2z"/></svg>';
$svg_settings = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.8 20h-1.5c-0.9 0-1.2-0.6-1.8-2 -1.3 0.6-1.5 0.6-1.7 0.6H7.7c-0.2 0-0.5-0.1-0.7-0.2l-0.1-0.1 -1.1-1.1C5.2 16.5 5.4 16 6 14.5c-1.4-0.5-2-0.8-2-1.7v-1.5c0-0.9 0.5-1.2 2-1.8 -0.6-1.4-0.8-2-0.2-2.7l1.1-1.1c0.2-0.2 0.4-0.3 0.7-0.3h0.1c0.2 0 0.5 0 1.7 0.5 0.5-1.4 0.8-2 1.7-2h1.5c0.9 0 1.2 0.5 1.8 2 1.3-0.6 1.5-0.6 1.7-0.6h0.1c0.2 0 0.5 0.1 0.7 0.2l0.1 0.1 1.1 1.1C18.8 7.5 18.6 8 18 9.5c1.4 0.5 2 0.8 2 1.7v1.5c0 0.9-0.6 1.2-2 1.8 0.6 1.4 0.8 2 0.2 2.6l-1.1 1.1c-0.2 0.2-0.4 0.3-0.7 0.3h-0.1c-0.2 0-0.5 0-1.7-0.5C14 19.4 13.7 20 12.8 20zM11.7 18h0.6c0.1-0.2 0.2-0.6 0.5-1.3 0.1-0.3 0.3-0.5 0.6-0.6l0.6-0.2c0.2-0.1 0.5-0.1 0.8 0 0.7 0.3 1.1 0.4 1.3 0.5l0.5-0.5c-0.1-0.3-0.3-0.7-0.5-1.2 -0.1-0.3-0.1-0.5 0-0.8l0.2-0.6c0.1-0.3 0.3-0.4 0.6-0.5 0.6-0.2 1-0.4 1.3-0.5v-0.7c-0.2-0.1-0.6-0.2-1.3-0.5 -0.3-0.1-0.5-0.3-0.6-0.6L15.9 10c-0.1-0.3-0.1-0.5 0-0.8 0.3-0.6 0.4-1 0.5-1.3L16 7.5c-0.2 0.1-0.6 0.3-1.2 0.5 -0.3 0.1-0.5 0.1-0.8 0l-0.6-0.2c-0.3-0.1-0.4-0.3-0.5-0.6 -0.2-0.6-0.4-1-0.5-1.3h-0.6c-0.1 0.2-0.2 0.6-0.5 1.3 -0.1 0.3-0.3 0.5-0.6 0.6L10 8.1c-0.2 0.1-0.5 0.1-0.8 0C8.6 7.8 8.2 7.6 8 7.5L7.5 8c0.1 0.2 0.3 0.6 0.5 1.2 0.1 0.3 0.1 0.5 0 0.8l-0.2 0.6c-0.1 0.3-0.3 0.4-0.6 0.5 -0.6 0.2-1 0.4-1.3 0.5v0.7c0.3 0.1 0.7 0.3 1.3 0.5 0.3 0.1 0.5 0.3 0.6 0.6L8.1 14c0.1 0.2 0.1 0.5 0 0.8 -0.3 0.6-0.4 1-0.5 1.3L8 16.5c0.2-0.1 0.6-0.3 1.2-0.5 0.3-0.1 0.5-0.1 0.8 0l0.6 0.2c0.2 0.1 0.4 0.3 0.5 0.6C11.4 17.3 11.6 17.7 11.7 18zM18.3 11.8L18.3 11.8 18.3 11.8zM12 15c-1.6 0-3-1.3-3-3 0-1.7 1.3-3 3-3 0 0 0 0 0 0 1.7 0 3 1.3 3 3C15 13.6 13.6 15 12 15 12 15 12 15 12 15zM12 14L12 14 12 14zM12 13c0.5 0 1-0.5 1-1 0-0.6-0.4-1-1-1 0 0 0 0 0 0 -0.6 0-1 0.5-1 1C11 12.6 11.4 13 12 13 12 13 12 13 12 13z"/></svg>';
$svg_admin = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.06 16.15"><path d="M10.16,20.07H9.1c-.63,0-.84-.42-1.27-1.41-.91.42-1.05.42-1.2.42H6.57A1.3,1.3,0,0,1,6.08,19L6,18.88l-.77-.77c-.42-.49-.28-.84.14-1.9C4.39,15.86,4,15.65,4,15V14c0-.63.35-.84,1.41-1.27-.42-1-.56-1.41-.14-1.9L6,10a.64.64,0,0,1,.49-.21h.07a3,3,0,0,1,1.2.35c.35-1,.56-1.41,1.2-1.41H10c.63,0,.84.35,1.27,1.41.91-.42,1.05-.42,1.2-.42h.07a1.3,1.3,0,0,1,.49.14l.07.07.77.77c.49.56.35.91-.07,2,1,.35,1.41.56,1.41,1.2v1.05c0,.63-.42.84-1.41,1.27.42,1,.56,1.41.14,1.83l-.77.77a.64.64,0,0,1-.49.21h-.07a3,3,0,0,1-1.2-.35C11,19.65,10.79,20.07,10.16,20.07Zm-.77-1.41h.42c.07-.14.14-.42.35-.91a.63.63,0,0,1,.42-.42l.42-.14a.77.77,0,0,1,.56,0c.49.21.77.28.91.35l.35-.35c-.07-.21-.21-.49-.35-.84a.78.78,0,0,1,0-.56l.14-.42c.07-.21.21-.28.42-.35.42-.14.7-.28.91-.35v-.49c-.14-.07-.42-.14-.91-.35a.63.63,0,0,1-.42-.42L12.34,13a.78.78,0,0,1,0-.56,5.56,5.56,0,0,0,.35-.91l-.28-.28a6.09,6.09,0,0,1-.84.35.78.78,0,0,1-.56,0l-.42-.14c-.21-.07-.28-.21-.35-.42-.14-.42-.28-.7-.35-.91H9.45c-.07.14-.14.42-.35.91a.63.63,0,0,1-.42.42l-.49.21a.77.77,0,0,1-.56,0l-.84-.42-.35.35a6.09,6.09,0,0,1,.35.84.78.78,0,0,1,0,.56l-.14.42c-.07.21-.21.28-.42.35-.42.14-.7.28-.91.35v.49c.21.07.49.21.91.35a.63.63,0,0,1,.42.42l.21.42a.77.77,0,0,1,0,.56,5.56,5.56,0,0,0-.35.91l.28.28a6.09,6.09,0,0,1,.84-.35.78.78,0,0,1,.56,0l.42.14a.72.72,0,0,1,.35.42A4.62,4.62,0,0,1,9.38,18.67ZM14,14.31ZM9.59,16.56a2.12,2.12,0,0,1-2.11-2.11,2.07,2.07,0,0,1,2.11-2.11h0a2.07,2.07,0,0,1,2.11,2.11,2.16,2.16,0,0,1-2.11,2.11Zm0-.7Zm0-.7a.76.76,0,0,0,.7-.7.66.66,0,0,0-.7-.7h0a.7.7,0,0,0-.7.7.66.66,0,0,0,.7.7Z" transform="translate(-3.97 -3.93)"></path><path d="M17.06,10.58h-.62c-.37,0-.5-.25-.74-.83-.54.25-.62.25-.7.25h0a.77.77,0,0,1-.29-.08l0,0-.45-.45c-.25-.29-.17-.5.08-1.12-.58-.21-.83-.33-.83-.7V7c0-.37.21-.5.83-.74-.25-.58-.33-.83-.08-1.12l.45-.45a.37.37,0,0,1,.29-.12h0a1.74,1.74,0,0,1,.7.21c.21-.58.33-.83.7-.83H17c.37,0,.5.21.74.83.54-.25.62-.25.7-.25h0a.77.77,0,0,1,.29.08l0,0,.45.45c.29.33.21.54,0,1.16.58.21.83.33.83.7v.62c0,.37-.25.5-.83.74.25.58.33.83.08,1.07l-.45.45a.37.37,0,0,1-.29.12h0a1.74,1.74,0,0,1-.7-.21C17.55,10.33,17.43,10.58,17.06,10.58Zm-.45-.83h.25c0-.08.08-.25.21-.54A.37.37,0,0,1,17.3,9l.25-.08a.45.45,0,0,1,.33,0c.29.12.45.17.54.21l.21-.21c0-.12-.12-.29-.21-.5a.46.46,0,0,1,0-.33l.08-.25c0-.12.12-.17.25-.21s.41-.17.54-.21V7.11c-.08,0-.25-.08-.54-.21a.37.37,0,0,1-.25-.25l-.17-.21a.46.46,0,0,1,0-.33,3.27,3.27,0,0,0,.21-.54l-.17-.17a3.58,3.58,0,0,1-.5.21.46.46,0,0,1-.33,0l-.25-.08c-.12,0-.17-.12-.21-.25s-.17-.41-.21-.54h-.25c0,.08-.08.25-.21.54a.37.37,0,0,1-.25.25l-.29.12a.45.45,0,0,1-.33,0l-.5-.25-.21.21a3.58,3.58,0,0,1,.21.5.46.46,0,0,1,0,.33L15,6.69c0,.12-.12.17-.25.21s-.41.17-.54.21v.29c.12,0,.29.12.54.21a.37.37,0,0,1,.25.25l.12.25a.45.45,0,0,1,0,.33,3.27,3.27,0,0,0-.21.54l.17.17a3.58,3.58,0,0,1,.5-.21.46.46,0,0,1,.33,0l.25.08a.42.42,0,0,1,.21.25A2.72,2.72,0,0,1,16.6,9.75Zm2.73-2.56Zm-2.6,1.32a1.24,1.24,0,0,1-1.24-1.24A1.22,1.22,0,0,1,16.73,6h0A1.22,1.22,0,0,1,18,7.27a1.27,1.27,0,0,1-1.24,1.24Zm0-.41Zm0-.41a.44.44,0,0,0,.41-.41.39.39,0,0,0-.41-.41h0a.41.41,0,0,0-.41.41.39.39,0,0,0,.41.41Z" transform="translate(-3.97 -3.93)"></path></svg>';
$svg_logout = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.2 17H9c-0.7 0-1.2-0.6-1.2-1.3V8.3C7.8 7.6 8.3 7 9 7h2.2c0.6 0 1-0.4 1-1s-0.4-1-1-1H9C7.2 5 5.8 6.5 5.8 8.3v7.5C5.8 17.5 7.2 19 9 19h2.2c0.6 0 1-0.4 1-1S11.8 17 11.2 17z"/><path d="M20 11.3l-3-3c-0.4-0.4-1-0.4-1.4 0s-0.4 1 0 1.4l1.3 1.3h-5.6c-0.6 0-1 0.4-1 1s0.4 1 1 1h5.6l-1.3 1.3c-0.4 0.4-0.4 1 0 1.4 0.2 0.2 0.5 0.3 0.7 0.3s0.5-0.1 0.7-0.3l3-3C20.3 12.3 20.3 11.7 20 11.3z"/></svg>';
$svg_login = '';



if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	$profile_type = esope_get_user_profile_type($own);
	if (empty($profile_type)) { $profile_type = 'external'; }
	
	// Messages non lus
	$messages_mark = '';
	if (elgg_is_active_plugin('messages')) {
		$messages_count = (int)messages_count_unread();
		if ($messages_count > 0) {
			$text = "$messages_count";
			$tooltip = elgg_echo("messages:unreadcount", array($messages_count));
			$messages_mark = '<span class="iris-new" title="' . $tooltip . '">' . $text . '</span>';
		}
	}
	
	
	// Site notifications
	elgg_load_js('elgg.site_notifications');
	$notifications_mark = '';
	$notifications_text = '';
	$notifications_count = 0;
	$site_notifications_content = '';
	if (elgg_is_active_plugin('site_notifications')) {
		$site_notifications_opt = array(
				'type' => 'object', 'subtype' => 'site_notification',
				'owner_guid' => $own->guid,
				'metadata_name' => 'read', 'metadata_value' => false,
			);
		$site_notifications_count = elgg_get_entities_from_metadata($site_notifications_opt + array('count' => true));
		if ($site_notifications_count > 0) {
			$notifications_count += $site_notifications_count;
			$notifications_text .= elgg_echo("theme_inria:site_notifications:unreadcount", array($site_notifications_count));
			$site_notifications_mark .= '<span class="iris-new" title="' . $site_notifications_text . '">' . $site_notifications_count . '</span>';
			$site_notifications_content = elgg_list_entities_from_metadata($site_notifications_opt + array('pagination' => false));
		}
	}
	
	
	// Friend requests - Demandes de contact en attente (reçues)
	$friendrequests_options = array("type" => "user", "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true, 'limit' => false);
	$friendrequests_entities = elgg_get_entities_from_relationship($friendrequests_options);
	$friendrequests_count = count($friendrequests_entities);
	$friendrequests_content = '';
	if ($friendrequests_count > 0) {
		$friendrequests_text .= elgg_echo("theme_inria:friendrequests:unreadcount", array($friendrequests_count));
		$friendrequests_mark .= '<span class="iris-new" title="' . $friendrequests_text . '">' . $friendrequests_count . '</span>';
		
		$notifications_count += $friendrequests_count;
		if (!empty($notifications_text)) { $notifications_text .= ', '; }
		$notifications_text .= $friendrequests_text;
	}
	// Friend requests - Demandes de contact envoyées (non comptées comme notif car pas "à traiter")
	$friendrequests_options['inverse_relationship'] = false;
	//$friendrequests_sent_entities = elgg_get_entities_from_relationship($friendrequests_options + ['inverse_relationship' => false]);
	$friendrequests_sent_entities = elgg_get_entities_from_relationship($friendrequests_options);
	//$friendrequests_sent_count = count($friendrequests_sent_entities);
	
	$friendrequests_content .= elgg_view('friend_request/received', ['entities' => $friendrequests_entities]);
	$friendrequests_content .= elgg_view('friend_request/sent', ['entities' => $friendrequests_sent_entities]);
	/*
	if ($friendrequests_count == 1) {
		$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvite') . '">' . $friendrequests_count . '</a></li>';
	} else if ($friendrequests_count > 1) {
		$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvites') . '">' . $friendrequests_count . '</a></li>';
	}
	*/
	
	if ($notifications_count > 0) {
		$notifications_mark .= '<span class="iris-new" title="' . $notifications_text . '">' . $notifications_count . '</span>';
	}
	
	
	// Group invites
	$groupinvites_options = array();
	
	// Own invites - invitations reçues
	//$groupinvites_content .= '<h3>INVITATIONS RECUES</h3>';
	// '<a href="' . elgg_get_site_url() . 'groups/invitations/' . $user->username . '">' . 
	//$groupinvites_count = groups_get_invited_groups($own->guid, false, array('count' => true));
	$groupinvites = esope_groups_get_invited_groups($own->guid);
	$groupinvites_count = esope_groups_get_invited_groups($own->guid, false, array('count' => true));
	$groupinvites_content = '';
	if ($groupinvites_count > 0) {
		$groupinvites_text .= elgg_echo("theme_inria:groupinvites:unreadcount", array($groupinvites_count));
		//$groupinvites_mark .= '<span class="iris-new" title="' . $groupinvites_text . '">' . $groupinvites_count . '</span>';
	}
	//$groupinvites_content .= elgg_view('groups/invitationrequests', array('invitations' => $groupinvites));
	$groupinvites_content .= elgg_view('groups/invitationrequests', array('invitations' => $groupinvites));
	
	// Demandes en attente
	$grouprequests = esope_groups_get_requested_groups($own->guid);
	$groupinvites_content .= '<hr />';
	//$groupinvites_content .= '<h3>DEMANDES ENVOYEES</h3>';
	$groupinvites_content .= elgg_view('groups/pending_invitationrequests', array('requests' => $grouprequests));
	
	// Admin group membership requests (groups where user can validate requests as operator)
	//$groupinvites_content .= '<h3>DEMANDES A TRAITER (responsable de groupe)</h3>';
	$grouppendingrequests = esope_groups_get_pending_membership_requests($own->guid);
	$grouppendingrequests_count = count($grouppendingrequests);
	$groupinvites_count += $grouppendingrequests_count;
	if ($grouppendingrequests_count > 0) {
		if (!empty($groupinvites_text)) { $groupinvites_text .= ', '; }
		$groupinvites_text .= elgg_echo("theme_inria:grouprequests:unreadcount", array($grouppendingrequests_count));
		$groupinvites_content .= '<hr />';
		//$groupinvites_content .= '<h3>' . "Demandes d'adhésion dans vos groupes" . '</h3>';
		foreach($grouppendingrequests as $group) {
			//if (!$group->canEdit()) { continue; }
			//$groupinvites_content .= elgg_view_entity($group, array('full_view' => false));
			//$groupinvites_content .= '<div class=""><img src="' . $group->getIconURL(array('size' => 'small')) . '" /></div>';
			$groupinvite_content = '';
			/* Is it really useful to have a precise count here ? */
			/*
			$count = elgg_get_entities_from_relationship(array(
				'type' => 'user', 'relationship' => 'membership_request', 'relationship_guid' => $group->guid, 'inverse_relationship' => true,
				'count' => true,
			));
			$requests = elgg_get_entities_from_relationship(array('type' => 'user', 'relationship' => 'membership_request', 'relationship_guid' => $group->guid, 'inverse_relationship' => true));
			$groupinvite_content = elgg_echo('groups:membershiprequests:pending', array($count));
			*/
			$groupinvite_content = '<h4>' . $group->name . '</h4>';
			$groupinvite_content .= elgg_echo('theme_inria:membershiprequests:examine');
			$groupinvites_content .= '<a href="' . elgg_get_site_url() . 'groups/requests/' . $group->guid . '">' . elgg_view_image_block('<img src="' . $group->getIconURL(array('size' => 'small')) . '" />', $groupinvite_content, array('class' => "notifications-pending-groups-requests")) . '</a>';
		}
	}
	if ($groupinvites_count > 0) {
		$groupinvites_mark .= '<span class="iris-new" title="' . $groupinvites_text . '">' . $groupinvites_count . '</span>';
		
		$notifications_count += $groupinvites_count;
		if (!empty($notifications_text)) { $notifications_text .= ', '; }
		$notifications_text .= $groupinvites_text;
	}
	
	
	// Login_as menu link
	if (elgg_is_active_plugin('login_as')) {
		$session = elgg_get_session();
		$original_user_guid = $session->get('login_as_original_user_guid');
		if ($original_user_guid) {
			$original_user = get_entity($original_user_guid);
			$loginas_title = elgg_echo('login_as:return_to_user', array($ownusername, $original_user->username));
			$loginas_html = elgg_view('login_as/topbar_return', array('user_guid' => $original_user_guid));
			$loginas_logout = '<div id="logout" class="iris-topbar-item">' . elgg_view('output/url', array('href' => $url . "action/logout_as", 'text' => $loginas_html, 'is_action' => true, 'name' => 'login_as_return', 'title' => $loginas_title, 'class' => 'login-as-topbar')) . '</div>';
		}
	}
	
	// @TODO : demandes en attente dans les groupes dont l'user est admin ou co-admin
	// @TODO : comptes à valider en attente
	// @TODO : autres indicateurs d'actions admin ?
}

if (elgg_is_active_plugin('language_selector')) {
	$language_selector = elgg_view('language_selector/default');
}
?>

<div class="iris-logo">
	<h1>
		<a href="<?php echo $url; ?>" title="<?php echo elgg_echo('esope:gotohomepage'); ?>">
			<img src="<?php echo $urlimg; ?>logo-iris.png" alt="Réseau Iris" />
		</a>
	</h1>
</div>

<div class="iris-topbar-menu">
	
	<div class="menu-navigation-toggle" title="<?php echo elgg_echo('esope:menu:navigation'); ?>"><i class="fa fa-bars"></i></div>
	
	<?php
	if (elgg_is_active_plugin('search') && !elgg_in_context('search')) {
		$search_text = elgg_echo('esope:search:defaulttext');
		// Select search type (filter)
		//$search_opt = array('' => elgg_echo('all'), 'object' => elgg_echo('item:object'), 'group' => elgg_echo('item:group'), 'user' => elgg_echo('item:user')); // options_values
		$search_opt = array(elgg_echo('all') => '', elgg_echo('item:object') => 'object', elgg_echo('item:group') => 'group', elgg_echo('item:user') => 'user'); // options
		$search_opt = array(elgg_echo('all') => '', elgg_echo('item:object:icon') => 'object', elgg_echo('item:user:icon') => 'user', elgg_echo('item:group:icon') => 'group'); // options
		$search_entity_type = get_input('entity_type', '');
		echo '<form action="' . $url . 'search" method="get" id="iris-topbar-search" class="iris-topbar-item">';
			echo '<button type="submit" id="iris-topbar-search-submit" title="' . elgg_echo('esope:search') . '">
				<svg id="iris-search-small" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.49 16.49"><path d="M17.68,16.26l-3.59-3.59A7,7,0,0,0,3.54,3.54a7,7,0,0,0,9.14,10.55l3.59,3.59a1,1,0,0,0,1.41-1.41ZM8.49,13.49A5,5,0,1,1,12,12,5,5,0,0,1,8.49,13.49Z" transform="translate(-1.49 -1.49)"/></svg>
			</button>';
echo '<label for="iris-topbar-search-input" class="invisible">' . $search_text . '</label>';
			echo elgg_view('input/text', array('name' => 'q', 'id' => 'iris-topbar-search-input', 'value' => $prev_q, 'placeholder' => $search_text));
			//echo '<noscript><input type="image" id="iris-topbar-search-submit" src="' . $urlicon . 'recherche.png" value="' . elgg_echo('esope:search') . '" /></noscript>';
		echo '</form>';
	} else {
		echo '<div id="iris-topbar-search"></div>';
	}
	
	// TOPBAR MENU : personal tools and administration
	if (elgg_is_logged_in()) {
		?>
		<div id="msg" class="iris-topbar-item">
			<a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>" title="<?php echo elgg_echo('messages'); ?>"><i class="fa fa-envelope-o"></i><?php echo $messages_mark; ?></a>
		</div>
		
		<div id="notifications" class="iris-topbar-item">
			<?php /* <a href="<?php echo $url . 'site_notifications/view/' . $ownusername; ?>" title="<?php echo elgg_echo('site_notifications:topbar'); ?>"><i class="fa fa-bell-o"></i><?php echo $notifications_mark; ?></a> */ ?>
			<a href="javascript: void(0);" onClick="javascript: $('#notifications .notifications-panel').toggleClass('hidden')" title="<?php echo elgg_echo('site_notifications:topbar'); ?>"><i class="fa fa-bell-o"></i><?php echo $notifications_mark; ?></a>
			<div class="notifications-panel hidden">
				<div class="tabs">
					<?php
					$tab = 'site'; // friends | groups
					$class = ''; if ($tab == 'site') { $class = 'elgg-state-selected'; }
					echo elgg_view('output/url', array(
							'text' => 'Notifications'.$site_notifications_mark, 
							'href' => '#iris-topbar-notifications-site',
							'class' => $class
						));
					$class = ''; if ($tab == 'groups') { $class = 'elgg-state-selected'; }
					echo elgg_view('output/url', array(
							'text' => 'Demandes de contact'.$friendrequests_mark, 
							'href' => '#iris-topbar-notifications-friends',
							'class' => $class
						));
					$class = ''; if ($tab == 'friends') { $class = 'elgg-state-selected'; }
					echo elgg_view('output/url', array(
							'text' => 'Invitations aux groupes'.$groupinvites_mark, 
							'href' => '#iris-topbar-notifications-groups',
							'class' => $class
						));
					?>
				</div>
				
				<?php
				if (($tab == 'site')) {
					echo '<div id="iris-topbar-notifications-site" class="iris-topbar-notifications-tab">';
				} else {
					echo '<div id="iris-topbar-notifications-site" class="iris-topbar-notifications-tab hidden">';
				}
				echo '<div class="iris-topbar-notifications-tab-content">' . $site_notifications_content . '</div>';
				echo '<p style="text-align: center;"><a href="' . elgg_get_site_url() . 'site_notifications" class="view-all">' . elgg_echo('theme_inria:viewall') . '</a></p>';
				echo '</div>';
				
				if (($tab == 'friends')) {
					echo '<div id="iris-topbar-notifications-friends" class="iris-topbar-notifications-tab">';
				} else {
					echo '<div id="iris-topbar-notifications-friends" class="iris-topbar-notifications-tab hidden">';
				}
				echo '<div class="iris-topbar-notifications-tab-content">' . $friendrequests_content . '</div>';
				echo '</div>';
				
				if (($tab == 'groups')) {
					echo '<div id="iris-topbar-notifications-groups" class="hidden iris-topbar-notifications-tab">';
				} else {
					echo '<div id="iris-topbar-notifications-groups" class="iris-topbar-notifications-tab hidden">';
				}
				echo '<div class="iris-topbar-notifications-tab-content">' . $groupinvites_content . '</div>';
				echo '</div>';
				?>
			</div>
		</div>
			
		<?php if ($loginas_logout) { echo $loginas_logout; } ?>
		
		<?php /*
		<div class="menu-topbar-toggle" class="iris-topbar-item"><i class="fa fa-user"></i> <?php echo elgg_echo('esope:menu:topbar'); ?></div>
		*/ ?>
		<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt iris-topbar-item" id="menu-topbar">
			<li id="user"><a href="javascript:void(0);" onClick="javascript: $('#user .user-panel').toggleClass('hidden')" class="elgg-avatar elgg-avatar-small profile-type-<?php echo $profile_type; ?>"><img src="<?php echo $own->getIconURL('small'); ?>" alt="<?php echo $own->name; ?>" />&nbsp;<?php echo $own->name; ?> <i class="fa fa-angle-down"></i></a>
				<ul class="user-panel hidden">
					<li><a href="<?php echo $url . 'profile/' . $ownusername; ?>"><?php echo $svg_profile . elgg_echo('theme_inria:topbar:profil'); ?></a>
					<li id="usersettings"><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>" title="<?php echo elgg_echo('theme_inria:usersettings:tooltip'); ?>"><?php echo $svg_settings . elgg_echo('esope:usersettings'); ?></a></li>
					<?php if (elgg_is_admin_logged_in()) { ?>
						<li id="admin"><a href="<?php echo $url . 'admin/dashboard/'; ?>"><?php echo $svg_admin . elgg_echo('admin'); ?></a></li>
					<?php } ?>
					<li><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => $svg_logout . elgg_echo('logout'), 'is_action' => true)); ?></li>
				</ul>
			</li>
		</ul>
		
		<?php
	} else {
		// Bouton de connexion partout sauf sur la home
		if (current_page_url() != $url) {
			echo '<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt">';
				echo '<li><i class="fa fa-sign-in"></i><a href="' . $url . '">' . elgg_echo('theme_inria:login') . '</a></li>';
				if ($language_selector) {
					echo '<li class="language-selector">' . $language_selector . '</li>';
				}
			echo '</ul>';
		}
	}
	?>
</div>

<?php
elgg_pop_context();


