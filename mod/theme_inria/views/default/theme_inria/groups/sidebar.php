<?php

$group = elgg_get_page_owner_entity();
// Determine main group
$main_group = theme_inria_get_main_group($group);
// Sidebar is always main group ?
//$group = $main_group;

$own = elgg_get_logged_in_user_entity();
$url = elgg_get_site_url();

$translation_prefix = '';
$is_main_group = true;
if ($group->guid != $main_group->guid) {
	$is_main_group = false;
	$translation_prefix = 'workspace:';
}

$content = '';

// Back button : back to main group, or current workspace
if (current_page_url() != $group->getURL()) {
	if ($is_main_group) {
		$content .= '<div class="iris-sidebar-content iris-back"><a href="' . $group->getURL() . '"><i class="fa fa-angle-left"></i> &nbsp; ' . elgg_echo('theme_inria:group:back') . '</a></div>';
	} else {
		$content .= '<div class="iris-sidebar-content iris-back"><a href="' . $url . 'groups/workspace/' . $group->guid . '"><i class="fa fa-angle-left"></i> &nbsp; ' . elgg_echo('workspace:back') . '</a></div>';
	}
}

// Actual sidebar

$content .= '<div class="iris-sidebar-content">';


	//$content .= '<h2 class="hidden">' . elgg_echo('accessibility:sidebar:title') . '</h2>';
	$content .= '<h2>' . elgg_echo($translation_prefix . 'groups:settings') . '</h2>';

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

	// Members settings
	if ($group->isMember() && !elgg_in_context('group_edit') && !elgg_in_context('group_members')&& !elgg_in_context('group_invites')) {
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
	
			// Direct group email notifications subscription
			$content .= '<form action="' . $url . 'action/theme_inria/group_notification">';
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
			$content .= '</form>';
			// Notification settings : notifications/group/$username
	
			// Direct newsletter subscription
			//if ($group->newsletter_enable == 'yes') {
			if (elgg_is_active_plugin('newsletter') && newsletter_is_group_enabled($group)) {
				$content .= '<li>' . elgg_view('theme_inria/groups/subscribe_newsletter', array('entity' => $group)) . '</li>';
			}
	
		$content .= '</ul>';
	}

	$content .= '<div class="clearfloat"></div>';
$content .= '</div>';


echo '<div class="elgg-sidebar iris-group-sidebar">
		<div class="menu-sidebar-toggle hidden" style=""><i class="fa fa-th-large"></i> ' . elgg_echo('hide') . ' ' . elgg_echo('esope:menu:sidebar') . '</div>
		' . $content . '
	</div>';


