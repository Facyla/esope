<?php

$url = $vars['url'];
$urlicon = $url . 'mod/adf_public_platform/img/theme/';

$site = elgg_get_site_entity();
$title = $site->name;

if (elgg_is_logged_in()) {
	$own = $_SESSION['user'];
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	
	// Type de profil et menus adaptés
	$profile_type = dossierdepreuve_get_user_profile_type($own);
	// Menus différenciées selon les profils
	$display_topmenu = true;
	$display_menu = false;
	$display_groups = true; $display_blog = true; $display_members = true;
	$groups_name = elgg_echo('groups');
	$groups_url = $url . 'groups/all';
	//$groups_url = $url . 'groups/member/' . $ownusername;
	switch($profile_type) {
		case 'organisation':
			$display_blog = false;
			break;
		case 'learner':
			$display_menu = false;
			$display_groups = false;
			break;
		case 'tutor':
		case 'evaluator':
			break;
		case 'other_administrative':
		default:
			break;
	}
	// Pas de menu si on veut, mais pour l'admin oui !
	if (elgg_is_admin_logged_in()) {
		$display_menu = true;
		$display_admin = true;
	}
	
	
	// Eléments du menu supérieur
	if ($display_topmenu) {
		
		// Messages non lus
		$num_messages = (int)messages_count_unread();
		if ($num_messages != 0) {
			$text = "$num_messages";
			$tooltip = elgg_echo("messages:unreadcount", array($num_messages));
			$messages = '<li class="invites"><a href="' . $url . 'messages/inbox/' . $ownusername . '" title="' .	$tooltip . '">' . $text . '</a></li>';
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
	
	
	// Eléments du menu éditorial
	if ($display_menu) {
		
		if ($display_groups && elgg_is_active_plugin('groups')) {
			// Liste de ses groupes
			$groups = '';
			$mygroups = elgg_get_entities_from_relationship(array( 'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ownguid, 'inverse_relationship' => false, 'limit' => 99, 'order_by' => 'time_created asc'));
			foreach ($mygroups as $group) {
				$groups .= '<li><a href="' . $group->getURL() . '">' 
					. '<img src="' . $group->getIconURL('tiny') . '" alt="' . str_replace('"', "''", $group->name) . ' (' . elgg_echo('adf_platform:groupicon') . '" />'
					. $group->name . '</a></li>';
			}
			// "Invitations" dans les groupes : affiché seulement s'il y a des invitations en attente
			$group_invites = groups_get_invited_groups(elgg_get_logged_in_user_guid());
			$invites_count = sizeof($group_invites);
			if ($invites_count == 1) {
				$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvite') . '">' . $invites_count . '</a></li>';
			} else if ($invites_count > 1) {
				$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('adf_platform:groupinvites') . '">' . $invites_count . '</a></li>';
			}
		}
	
		// Liste des catégories (thématiques du site)
		if (elgg_is_active_plugin('categories')) {
			$categories = '';
			$themes = $site->categories;
			foreach ($themes as $theme) {
				$categories .= '<li><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme . '</a></li>';
			}
		}
		
	}
	
}
?>

			<header class="<?php if (elgg_is_logged_in()) { echo 'loggedin'; } else { echo 'notloggedin'; } ?>">
				<div class="interne">
					<h1><a href="<?php echo $url; ?>" title="<?php echo elgg_echo('adf_platform:gotohomepage'); ?>"><?php
					echo elgg_get_plugin_setting('headertitle', 'adf_public_platform');
					//'<span>D</span>epartements-en-<span>R</span>eseaux.<span class="minuscule">fr</span>';
					?></a></h1>
					<span class="header-subtitle">la plateforme de votre parcours B2i Adultes</span>
					<?php if (elgg_is_logged_in()) {
						echo '<a href="' . $url . 'profile/' . $ownusername . '"><span id="adf-profil"><img src="' . $own->getIconURL('topbar') . '" alt="' . $own->name . '" /> ' . $own->name . ' (' . elgg_echo('dossierdepreuve:profile_type:' . $profile_type). ')</span></a>';
						//echo '<span id="adf-profil"><img src="' . $own->getIconURL('topbar') . '" alt="' . $own->name . '" /> ' . $own->name . ' (profil)</span>';
						?>
						<nav>
							<ul>
								<li id="msg"><a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>"><?php echo elgg_echo('messages'); ?></a></li>
								<?php if ($messages) { echo $messages; } ?>
								<li id="man"><a href="<?php echo $url . 'friends/' . $ownusername; ?>"><?php echo elgg_echo('theme_compnum:friends'); ?></a></li>
								<?php echo $friendrequests; ?>
								<li><a href="<?php echo $url . 'groups/member/' . $ownusername; ?>"><?php echo elgg_echo('theme_compnum:group'); ?></a></li>
								<li><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>"><?php echo elgg_echo('theme_compnum:usersettings'); ?></a></li>
								<!--
								<li><?php echo elgg_echo('adf_platform:myprofile'); ?></a>
										<li><a href="<?php echo $url . 'profile/' . $ownusername . '/edit'; ?>">Compléter mon profil</a></li>
										<li><a href="<?php echo $url . 'avatar/edit/' . $ownusername . '/edit'; ?>">Changer la photo du profil</a></li>
								</li>
								//-->
								<?php if (elgg_is_admin_logged_in()) { ?>
									<li><a href="<?php echo $url . 'admin/dashboard/'; ?>"><?php echo elgg_echo('admin'); ?></a></li>
								<?php } ?>
								
								<?php
								$helplink = elgg_get_plugin_setting('helplink', 'adf_public_platform');
								if (!empty($helplink)) echo '<li><a href="' . $url . $helplink . '">' . elgg_echo('adf_platform:help') . '</a></li>';
								?>
								
								<li><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => elgg_echo('logout'), 'is_action' => true)); ?></li>
							</ul>
						</nav>
					<?php } else {
						// Bouton de connexion partout sauf sur la home - en fait si : page différente
						//if (full_url() != $url) 
						echo '<nav><ul><li><a href="' . $url . 'login">' . elgg_echo('theme_compnum:login') . '</a></li></ul></nav>';
					} ?>
				</div>
			</header>
			
			<?php if (elgg_is_logged_in() && $display_menu) { ?>
				<div id="transverse">
					<div class="interne">
						<nav>
							<ul>
								
								<li class="home"><a href="<?php echo $url; ?>" <?php if (full_url() == $url) { echo 'class="active elgg-state-selected"'; } ?> >Accueil</a></li>
								
								<?php if ($display_blog) { ?>
									<li class="dossierdepreuve groups"><a <?php if (elgg_in_context('dossierdepreuve')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'dossierdepreuve/all'; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:menu'); ?></a>
										<ul>
											<li><a href="<?php echo $url . 'dossierdepreuve/inscription'; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:register'); ?></a></li>
											<li><a href="<?php echo $url . 'dossierdepreuve/gestion'; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:gestion'); ?></a></li>
											<li><a href="<?php echo $url . 'dossierdepreuve/all'; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:all'); ?></a></li>
											<li><a href="<?php echo $url . 'blog/all'; ?>"><?php echo elgg_echo('blog:title:all_blogs'); ?></a></li>
									<li><a href="<?php echo $url . 'file/all'; ?>"><?php echo elgg_echo('file:all'); ?></a></li>
											
											
											<!--
											<li><a href="<?php echo $url . 'dossierdepreuve/owner/' . $ownusername; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:mine'); ?></a></li>
											//-->
										</ul>
									</li>
									<!--
									<li class="blog"><a <?php if (elgg_in_context('blog')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'blog/owner/' . $ownusername; ?>"><?php echo elgg_echo('blog'); ?></a></li>
									<li class="file"><a <?php if (elgg_in_context('file')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'file/owner/' . $ownusername; ?>"><?php echo elgg_echo('file'); ?></a></li>
									//-->
								<?php } ?>
								
								<?php if ($display_groups) { ?>
									<li class="groups"><a <?php if( (full_url() != $url . 'groups/all') && (elgg_in_context('groups') || (elgg_instanceof(elgg_get_page_owner_entity(), 'group')))) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $groups_url; ?>"><?php echo $groups_name; ?></a>
										<ul>
											<li><a href="<?php echo $url . 'groups/all'; ?>"><?php echo elgg_echo('groups:all'); ?></a></li>
											<?php if ($profile_type == 'organisation') { ?>
												<li><a href="<?php echo $url . 'groups/owner/' . $ownusername; ?>"><?php echo elgg_echo('groups:owned'); ?></a></li>
											<?php } else if (($profile_type == 'tutor') || ($profile_type == 'evaluator')) { ?>
												<li><a href="<?php echo $url . 'groups/owner/' . $ownusername; ?>"><?php echo elgg_echo('groups:admin'); ?></a></li>
											<?php } ?>
											<li><a href="<?php echo $url . 'groups/member/' . $ownusername; ?>"><?php echo elgg_echo('groups:yours'); ?></a></li>
											<li><a href="<?php echo $vars['url'] . 'groups/add/' . $ownguid; ?>"><?php echo elgg_echo('groups:add'); ?></a></li>
											<?php echo $groups; ?>
										</ul>
									</li>
									<?php echo $invites; ?>
								<?php } ?>
								
								<?php if ($display_members) { ?>
									<li class="members"><a <?php if(elgg_in_context('members') || (elgg_in_context('profile') && (full_url() != $CONFIG->url))) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'members/newest'; ?>"><?php echo elgg_echo('adf_platform:directory'); ?></a>
										<ul>
											<?php if ($profile_type == 'organisation') { ?>
											<li><a href="<?php echo $url . ''; ?>friends/<?php echo $ownusername; ?>"><?php echo "Nos formateurs (contacts)"; ?></a></li>
											<li><a href="<?php echo $url . ''; ?>dossierdepreuve/candidats"><?php echo "Nos candidats (@TODO)"; ?></a></li>
											<?php } else if (($profile_type == 'tutor') || ($profile_type == 'evaluator')) { ?>
											<li><a href="<?php echo $url . ''; ?>dossierdepreuve/candidats"><?php echo "Mes candidats (@TODO)"; ?></a></li>
											<?php } else { ?>
											<li><a href="<?php echo $url . ''; ?>members/newest"><?php echo "Tous les membres"; ?></a></li>
											<li><a href="<?php echo $url . ''; ?>members/online"><?php echo "Membres en ligne"; ?></a></li>
											<li><a href="<?php echo $url . ''; ?>members/organisation"><?php echo "Centres agréés"; ?></a></li>
											<li><a href="<?php echo $url . ''; ?>members/formateur"><?php echo "Formateurs"; ?></a></li>
											<li><a href="<?php echo $url . ''; ?>members/candidat"><?php echo "Candidats"; ?></a></li>
											<?php } ?>
										</ul>
									</li>
								<?php } ?>
								
								<?php if ($display_admin) { ?>
									<li class="admin"><a href="<?php echo $url . 'admin/dashboard'; ?>">Admin</a>
										<ul>
											<li><a href="<?php echo $url . 'cmspages'; ?>"><?php echo "Gérer les pages CMS"; ?></a></li>
											<li><a href="<?php echo $url . 'file/add/' . $ownguid; ?>"><?php echo "Publier un fichier"; ?></a></li>
											<li><a href="<?php echo $url . ''; ?>admin/users/add"><?php echo "Créer un nouveau compte"; ?></a></li>
										</ul>
									</li>
								<?php } ?>
								
							</ul>
						</nav>
						<form action="<?php echo $url . 'search'; ?>" method="post">
							<?php $search_text = 'Trouvez des groupes, des fichiers...'; ?>
							<label for="adf-search-input" class="invisible"><?php echo $search_text; ?></label>
							<input type="text" id="adf-search-input" name="q" value="<?php echo $search_text; ?>" />
							<input type="image" id="adf-search-submit-button" src="<?php echo $urlicon; ?>recherche.png" value="<?php echo elgg_echo('adf_platform:search'); ?>" />
						</form>
					</div>
				</div>
			<?php } ?>
			
