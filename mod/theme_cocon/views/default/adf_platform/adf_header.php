<?php

$url = $vars['url'];
$urlimg = $url . 'mod/theme_cocon/graphics/';
$urlpictos = $urlimg . 'pictos/';

$site = elgg_get_site_entity();
$title = $site->name;
$prev_q = get_input('q', '');

if (elgg_is_logged_in()) {
	$own = $_SESSION['user'];
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
				. '<img src="' . $group->getIconURL('tiny') . '" alt="' . str_replace('"', "''", $group->name) . ' (' . elgg_echo('adf_platform:groupicon') . '" />' . $group->name . '</a></li>';
			// Si on liste les sous-groupes, on le fait ici si demandé
			if (elgg_is_active_plugin('au_subgroups') && ($display_subgroups == 'yes')) {
				$groups .= adf_platform_list_groups_submenu($group, 1, true, $own);
			}
		}
	// "Invitations" dans les groupes : affiché seulement s'il y a des invitations en attente
		$group_invites = groups_get_invited_groups(elgg_get_logged_in_user_guid());
		$invites_count = sizeof($group_invites);
		if ($invites_count == 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvite') . '">' . $invites_count . '</a></li>';
		} else if ($invites_count > 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvites') . '">' . $invites_count . '</a></li>';
		}
		// Demandes de contact en attente : affiché seulement s'il y a des demandes en attente
		$friendrequests_options = array("type" => "user", "count" => true, "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true);
		$friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
		if ($friendrequests_count == 1) {
			$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('adf_platform:friendinvite') . '">' . $friendrequests_count . '</a></li>';
		} else if ($friendrequests_count > 1) {
			$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('adf_platform:friendinvites') . '">' . $friendrequests_count . '</a></li>';
		}
	}
	
	// Liste des catégories (thématiques du site)
	if (elgg_is_active_plugin('categories')) {
		$categories = '';
		$themes = $site->categories;
		if ($themes) foreach ($themes as $theme) {
			$categories .= '<li><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme . '</a></li>';
		}
	}
	
	// Messages non lus
	if (elgg_is_active_plugin('messages')) {
		$num_messages = (int)messages_count_unread();
		if ($num_messages != 0) {
			$text = "$num_messages";
			$tooltip = elgg_echo("messages:unreadcount", array($num_messages));
			$messages = '<li class="invites"><a href="' . $url . 'messages/inbox/' . $ownusername . '" title="' .	$tooltip . '">' . $text . '</a></li>';
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

			<header>
				<div class="">
					<div class="interne">
						<h1>
							<img src="<?php echo $urlimg; ?>header_ministere.jpg" /><a href="<?php echo $url; ?>" title="<?php echo elgg_echo('adf_platform:gotohomepage'); ?>"><img src="<?php echo $urlimg; ?>header_cocon.png" style="margin-left:14px;" />
							</a>
						</h1>
						<?php if (elgg_is_logged_in()) { ?>
							<nav>
								<ul>
									<li id="man"><a href="<?php echo $url . 'friends/' . $ownusername; ?>"><img src="' . $urlpictos . 'contacts.png" alt="<?php echo elgg_echo('friends'); ?>" /></a></li>
									<?php echo $friendrequests; ?>
									<li id="msg"><a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>"><img src="' . $urlpictos . 'mail.png" alt="<?php echo elgg_echo('messages'); ?>" /></a></li>
									<?php if ($messages) { echo $messages; } ?>
									<li id="usersettings"><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>"><img src="' . $urlpictos . 'settings.png" alt="<?php echo elgg_echo('adf_platform:usersettings'); ?>" /></a></li>
									<?php if (elgg_is_admin_logged_in()) { ?>
										<li id="admin"><a href="<?php echo $url . 'admin/dashboard/'; ?>" title="<?php echo elgg_echo('admin'); ?>"><i class="fa fa-cogs settings icon"></i></a></li>
									<?php } ?>
									
									<?php
									$helplink = elgg_get_plugin_setting('helplink', 'adf_public_platform');
									//if (empty($helplink)) $helplink = 'pages/view/182/premiers-pas';
									if (!empty($helplink)) echo '<li id="help"><a href="' . $url . $helplink . '" title="' . elgg_echo('adf_platform:help') . '"><img src="' . $urlpictos . 'help.png" /></a></li>';
									?>
									<?php if ($loginas_logout) { echo $loginas_logout; } ?>
									<li id="logout"><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => '<img src="' . $urlpictos . 'logout.png" />', 'title' => elgg_echo('logout'), 'is_action' => true)); ?></li>
									<li id="user"><a href="<?php echo $url . 'profile/' . $ownusername; ?>"><img src="<?php echo $own->getIconURL('small'); ?>" alt="<?php echo $own->name; ?>" /></a></li>
									
								</ul>
							</nav>
						<?php } else {
							// Bouton de connexion partout sauf sur la home
							if (full_url() != $url) echo '<nav><ul><li><i class="fa fa-sign-in sign in icon"></i><a href="' . $url . '">' . elgg_echo('theme_cocon:login') . '</a></li></ul></nav>';
						} ?>
					</div>
				</div>
			</header>
			
			<?php if (elgg_is_logged_in()) { ?>
				<div id="transverse" class="">
					<div class="interne">
						<nav>
							<ul>
								<li class="home"><a href="<?php echo $url; ?>" <?php if (full_url() == $url) { echo 'class="active elgg-state-selected"'; } ?> ><?php echo elgg_echo('adf_platform:homepage'); ?> <i class="fa fa-caret-down"></i></a>
									<?php if (elgg_is_active_plugin('dashboard')) { ?>
										<ul class="hidden">
											<li><a href="<?php echo $url; ?>" ><?php echo elgg_echo('dashboard'); ?></a></li>
											<li><a href="<?php echo $url; ?>activity" ><?php echo elgg_echo('activity'); ?></a></li>
										</ul>
									<?php } ?>
								</li>
								
								<?php /* activity : Fil d'activité du site */ ?>
								
								<?php if (elgg_is_active_plugin('groups')) { ?>
									<li class="groups"><a <?php if(elgg_in_context('groups') || (elgg_instanceof(elgg_get_page_owner_entity(), 'group'))) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url; ?>groups/all"><?php echo elgg_echo('groups'); ?> <i class="fa fa-caret-down"></i></a>
										<ul class="hidden">
											<li><a href="<?php echo $url . 'groups/all'; ?>"><?php echo elgg_echo('adf_platform:joinagroup'); ?></a></li>
											<?php echo $groups; ?>
										</ul>
									</li>
									<?php echo $invites; ?>
								<?php } ?>
								
								<?php if (elgg_is_active_plugin('categories')) { ?>
									<li class="thematiques"><a <?php if(elgg_in_context('categories')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'categories'; ?>"><?php echo elgg_echo('adf_platform:categories'); ?> <i class="fa fa-caret-down"></i></a>
										<ul class="hidden">
											<li><a href="<?php echo $url; ?>categories"><?php echo elgg_echo('adf_platform:categories:all'); ?></a></li>
											<?php echo $categories; ?>
										</ul>
									</li>
								<?php } ?>
								
								<?php if (elgg_is_active_plugin('members')) { ?>
									<li class="members"><a <?php if(elgg_in_context('members') || elgg_in_context('profile')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'members'; ?>"><?php echo elgg_echo('adf_platform:directory'); ?></a></li>
								<?php } ?>
								
								<?php if (elgg_is_active_plugin('event_calendar')) { ?>
									<li class="agenda"><a <?php if (elgg_in_context('event_calendar') && !elgg_in_context('groups')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'event_calendar/list'; ?>"><?php echo elgg_echo('adf_platform:event_calendar'); ?></a></li>
								<?php } ?>

								<li class="help"><a href="javascript:void(0);"><?php echo elgg_echo('theme_cocon:menu:live'); ?> <i class="fa fa-caret-down"></i></a>
									<ul class="hidden">
										<li><a href="<?php echo $url; ?>cmspages/read/visio1">Salle n°1</a></li>
										<li><a href="<?php echo $url; ?>cmspages/read/visio2">Salle n°2</a></li>
										<li><a href="<?php echo $url; ?>cmspages/read/visio3">Salle n°3</a></li>
										<li><a href="<?php echo $url; ?>cmspages/read/visio4">Salle n°4</a></li>
										<li><a href="<?php echo $url; ?>cmspages/read/visio5">Salle n°5</a></li>
									</ul>
								</li>
								
							</ul>
						</nav>
						
						<?php if (elgg_is_active_plugin('search')) { ?>
							<form action="<?php echo $url . 'search'; ?>" method="get">
								<?php $search_text = elgg_echo('adf_platform:search:defaulttext'); ?>
								<label for="adf-search-input" class="invisible"><?php echo $search_text; ?></label>
								<?php echo elgg_view('input/autocomplete', array('name' => 'q', 'id' => 'adf-search-input', 'match_on' => 'all', 'value' => $prev_q, 'placeholder' => $search_text)); ?>
								<input type="image" id="adf-search-submit-button" src="<?php echo $urlimg; ?>pictos/recherche.png" value="<?php echo elgg_echo('adf_platform:search'); ?>" />
							</form>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			
