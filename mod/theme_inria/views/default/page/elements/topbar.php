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
$prev_q = get_input('q', '');

$lang = get_language();

if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	
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
?>

<div class="is-not-floatable">
	<h1>
		<a href="<?php echo $url; ?>" title="<?php echo elgg_echo('esope:gotohomepage'); ?>">
			<img src="<?php echo $urlimg; ?>logo-iris.png" alt="Réseau Iris" />
		</a>
	</h1>
	<img src="<?php echo $urlimg; ?>bulles-header.png" />
	<?php
	// TOPBAR MENU : personal tools and administration
	if (elgg_is_logged_in()) {
		?>
		<div class="menu-topbar-toggle"><i class="fa fa-user"></i> <?php echo elgg_echo('esope:menu:topbar'); ?></div>
		<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt" id="menu-topbar">
				<li id="user"><a href="<?php echo $url . 'profile/' . $ownusername; ?>"><img src="<?php echo $own->getIconURL('topbar'); ?>" alt="<?php echo $own->name; ?>" /> <?php echo $own->name; ?></a></li>
				<?php if ($loginas_logout) { echo $loginas_logout; } ?>
				<li id="msg">
					<a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>" title="<?php echo elgg_echo('theme_inria:messages:tooltip'); ?>"><i class="fa fa-envelope-o mail outline icon"></i><?php echo elgg_echo('messages'); ?></a>
					<?php if ($new_messages_counter) { echo $new_messages_counter; } ?>
				</li>
				<li id="notifications">
					<a href="<?php echo $url . 'site_notifications/view/' . $ownusername; ?>"><i class="fa fa-info-circle"></i><?php echo elgg_echo('site_notifications:topbar'); /* echo elgg_view_icon('info') . elgg_echo('site_notifications:topbar'); */ ?></a>
					<?php if ($new_notifications_counter) { echo $new_notifications_counter; } ?>
				</li>
				<li id="usersettings"><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>" title="<?php echo elgg_echo('theme_inria:usersettings:tooltip'); ?>"><i class="fa fa-cog setting icon"></i><?php echo elgg_echo('esope:usersettings'); ?></a></li>
				<?php if (elgg_is_admin_logged_in()) { ?>
					<li id="admin"><a href="<?php echo $url . 'admin/dashboard/'; ?>"><i class="fa fa-cogs settings icon"></i><?php echo elgg_echo('admin'); ?></a></li>
				<?php } ?>
				<li><a href="<?php echo $url . 'groups/profile/8551/aide'; ?>"><i class="fa fa-question-circle help icon"></i><?php echo elgg_echo('esope:help'); ?></a></li>
				<li><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => '<i class="fa fa-power-off power-off icon"></i>' . elgg_echo('logout'), 'is_action' => true)); ?></li>
			</ul>
		<?php
	} else {
		// Bouton de connexion partout sauf sur la home
		if (current_page_url() != $url) {
			echo '<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt">';
				echo '<li><i class="fa fa-sign-in sign in icon"></i><a href="' . $url . '">' . elgg_echo('theme_inria:login') . '</a></li>';
				if ($language_selector) {
					echo '<li class="language-selector">' . $language_selector . '</li>';
				}
			echo '</ul>';
		}
	}
	?>
	
	<div class="clearfloat"></div>

</div>

