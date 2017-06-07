<?php

$group = elgg_get_page_owner_entity();
// Determine main group
$main_group = theme_inria_get_main_group($group);


$url = elgg_get_site_url();

$content = '';

// Back button
if (current_page_url() != $group->getURL()) {
	$content .= '<div class="iris-sidebar-content iris-back"><a href="' . $group->getURL() . '"><i class="fa fa-angle-left"></i> &nbsp; ' . elgg_echo('theme_inria:group:back') . '</a></div>';
}

// Actual sidebar

$content .= '<div class="iris-sidebar-content">';
//$content .= '<h2 class="hidden">' . elgg_echo('accessibility:sidebar:title') . '</h2>';
$content .= '<h2>' . elgg_echo('settings') . '</h2>';

$content .= '<ul class="elgg-menu elgg-menu-page">';
	if (current_page_url() == $url.'groups/invite/' . $group->guid) { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
	$content .= '<a href="' . $url . 'groups/invite/' . $group->guid . '"><i class="fa fa-user-plus"></i>&nbsp;' . elgg_echo('groups:invite') . ' &nbsp; <i class="fa fa-angle-right"></i></a></li>';
	
	if (current_page_url() == $url.'groups/members/' . $group->guid)  { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
	$content .= '<a href="' . $url . 'groups/members/' . $group->guid . '"><i class="fa fa-user"></i>&nbsp;' . elgg_echo('groups:members:manage') . ' &nbsp; <i class="fa fa-angle-right"></i></a></li>';
	
	if (current_page_url() == $url.'groups/edit/' . $group->guid)  { $content .= '<li class="elgg-state-selected">'; } else { $content .= '<li>'; }
	$content .= '<a href="' . $url . 'groups/edit/' . $group->guid . '"><i class="fa fa-pencil"></i>&nbsp;' . elgg_echo('groups:edit') . ' &nbsp; <i class="fa fa-angle-right"></i></a></li>';
	
$content .= '</ul>';

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
	
	// @TODO handle new form for direct group email notifications
	// @TODO Alternative : 1 checkbox per available method
	$content .= '<li>' . elgg_view('input/checkbox', array(
			'name' => '', 
			'value' => 'yes', 
			'checked' => $email_notification, 
			'label' => 'Etre notifé par email',
		)) . '</li>';
	// Notification settings : notifications/group/$username
	
	// @TODO if newsletter enabled
	$content .= '<li>' . elgg_view('input/checkbox', array(
			'name' => '', 
			'value' => 'yes', 
			'label' => "S'abonner à la lettre d'info"
		)) . '</li>';
	
$content .= '</ul>';

$content .= '<div class="clearfloat"></div>';
$content .= '</div>';


echo '<div class="menu-sidebar-toggle"><i class="fa fa-th-large"></i> ' . elgg_echo('esope:menu:sidebar') . '</div>
	<div class="elgg-sidebar iris-group-sidebar">
		' . $content . '
	</div>';


