<?php

$group = elgg_get_page_owner_entity();

$own = elgg_get_logged_in_user_entity();
$url = elgg_get_site_url();

$translation_prefix = 'workspace:';


$content = '';

//$content .= '<h2 class="hidden">' . elgg_echo('accessibility:sidebar:title') . '</h2>';
$content .= '<h3>' . elgg_echo($translation_prefix . 'groups:settings') . '</h3>';

$content .= '<ul class="elgg-menu elgg-menu-page">';
	if ($group->canEdit()) {
		if (current_page_url() == $url.'groups/invite/' . $group->guid) { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
		$content .= '<a href="' . $url . 'groups/invite/' . $group->guid . '"><i class="fa fa-user-plus"></i>&nbsp;' . elgg_echo($translation_prefix . 'groups:invite') . ' &nbsp; <i class="fa fa-angle-right"></i></a></li>';
	}

	if (current_page_url() == $url.'groups/members/' . $group->guid)  { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
	if ($group->canEdit()) {
		$content .= '<a href="' . $url . 'groups/members/' . $group->guid . '"><i class="fa fa-user"></i>&nbsp;' . elgg_echo($translation_prefix . 'groups:members:manage') . ' &nbsp; <i class="fa fa-angle-right"></i></a></li>';
	} else {
		$content .= '<a href="' . $url . 'groups/members/' . $group->guid . '"><i class="fa fa-user"></i>&nbsp;' . elgg_echo($translation_prefix . 'groups:members') . ' &nbsp; <i class="fa fa-angle-right"></i></a></li>';
	}

	if ($group->canEdit()) {
		if (current_page_url() == $url.'groups/edit/' . $group->guid)  { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
		$content .= '<a href="' . $url . 'groups/edit/' . $group->guid . '"><i class="fa fa-pencil"></i>&nbsp;' . elgg_echo($translation_prefix . 'groups:edit') . ' &nbsp; <i class="fa fa-angle-right"></i></a></li>';
	}
$content .= '</ul>';


// Membership action (for self)
$actions_content = '';
// group members
if ($group->isMember($own)) {
	if ($group->getOwnerGUID() != $own->guid) {
		// leave
		$actions_content .= elgg_view('output/url', array(
				'href' => $url . "action/groups/leave?group_guid={$group->guid}",
				'text' => '<i class="fa fa-sign-out"></i>&nbsp;' . elgg_echo('workspace:groups:leave'),
				'class' => "elgg-button elgg-button-delete",
				'confirm' => elgg_echo('workspace:groups:leave:confirm'),
				'is_action' => true,
			));
	}
} else {
	// join - admins can always join.
	if ($group->isPublicMembership() || $group->canEdit()) {
		$actions_content .= elgg_view('output/url', array(
				'href' => $url . "action/groups/join?group_guid={$group->guid}",
				'text' => '<i class="fa fa-sign-in"></i>&nbsp;' . elgg_echo('workspace:groups:join'),
				'class' => "elgg-button elgg-button-action",
				'is_action' => true,
			));
	} else {
		// request membership
		$actions_content .= elgg_view('output/url', array(
				'href' => $url . "action/groups/join?group_guid={$group->guid}",
				'text' => '<i class="fa fa-sign-in"></i>&nbsp;' . elgg_echo('workspace:groups:joinrequest'),
				'class' => "elgg-button elgg-button-action",
				'is_action' => true,
			));
	}
}
if (!empty($actions_content)) {
	$content .= '<div class="group-workspace-sidebar-membership"><h3>' . elgg_echo('workspace:theme_inria:ownmembership') . '</h3>' . $actions_content . '</div>';
}


// Members settings
if (!elgg_in_context('group_edit') && !elgg_in_context('group_members')&& !elgg_in_context('group_invites')) {
	$content .= '<ul class="elgg-menu elgg-menu-page">';
		/*
		$subscribed = false;
		if (elgg_is_active_plugin('notifications')) {
			$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethodsAsDeprecatedGlobal();
			foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
				$relationship = check_entity_relationship(elgg_get_logged_in_user_guid(), 'notify' . $method, $guid);
				if ($relationship) {
					$subscribed = true;
					break;
				}
			}
		}
		$email_notification = check_entity_relationship(elgg_get_logged_in_user_guid(), 'notifyemail', $group->guid);
		*/

		if ($group->isMember()) {
			// Direct group email notifications subscription
			$content .= '<li><form action="' . $url . 'action/theme_inria/group_notification">';
			$content .= elgg_view('input/securitytoken');
			//$methods = array('email', 'site');
			$methods = array('email');
			foreach($methods as $method) {
				$checked = '';
				if (check_entity_relationship($own->guid, 'notify' . $method, $group->guid)) { $checked = 'checked="checked"'; }
				//$content .= '<pre>' . print_r($email_notification, true) . '</pre>';
				$method_label = elgg_echo($translation_prefix . 'theme_inria:notification:'.$method);
				$content .= '<p><label><input type="checkbox" name="' . $method . '" value="1" ' . $checked . ' onClick="$(this).closest(\'form\').submit();" />' . $method_label . '</label></p>';
			}
			$content .= elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
			$content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $own->guid));
			$content .= '<noscript>' . elgg_view('input/submit', array('value' => elgg_echo($translation_prefix . 'save:groupnotifications'))) . '</noscript>';
			$content .= '</form></li>';
			// Notification settings : notifications/group/$username

			// Direct newsletter subscription
			//if ($group->newsletter_enable == 'yes') {
			if (elgg_is_active_plugin('newsletter') && newsletter_is_group_enabled($group)) {
				$content .= '<li>' . elgg_view('theme_inria/groups/subscribe_newsletter', array('entity' => $group)) . '</li>';
			}
		}

	$content .= '</ul>';
}

$content .= '<div class="clearfloat"></div>';


echo $content;
//echo '</div><div class="iris-sidebar-content">';

