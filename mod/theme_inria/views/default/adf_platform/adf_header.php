<?php

$url = $vars['url'];
$urlicon = $url . 'mod/adf_public_platform/img/theme/';
$urlimg = $url . 'mod/theme_inria/graphics/';

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
		$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . elgg_echo('theme_inria:groupinvites') . '</a></li>';
		if ($invites_count == 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvite') . '">' . $invites_count . '</a></li>';
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvite') . '</a></li>';
		} else if ($invites_count > 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvites') . '">' . $invites_count . '</a></li>';
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvites') . '</a></li>';
		} else {
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvite') . '</a></li>';
		}
		
		// Demandes de contact en attente : affiché seulement s'il y a des demandes en attente
		$friendrequests_options = array("type" => "user", "count" => true, "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true);
		$friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
		$friendrequests_li = '<li><a href="' . $url . 'friend_request/' . $ownusername . '">' . elgg_echo('theme_inria:friendsinvites') . '</a></li>';

		if ($friendrequests_count == 1) {
			$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('adf_platform:friendinvite') . '">' . $friendrequests_count . '</a></li>';
			//$friendrequests_li = '<li><a href="' . $url . 'friend_request/' . $ownusername . '">' . $friendrequests_count . ' ' . elgg_echo('adf_platform:friendinvite') . '</a></li>';
		} else if ($friendrequests_count > 1) {
			$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('adf_platform:friendinvites') . '">' . $friendrequests_count . '</a></li>';
			//$friendrequests_li = '<li><a href="' . $url . 'friend_request/' . $ownusername . '">' . $friendrequests_count . ' ' . elgg_echo('adf_platform:friendinvites') . '</a></li>';
		} else {
			//$friendrequests_li = '<li><a href="' . $url . 'friend_request/' . $ownusername . '">' . $friendrequests_count . ' ' . elgg_echo('adf_platform:friendinvites') . '</a></li>';
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
	
}
?>

			<header>
				<div class="">
					<div class="interne">
						<h1><a href="<?php echo $url; ?>" title="<?php echo elgg_echo('adf_platform:gotohomepage'); ?>">
						<img src="<?php echo $urlimg; ?>logo-iris.png" />
						<img src="<?php echo $urlimg; ?>bulles-header.png" />
						<?php
						//echo elgg_get_plugin_setting('headertitle', 'adf_public_platform');
						//'<span>D</span>epartements-en-<span>R</span>eseaux.<span class="minuscule">fr</span>';
						?></a></h1>
						<?php if (elgg_is_logged_in()) { ?>
							<nav>
								<ul>
									<li id="user"><a href="<?php echo $url . 'profile/' . $ownusername; ?>"><img src="<?php echo $own->getIconURL('topbar'); ?>" alt="<?php echo $own->name; ?>" /> <?php echo $own->name; ?></a></li>
									<li id="msg"><a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>"><i class="fa fa-envelope-o mail outline icon"></i><?php echo elgg_echo('messages'); ?></a></li>
									<?php if ($messages) { echo $messages; } ?>
									<li id="usersettings"><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>"><i class="fa fa-cog setting icon"></i><?php echo elgg_echo('adf_platform:usersettings'); ?></a></li>
											<!--
									<li><?php echo elgg_echo('adf_platform:myprofile'); ?></a>
											<li><a href="<?php echo $url . 'profile/' . $ownusername . '/edit'; ?>">Compléter mon profil</a></li>
											<li><a href="<?php echo $url . 'avatar/edit/' . $ownusername . '/edit'; ?>">Changer la photo du profil</a></li>
									</li>
											//-->
									<?php if (elgg_is_admin_logged_in()) { ?>
										<li id="admin"><a href="<?php echo $url . 'admin/dashboard/'; ?>"><i class="fa fa-cogs settings icon"></i><?php echo elgg_echo('admin'); ?></a></li>
									<?php } ?>
									<li><a href="<?php echo $url . 'groups/profile/8551/aide'; ?>"><i class="fa fa-question-circle help icon"></i><?php echo elgg_echo('adf_platform:help'); ?></a></li>
									<li><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => '<i class="fa fa-power-off power-off icon"></i>' . elgg_echo('logout'), 'is_action' => true)); ?></li>
								</ul>
							</nav>
						<?php } else {
							// Bouton de connexion partout sauf sur la home
							if (full_url() != $url) echo '<nav><ul><li><i class="fa fa-sign-in sign in icon"></i><a href="' . $url . '">' . elgg_echo('theme_inria:login') . '</a></li></ul></nav>';
						} ?>
					</div>
				</div>
			</header>
			
			<?php if (elgg_is_logged_in()) { ?>
				<div id="transverse" class="">
					<div class="interne">
						<nav>
							<ul>
								<li class="home"><a href="javascript:void(0);" <?php if (full_url() == $url) { echo 'class="active elgg-state-selected"'; } ?> ><?php echo elgg_echo('theme_inria:topbar:news'); ?> <i class="fa fa-caret-down"></i></a>
									<ul class="hidden">
										<li class="home"><a href="<?php echo $url; ?>activity"><?php echo elgg_echo('theme_inria:site:activity'); ?></a></li>
									<li><a href="<?php echo $url; ?>thewire/all"><?php echo elgg_echo('theme_inria:thewire:title'); ?></a></li>
									</ul>
								</li>
								
								
								<!--
								<li class="groups"><a href="<?php echo $url . 'groups/all'; ?>" <?php if (full_url() == $url . 'groups/all') { echo 'class="active elgg-state-selected"'; } ?> >Parcourir</a>
									<ul class="hidden">
										<li><a href="<?php echo $url; ?>groups/search?tag=Libre+expression">Libre expression</a></li>
										<li><a href="<?php echo $url; ?>groups/search?tag=Missions+et+projets">Missions et projets</a></li>
										<li><a href="<?php echo $url; ?>groups/search?tag=Animation+et+conseils">Animation et conseils</a></li>
										<li><a href="<?php echo $url; ?>groups/search?tag=Institutionnel">Institutionnel</a></li>
									</ul>
								</li>
								//-->
								
								<li class="groups"><a <?php if( (full_url() != $url . 'groups/all') && (elgg_in_context('groups') || (elgg_instanceof(elgg_get_page_owner_entity(), 'group')))) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);"><?php echo elgg_echo('groups'); ?> <i class="fa fa-caret-down"></i></a>
									<ul class="hidden">
										<li><a href="<?php echo $url . 'groups/member/' . $ownusername; ?>"><?php echo elgg_echo('inria:mygroups'); ?></a></li>
										<li><a href="<?php echo $url . 'groups/owner/' . $ownusername; ?>"><?php echo elgg_echo('groups:owned'); ?></a></li>
										<li><a href="<?php echo $url . 'groups/all'; ?>"><?php echo elgg_echo('groups:all'); ?></a></li>
										<?php echo $groupinvites; ?>
										<li><a href="<?php echo $vars['url'] . 'groups/add/' . $ownguid; ?>"><?php echo elgg_echo('theme_inria:topbar:new_group'); ?></a></li>
										<?php //echo $groups; ?>
									</ul>
								</li>
								<?php echo $invites; ?>
								
								<?php if (elgg_is_active_plugin('categories')) { ?>
									<li class="thematiques"><a <?php if(elgg_in_context('categories')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'categories'; ?>"><?php echo elgg_echo('adf_platform:categories'); ?></a>
										<ul class="hidden">
											<li><a href="<?php echo $url; ?>categories"><?php echo elgg_echo('adf_platform:categories:all'); ?></a></li>
											<?php echo $categories; ?>
										</ul>
									</li>
								<?php } ?>
								
								<?php if (elgg_is_active_plugin('members')) { ?>
									<li class="members"><a <?php if(elgg_in_context('members') || elgg_in_context('profile') || elgg_in_context('friends')) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);"><?php echo elgg_echo('members'); ?> <i class="fa fa-caret-down"></i></a>
										<ul class="hidden">
											<li><a href="<?php echo $url . 'friends/' . $ownusername; ?>"><?php echo elgg_echo('friends'); ?></a></li>
											<li><a href="<?php echo $url . 'collections/' . $ownusername; ?>"><?php echo elgg_echo('friends:collections'); ?></a></li>
											<?php echo $friendrequests_li; ?>
											<li><a href="<?php echo $url . 'members'; ?>"><?php echo elgg_echo('members'); ?></a></li>
											<?php
											if (($own->membertype == 'inria') || elgg_is_admin_logged_in()) {
												echo '<li><a href="' . $url . 'inria/invite">' . elgg_echo('inria_invite') . '</a></li>';
											}
											?>
										</ul>
									</li>
									<?php echo $friendrequests; ?>
								<?php } ?>
								
								<?php if (elgg_is_active_plugin('event_calendar')) { ?>
									<li class="agenda"><a <?php if (elgg_in_context('event_calendar') && !elgg_in_context('groups')) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);"><?php echo elgg_echo('adf_platform:event_calendar'); ?> <i class="fa fa-caret-down"></i></a>
										<ul class="hidden">
											<?php $start_date = date('Y-m-01'); ?>
											<li><a href="<?php echo $url . 'event_calendar/list/' . $start_date . '/month/mine'; ?>"><?php echo elgg_echo('event_calendar:show_mine'); ?></a></li>
											<li><a href="<?php echo $url . 'event_calendar/list/' . $start_date . '/month/friends'; ?>"><?php echo elgg_echo('event_calendar:show_friends'); ?></a></li>
											<li><a href="<?php echo $url . 'event_calendar/list/' . $start_date . '/month/all'; ?>"><?php echo elgg_echo('event_calendar:show_all'); ?></a></li>
										</ul>
									</li>
								<?php } ?>

								<?php
								$main_menu_help_count = elgg_get_plugin_setting('help_menu_count', 'theme_inria');
								if (!empty($main_menu_help_count)) {
									?>
									<li class="help"><a href="javascript:void(0);"><?php echo elgg_echo('theme_inria:menu:firststeps'); ?> <i class="fa fa-caret-down"></i></a>
										<ul class="hidden">
											<?php
											for ($i = 1; $i <= $main_menu_help_count; $i++) {
												$main_menu_item = elgg_get_plugin_setting('help_menu_'.$i, 'theme_inria');
												if (!empty($main_menu_item)) {
													$main_menu_item = explode('::', $main_menu_item);
													$menu_item_url = $main_menu_item[0];
													if ($main_menu_item[1]) $menu_item_link = $main_menu_item[1];
													else $menu_item_link = $main_menu_item[0];
													if ($main_menu_item[2]) $menu_item_title = $main_menu_item[2];
													echo '<li><a href="' . $menu_item_url . '" title="' . $menu_item_title . '">' . $menu_item_link . '</a></li>';
												}
											}
											?>
										</ul>
									</li>
									<?php
								}
								?>
								
							 <!--
							 <li class="inria_action"><a href="javascript:void(0);"><?php echo elgg_echo('theme_inria:topbar:action'); ?></a>
 <ul>
										<li><a href="<?php echo $vars['url']; ?>thewire/all"><?php echo elgg_echo('theme_inria:topbar:thewire'); ?></a></li>
										<li><a href="<?php echo $vars['url']; ?>invite"><?php echo elgg_echo("theme_inria:topbar:invite"); ?></a></li>
								</ul>
							 //-->

				</li>

			</ul>
						</nav>
						
						<?php if (elgg_is_active_plugin('search')) { ?>
							<form action="<?php echo $url . 'search'; ?>" method="post">
								<?php $search_text = elgg_echo('adf_platform:search:defaulttext'); ?>
								<label for="adf-search-input" class="invisible"><?php echo $search_text; ?></label>
								<?php echo elgg_view('input/autocomplete', array('name' => 'q', 'id' => 'adf-search-input', 'match_on' => 'all', 'value' => $prev_q, 'placeholder' => $search_text)); ?>
								<input type="image" id="adf-search-submit-button" src="<?php echo $urlicon; ?>recherche.png" value="<?php echo elgg_echo('adf_platform:search'); ?>" />
							</form>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			
