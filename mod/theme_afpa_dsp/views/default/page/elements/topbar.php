<?php
/* ESOPE topbar (override)
 * In ESOPE, the topbar is part of the header
 * See page/elements/header view for header and main navigation content
 * 
 * The topbar menu is defined and customized here
 */

$url = elgg_get_site_url();
$urlicon = $url . 'mod/esope/img/theme/';

$site = elgg_get_site_entity();
$title = $site->name;
$prev_q = get_input('q', '');


/* Use custom menus from theme settings
 * Accepted values :
 * empty => use hardcoded theme menu (below)
 * 'none' => do not display menu
 * any other value => display corresponding menu (using translations if available)
 * 
 * Test to display menu : $menu => false = do not use menu | 'none' = empty menu | $name = display menu $name
 * if ($menu && ($menu != 'none')) { echo $topbar_menu; }
 */
$topbar_menu = false;
$topbar_menu_public = false;
if (elgg_is_active_plugin('elgg_menus')) {
	$lang = get_language();
	// Main topbar menu
	$menu = elgg_get_plugin_setting('menu_topbar', 'esope');
	if (empty($menu)) {
		$menu = false;
	} else {
		if ($menu != 'none') {
			// Get translated menu, if exists
			$lang_menu = elgg_menus_get_menu_config($menu . '-' . $lang);
			if ($lang_menu) { $menu = $menu . '-' . $lang; }
			// Compute menu
			$topbar_menu = elgg_view_menu($menu, array('sort_by' => 'priority', 'class' => 'elgg-menu elgg-menu-topbar elgg-menu-topbar-alt elgg-menu-hz', 'id' => 'menu-topbar'));
		}
	}
	// Public menu
	$menu_public = elgg_get_plugin_setting('menu_topbar_public', 'esope');
	if (empty($menu_public)) {
		$menu_public = false;
	} else {
		if ($menu_public != 'none') {
			// Get translated menu, if exists
			$lang_menu = elgg_menus_get_menu_config($menu_public . '-' . $lang);
			if ($lang_menu) { $menu_public = $menu_public . '-' . $lang; }
			// Compute menu
			$topbar_menu_public = elgg_view_menu($menu_public, array('sort_by' => 'priority', 'class' => 'elgg-menu elgg-menu-topbar elgg-menu-topbar-alt elgg-menu-hz', 'id' => 'menu-topbar'));
		}
	}
}


// Compute only if it will be displayed...
if (elgg_is_logged_in() && !$menu) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	
	// Demandes de contact en attente : affiché seulement s'il y a des demandes en attente
	$friendrequests_options = array("type" => "user", "count" => true, "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true);
	$friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
	if ($friendrequests_count == 1) {
		$friendrequests = '<a class="elgg-menu-counter" href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvite') . '">' . $friendrequests_count . '</a>';
	} else if ($friendrequests_count > 1) {
		$friendrequests = '<a class="elgg-menu-counter" href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvites') . '">' . $friendrequests_count . '</a>';
	}
	
	// Messages non lus
	if (elgg_is_active_plugin('messages')) {
		$num_messages = (int)messages_count_unread();
		if ($num_messages != 0) {
			$text = "$num_messages";
			$tooltip = elgg_echo("messages:unreadcount", array($num_messages));
			$new_messages_counter = '<a class="elgg-menu-counter" href="' . $url . 'messages/inbox/' . $ownusername . '" title="' . $tooltip . '">' . $text . '</a>';
		}
	}
	if (elgg_is_active_plugin('site_notifications')) {
		$site_notifications_count = elgg_get_entities_from_metadata(array(
					'type' => 'object',
					'subtype' => 'site_notification',
					'owner_guid' => $own->guid,
					'metadata_name' => 'read',
					'metadata_value' => false,
					'count' => true,
				));
		$tooltip = '';
		$text = "$site_notifications_count";
		$new_notifications_counter = '<a class="elgg-menu-counter" href="' . $url . 'site_notifications/view/' . $ownusername . '" title="' . $tooltip . '">' . $text . '</a>';
	}
	
	// Login_as menu link
	if (elgg_is_active_plugin('login_as')) {
		$session = elgg_get_session();
		$original_user_guid = $session->get('login_as_original_user_guid');
		if ($original_user_guid) {
			/*
			$title = elgg_echo('login_as:return_to_user', array(
				elgg_get_logged_in_user_entity()->username,
				get_entity($original_user_guid)->username
			));

			$html = elgg_view('login_as/topbar_return', array('user_guid' => $original_user_guid));
			elgg_register_menu_item('topbar', array(
				'name' => 'login_as_return',
				'text' => $html,
				'href' => 'action/logout_as',
				'is_action' => true,
				'title' => $title,
				'link_class' => 'login-as-topbar',
				'priority' => 700,
			));
			*/
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



// Display topbar
echo '<div class="is-not-floatable">';
	
	// TOPBAR LOGGED IN MENU : personal tools and administration
	if (elgg_is_logged_in()) {
		// Use custom menu, or theme menu
		if ($menu) {
			if ($menu != 'none') {
				echo '<div class="menu-topbar-toggle"><i class="fa fa-user fa-menu"></i> ' . elgg_echo('esope:menu:topbar') . '</div>';
				echo $topbar_menu;
				echo '<div class="clearfloat"></div>';
			}
		} else {
			echo '<div class="menu-topbar-toggle"><i class="fa fa-user fa-menu"></i> ' . elgg_echo('esope:menu:topbar') . '</div>';
			?>
			<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt" id="menu-topbar">
				<li><a href="<?php echo $url . 'profile/' . $ownusername; ?>" id="esope-profil"><img src="<?php echo $own->getIconURL('topbar'); ?>" alt="<?php echo $own->name; ?>" /> <?php echo $own->name; ?></a></li>
				<?php if (elgg_is_active_plugin('messages')) { ?>
				<li id="msg">
					<a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>"><i class="fa fa-envelope-o mail outline icon"></i><?php /* echo elgg_echo('messages'); */ ?></a>
					<?php if ($new_messages_counter) { echo $new_messages_counter; } ?>
				</li>
				<li id="notifications">
					<a href="<?php echo $url . 'site_notifications/view/' . $ownusername; ?>"><i class="fa fa-info-circle"></i><?php /* echo elgg_view_icon('info') . elgg_echo('site_notifications:topbar'); */ ?></a>
					<?php if ($new_notifications_counter) { echo $new_notifications_counter; } ?>
				</li>
				<?php } ?>
				<li id="man">
					<a href="<?php echo $url . 'friends/' . $ownusername; ?>"><?php echo elgg_echo('friends'); ?></a>
					<?php echo $friendrequests; ?>
				</li>
				<li id="usersettings"><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>"><i class="fa fa-cog setting icon"></i><?php echo elgg_echo('esope:usersettings'); ?></a></li>
						<!--
				<li><?php echo elgg_echo('esope:myprofile'); ?></a>
						<li><a href="<?php echo $url . 'profile/' . $ownusername . '/edit'; ?>">Compléter mon profil</a></li>
						<li><a href="<?php echo $url . 'avatar/edit/' . $ownusername . '/edit'; ?>">Changer la photo du profil</a></li>
				</li>
						//-->
				<?php if (elgg_is_admin_logged_in()) { ?>
					<li id="admin"><a href="<?php echo $url . 'admin/dashboard/'; ?>"><i class="fa fa-cogs settings icon"></i><?php echo elgg_echo('admin'); ?></a></li>
				<?php } ?>
			
				<?php
				$helplink = elgg_get_plugin_setting('helplink', 'esope');
				//if (empty($helplink)) $helplink = 'pages/view/182/premiers-pas';
				if (!empty($helplink)) echo '<li id="help"><a href="' . $url . $helplink . '"><i class="fa fa-question help icon"></i>' . elgg_echo('esope:help') . '</a></li>';
				?>
				<?php if ($loginas_logout) { echo $loginas_logout; } ?>
				<li id="logout"><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => '<i class="fa fa-sign-out sign out icon"></i>' . elgg_echo('logout'), 'is_action' => true)); ?></li>
				<?php
				if ($language_selector) {
					echo '<li class="language-selector">' . $language_selector . '</li>';
				}
				?>
			</ul>
			<?php
			echo '<div class="clearfloat"></div>';
		}
		
	// TOPBAR PUBLIC MENU
	} else {
		if ($menu_public) {
			if ($menu_public != 'none') {
				echo '<div class="menu-topbar-toggle"><i class="fa fa-user fa-menu"></i> ' . elgg_echo('esope:menu:topbar') . '</div>';
				echo $topbar_menu_public;
				echo '<div class="clearfloat"></div>';
			}
		} else {
			// @TODO use drop-down login without the button UI (or re-designed)
			//echo elgg_view('core/account/login_dropdown');
			echo '<div class="menu-topbar-toggle"><i class="fa fa-user fa-menu"></i> ' . elgg_echo('esope:menu:topbar') . '</div>';
			echo '<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt" id="menu-topbar">';
				echo '<li><a href="' . $url . '"><i class="fa fa-sign-in sign in icon"></i>' . elgg_echo('esope:loginregister') . '</a></li>';
				if ($language_selector) {
					echo '<li class="language-selector">' . $language_selector . '</li>';
				}
			echo '</ul>';
			echo '<div class="clearfloat"></div>';
		}
	}
	?>
	
	<h1>
		<a href="<?php echo $url; ?>" title="<?php echo elgg_echo('esope:gotohomepage'); ?>">
			<?php echo elgg_get_plugin_setting('headertitle', 'esope'); ?>
		</a>
	</h1>
	
</div>

