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

if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	
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
	$notifications_mark = '';
	$notifications_text = '';
	$notifications_count = '';
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
	
	// Group invites
	$groupinvites_options = array();
	// Own invites
	//$groupinvites_count = groups_get_invited_groups($own->guid, false, array('count' => true));
	//$groupinvites = esope_groups_get_invited_groups($own->guid);
	$groupinvites_count = esope_groups_get_invited_groups($own->guid, false, array('count' => true));
	$groupinvites_content = '';
	if ($groupinvites_count > 0) {
		$groupinvites_text .= elgg_echo("theme_inria:groupinvites:unreadcount", array($groupinvites_count));
		$groupinvites_mark .= '<span class="iris-new" title="' . $groupinvites_text . '">' . $groupinvites_count . '</span>';
	}
	//$groupinvites_content .= elgg_view('groups/invitationrequests', array('invitations' => $groupinvites));
	$groupinvites_content .= elgg_view('groups/invitationrequests');
	// Admin group membership requests (groups where user can validate requests as operator)
	$grouprequests = esope_groups_get_pending_membership_requests($own->guid);
	$grouprequests_count = count($grouprequests);
	$groupinvites_count += $grouprequests_count;
	if ($grouprequests_count > 0) {
		if (!empty($groupinvites_text)) { $groupinvites_text .= ', '; }
		$groupinvites_text .= elgg_echo("theme_inria:grouprequests:unreadcount", array($grouprequests_count));
		//$groupinvites_content .= '<h3>' . "Demandes d'adhésion dans vos groupes" . '</h3>';
		$groupinvites_content .= '<hr />';
		foreach($grouprequests as $group) {
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
	
	
	// Friend requests - Demandes de contact en attente
	$friendrequests_options = array("type" => "user", "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true, "count" => true);
	$friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
	$friendrequests_content = '';
	if ($friendrequests_count > 0) {
		$friendrequests_text .= elgg_echo("theme_inria:friendrequests:unreadcount", array($friendrequests_count));
		$friendrequests_mark .= '<span class="iris-new" title="' . $friendrequests_text . '">' . $friendrequests_count . '</span>';
		
		$notifications_count += $friendrequests_count;
		if (!empty($notifications_text)) { $notifications_text .= ', '; }
		$notifications_text .= $friendrequests_text;
	}
	$friendrequests_content .= elgg_view('friend_request/sent', $vars) . elgg_view('friend_request/received', $vars);
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
	
	
	// Login_as menu link
	if (elgg_is_active_plugin('login_as')) {
		$session = elgg_get_session();
		$original_user_guid = $session->get('login_as_original_user_guid');
		if ($original_user_guid) {
			$original_user = get_entity($original_user_guid);
			$loginas_title = elgg_echo('login_as:return_to_user', array($ownusername, $original_user->username));
			$loginas_html = elgg_view('login_as/topbar_return', array('user_guid' => $original_user_guid));
			$loginas_logout = '<li id="logout">' . elgg_view('output/url', array('href' => $url . "action/logout_as", 'text' => $loginas_html, 'is_action' => true, 'name' => 'login_as_return', 'title' => $loginas_title, 'class' => 'login-as-topbar')) . '</li>';
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
	<?php
	if (elgg_is_active_plugin('search') && !elgg_in_context('search')) {
		$search_text = elgg_echo('esope:search:defaulttext');
		// Select search type (filter)
		//$search_opt = array('' => elgg_echo('all'), 'object' => elgg_echo('item:object'), 'group' => elgg_echo('item:group'), 'user' => elgg_echo('item:user')); // options_values
		$search_opt = array(elgg_echo('all') => '', elgg_echo('item:object') => 'object', elgg_echo('item:group') => 'group', elgg_echo('item:user') => 'user'); // options
		$search_opt = array(elgg_echo('all') => '', elgg_echo('item:object:icon') => 'object', elgg_echo('item:user:icon') => 'user', elgg_echo('item:group:icon') => 'group'); // options
		$search_entity_type = get_input('entity_type', '');
		echo '<form action="' . $url . 'search" method="get" id="iris-topbar-search" class="iris-topbar-item">';
			echo '<button type="submit" id="iris-topbar-search-submit" title="' . elgg_echo('esope:search') . '"><i class="fa fa-search"></i></button>';
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
			<a href="<?php echo $url . 'site_notifications/view/' . $ownusername; ?>" title="<?php echo elgg_echo('site_notifications:topbar'); ?>"><i class="fa fa-bell-o"></i><?php echo $notifications_mark; ?></a>
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
		
		<div class="menu-topbar-toggle" class="iris-topbar-item"><i class="fa fa-user"></i> <?php echo elgg_echo('esope:menu:topbar'); ?></div>
		<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt iris-topbar-item" id="menu-topbar">
			<li id="user"><a href="javascript:void(0);"><img src="<?php echo $own->getIconURL('small'); ?>" alt="<?php echo $own->name; ?>" />&nbsp;<?php echo $own->name; ?> <i class="fa fa-angle-down"></i></a>
				<ul class="hidden">
					<li><a href="<?php echo $url . 'profile/' . $ownusername; ?>"><i class="fa fa-user-o"></i>&nbsp;<?php echo elgg_echo('theme_inria:topbar:profil'); ?></a>
					<li id="usersettings"><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>" title="<?php echo elgg_echo('theme_inria:usersettings:tooltip'); ?>"><i class="fa fa-cog"></i>&nbsp;<?php echo elgg_echo('esope:usersettings'); ?></a></li>
					<?php if (elgg_is_admin_logged_in()) { ?>
						<li id="admin"><a href="<?php echo $url . 'admin/dashboard/'; ?>"><i class="fa fa-cogs"></i>&nbsp;<?php echo elgg_echo('admin'); ?></a></li>
					<?php } ?>
					<li><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => '<i class="fa fa-sign-out"></i>&nbsp;' . elgg_echo('logout'), 'is_action' => true)); ?></li>
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


