<?php
/* Esope replaces topbar + header by a single header
 * Header can be broken in 2 searate blocks by breaking out the enclosing div, then re-opening a new one
 * 	<div class="elgg-page-header">
 * 		<div class="elgg-inner">
 * 			$header
 * 		</div>
 * 	</div>
 */


$url = elgg_get_site_url();
$urlicon = $url . 'mod/esope/img/theme/';

$site = elgg_get_site_entity();
$title = $site->name;
$prev_q = get_input('q', '');

if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	// Liste de ses groupes
	$groups = '';
	if (elgg_is_active_plugin('groups')) {
		$options = array( 'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ownguid, 'inverse_relationship' => false, 'limit' => 99, 'order_by' => 'time_created asc');
		// Cas des sous-groupes : listing avec marqueur de sous-groupe
		if (elgg_is_active_plugin('au_subgroups')) {
			// Si les sous-groupes sont activés : listing des sous-groupes sous les groupes, et ordre alpha si demandé
			$display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
			$display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
			$db_prefix = elgg_get_config('dbprefix');
			// Don't list subgroups here (we want to list them under parents, if listed)
			$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
			if ($display_alphabetically != 'no') {
				$options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
				$options['order_by'] = 'ge.name ASC';
			}
	
		}
		$mygroups = elgg_get_entities_from_relationship($options);
		foreach ($mygroups as $group) {
			$groups .= '<li><a href="' . $group->getURL() . '">' 
				. '<img src="' . $group->getIconURL('tiny') . '" alt="' . str_replace('"', "''", $group->name) . ' (' . elgg_echo('esope:groupicon') . '" />' . $group->name . '</a></li>';
			// Si on liste les sous-groupes, on le fait ici si demandé
			if (elgg_is_active_plugin('au_subgroups') && ($display_subgroups == 'yes')) {
				$groups .= esope_list_groups_submenu($group, 1, true, $own);
			}
		}
	// "Invitations" dans les groupes : affiché seulement s'il y a des invitations en attente
		$group_invites = groups_get_invited_groups(elgg_get_logged_in_user_guid());
		$invites_count = sizeof($group_invites);
		if ($invites_count == 1) {
			$invites = '<li class="elgg-menu-counter"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '">' . $invites_count . '</a></li>';
		} else if ($invites_count > 1) {
			$invites = '<li class="elgg-menu-counter"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '">' . $invites_count . '</a></li>';
		}
		// Demandes de contact en attente : affiché seulement s'il y a des demandes en attente
		$friendrequests_options = array("type" => "user", "count" => true, "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true);
		$friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
		if ($friendrequests_count == 1) {
			$friendrequests = '<a class="elgg-menu-counter" href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvite') . '">' . $friendrequests_count . '</a>';
		} else if ($friendrequests_count > 1) {
			$friendrequests = '<a class="elgg-menu-counter" href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvites') . '">' . $friendrequests_count . '</a>';
		}
	}
	
	// Liste des catégories (thématiques du site)
	if (elgg_is_active_plugin('categories')) {
		$categories = '';
		$themes = $site->categories;
		/*
		if ($themes) foreach ($themes as $theme) {
			$categories .= '<li><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme . '</a></li>';
		}
		*/
		if ($themes) {
			sort($themes); // Sort categories
			foreach ($themes as $theme) {
				// Add tree categories support
				$theme_label = $theme;
				if (strpos($theme, '/') !== false) {
					$theme_a = explode('/', $theme);
					$theme_label = '';
					for ($i = 1; $i < count($theme_a); $i++) { $theme_label .= "-"; }
					$theme_label .= ' ' . end($theme_a);
				}
				$categories .= '<li><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme_label . '</a></li>';
			}
		}
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
	
	// Login as menu link
	if (elgg_is_active_plugin('login_as')) {
		$original_user_guid = isset($_SESSION['login_as_original_user_guid']) ? $_SESSION['login_as_original_user_guid'] : NULL;
		if ($original_user_guid) {
			$original_user = get_entity($original_user_guid);
			$loginas_title = elgg_echo('login_as:return_to_user', array($ownusername, $original_user->username));
			$loginas_html = elgg_view('login_as/topbar_return', array('user_guid' => $original_user_guid));
			$loginas_logout = '<li id="logout">' . elgg_view('output/url', array('href' => $url . "action/logout_as", 'text' => $loginas_html, 'is_action' => true, 'name' => 'login_as_return', 'title' => $loginas_title, 'class' => 'login-as-topbar')) . '</li>';
		}
	}
	
}
?>

<div class="is-not-floatable">
	<?php
	// TOPBAR MENU : personal tools and administration
	if (elgg_is_logged_in()) {
		?>
		<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-default">
			<li><a href="<?php echo $url . 'profile/' . $ownusername; ?>" id="esope-profil"><img src="<?php echo $own->getIconURL('topbar'); ?>" alt="<?php echo $own->name; ?>" /> <?php echo $own->name; ?></a></li>
		</ul>
		<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt">
			<li id="msg">
				<a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>"><i class="fa fa-envelope-o mail outline icon"></i><?php echo elgg_echo('messages'); ?></a>
				<?php if ($new_messages_counter) { echo $new_messages_counter; } ?>
			</li>
			<li id="man">
				<a href="<?php echo $url . 'friends/' . $ownusername; ?>"><i class="fa fa-users users icon"></i><?php echo elgg_echo('friends'); ?></a>
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
			
		</ul>
	<?php } else {
		echo '<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt"><li><a href="' . $url . '"><i class="fa fa-sign-in sign in icon"></i>' . elgg_echo('esope:loginregister') . '</a></li></ul>';
	} ?>
	
	<div class="clearfloat"></div>
	<h1>
		<a href="<?php echo $url; ?>" title="<?php echo elgg_echo('esope:gotohomepage'); ?>">
			<?php echo elgg_get_plugin_setting('headertitle', 'esope'); ?>
		</a>
	</h1>
	
</div>


<?php
// MAIN NAVIGATION MENU
if (elgg_is_logged_in()) {
	
	// Close enclosing divs and reopen new ones
	//echo '	</div></div><div id="transverse" class="elgg-page-sitemenu is-not-floatable"><div class="elgg-inner">';
	echo '	</div><div id="transverse" class="elgg-page-sitemenu is-not-floatable"><div class="elgg-inner">';
	
	?>
	<ul class="elgg-menu elgg-menu-navigation elgg-menu-navigation-alt">
		<li class="home"><a href="<?php echo $url; ?>" <?php if ((full_url() == $url) || (full_url() == $url . 'activity')) { echo 'class="active elgg-state-selected"'; } ?> ><?php echo elgg_echo('esope:homepage'); ?></a>
			<?php if (elgg_is_active_plugin('dashboard')) { ?>
				<ul class="hidden">
					<li><a href="<?php echo $url; ?>" ><?php echo elgg_echo('dashboard'); ?></a></li>
					<li><a href="<?php echo $url; ?>activity" ><?php echo elgg_echo('activity'); ?></a></li>
				</ul>
			<?php } ?>
		</li>
		
		<?php /* activity : Fil d'activité du site */ ?>
		
		<?php if (elgg_is_active_plugin('groups')) { ?>
			<li class="groups"><a <?php if(elgg_in_context('groups') || (elgg_instanceof(elgg_get_page_owner_entity(), 'group'))) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url; ?>groups/all"><?php echo elgg_echo('groups'); ?></a>
				<ul class="hidden">
					<li><a href="<?php echo $url . 'groups/all'; ?>"><?php echo elgg_echo('esope:joinagroup'); ?></a></li>
					<?php echo $groups; ?>
				</ul>
			</li>
			<?php echo $invites; ?>
		<?php } ?>
		
		<?php if (elgg_is_active_plugin('categories')) { ?>
			<li class="thematiques"><a <?php if(elgg_in_context('categories')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'categories'; ?>"><?php echo elgg_echo('esope:categories'); ?></a>
				<ul class="hidden">
					<li><a href="<?php echo $url; ?>categories"><?php echo elgg_echo('esope:categories:all'); ?></a></li>
					<?php echo $categories; ?>
				</ul>
			</li>
		<?php } ?>
		
		<?php if (elgg_is_active_plugin('members')) { ?>
			<li class="members"><a <?php if(elgg_in_context('members') || elgg_in_context('profile') || elgg_in_context('friends')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'members'; ?>"><?php echo elgg_echo('esope:directory'); ?></a></li>
		<?php } ?>
		
		<?php if (elgg_is_active_plugin('event_calendar')) { ?>
			<li class="agenda"><a <?php if (elgg_in_context('event_calendar') && !elgg_in_context('groups')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'event_calendar/list'; ?>"><?php echo elgg_echo('esope:event_calendar'); ?></a></li>
		<?php } ?>
		
	</ul>
	
	<?php
	if (elgg_is_active_plugin('search')) {
		$search_text = elgg_echo('esope:search:defaulttext');
		echo '<form action="' . $url . 'search" method="get">';
			echo '<label for="esope-search-input" class="invisible">' . $search_text . '</label>';
			echo elgg_view('input/autocomplete', array('name' => 'q', 'id' => 'esope-search-input', 'match_on' => 'all', 'value' => $prev_q, 'placeholder' => $search_text));
			echo '<input type="image" id="esope-search-submit-button" src="' . $urlicon . 'recherche.png" value="' . elgg_echo('esope:search') . '" />';
		echo '</form>';
	}
	?>
	<div class="clearfloat"></div>
	</div>
	<?php
}

