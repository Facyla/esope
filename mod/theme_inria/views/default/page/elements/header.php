<?php
/* Esope replaces topbar + header by a single header
 * See page/elements/topbar view for topbar content
 *
 * The main navigation menu is defined and customized here
 *
 * Header can be broken in 2 separate blocks by breaking out the enclosing div, then re-opening a new one
 * 	<div class="elgg-page-header">
 * 		<div class="elgg-inner">
 * 			$header
 * 		</div>
 * 	</div>
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
	
	// Groupes
	$groups = '';
	if (elgg_is_active_plugin('groups')) {
		// Liste de ses groupes
		$options = array( 'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ownguid, 'inverse_relationship' => false, 'limit' => 99, 'order_by' => 'time_created asc');
		// Cas des sous-groupes : listing avec marqueur de sous-groupe
		if (elgg_is_active_plugin('au_subgroups')) {
			// Si les sous-groupes sont activés : listing des sous-groupes sous les groupes, et ordre alpha si demandé
			$display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
			$display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
			$db_prefix = elgg_get_config('dbprefix');
			// Don't list subgroups here (we want to list them under parents, if listed)
			$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
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
		$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . elgg_echo('theme_inria:groupinvites') . '</a></li>';
		if ($invites_count == 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '">' . $invites_count . '</a></li>';
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '</a></li>';
		} else if ($invites_count > 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '">' . $invites_count . '</a></li>';
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '</a></li>';
		} else {
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '</a></li>';
		}
		
		// Demandes de contact en attente : affiché seulement s'il y a des demandes en attente
		$friendrequests_options = array("type" => "user", "count" => true, "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true);
		$friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
		$friendrequests_li = '<li><a href="' . $url . 'friend_request/' . $ownusername . '">' . elgg_echo('theme_inria:friendsinvites') . '</a></li>';

		if ($friendrequests_count == 1) {
			$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvite') . '">' . $friendrequests_count . '</a></li>';
		} else if ($friendrequests_count > 1) {
			$friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvites') . '">' . $friendrequests_count . '</a></li>';
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
	
}


// MAIN NAVIGATION MENU
if (elgg_is_logged_in()) {
	
	// Close enclosing divs and reopen new ones
	//echo '	</div></div><div id="transverse" class="elgg-page-sitemenu is-not-floatable"><div class="elgg-inner">';
	echo '</div><div id="transverse" class="elgg-page-sitemenu is-not-floatable"><div class="elgg-inner">';

		?>
		<div class="menu-navigation-toggle"><i class="fa fa-bars"></i> <?php echo elgg_echo('esope:menu:navigation'); ?></div>
		<ul class="elgg-menu elgg-menu-navigation elgg-menu-navigation-alt">
			<li class="home"><a href="javascript:void(0);" <?php if ((current_page_url() == $url) || (current_page_url() == $url . 'activity')) { echo 'class="active elgg-state-selected"'; } ?> ><?php echo elgg_echo('theme_inria:topbar:news'); ?> <i class="fa fa-caret-down"></i></a>
				<ul class="hidden">
					<?php if (elgg_is_active_plugin('dashboard')) { ?>
						<li class="home"><a href="<?php echo $url; ?>activity"><?php echo elgg_echo('river:all'); ?></a></li>
						<li><a href="<?php echo $url; ?>thewire/all"><?php echo elgg_echo('thewire:everyone'); ?></a></li>
					<?php } ?>
				</ul>
			</li>
	
			<?php /* activity : Fil d'activité du site */ ?>

			<?php if (elgg_is_active_plugin('groups')) { ?>
			<li class="groups"><a <?php if( (current_page_url() != $url . 'groups/all') && (elgg_in_context('groups') || (elgg_instanceof(elgg_get_page_owner_entity(), 'group')))) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);"><?php echo elgg_echo('groups'); ?> <i class="fa fa-caret-down"></i></a>
				<ul class="hidden">
					<li><a href="<?php echo $url . 'groups/groupsearch'; ?>"><?php echo elgg_echo('search:group:go'); ?></a></li>
					<li><a href="<?php echo $url . 'groups/all?filter=newest'; ?>"><?php echo elgg_echo('groups:all'); ?></a></li>
					<li><a href="<?php echo $url . 'p/groupes'; ?>"><?php echo elgg_echo('theme_inria:groups:discover'); ?></a></li>
					<li><a href="<?php echo $url . 'groups/member/' . $ownusername; ?>"><?php echo elgg_echo('groups:yours'); ?></a></li>
					<li><a href="<?php echo $url . 'groups/owner/' . $ownusername; ?>"><?php echo elgg_echo('groups:owned'); ?></a></li>
					<?php echo $groupinvites; ?>
					<li><a href="<?php echo elgg_get_site_url() . 'groups/add/' . $ownguid; ?>"><?php echo elgg_echo('groups:add'); ?></a></li>
					<?php //echo $groups; ?>
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
				<li class="members"><a <?php if(elgg_in_context('members') || elgg_in_context('profile') || elgg_in_context('friends')) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);"><?php echo elgg_echo('theme_inria:members'); ?> <i class="fa fa-caret-down"></i></a>
					<ul class="hidden">
						<li><a href="<?php echo $url . 'members/search/'; ?>"><?php echo elgg_echo('members:search'); ?></a></li>
						<li><a href="<?php echo $url . 'friends/' . $ownusername; ?>?limit=30"><?php echo elgg_echo('theme_inria:friends'); ?></a></li>
						<li><a href="<?php echo $url . 'collections/owner/' . $ownusername; ?>"><?php echo elgg_echo('theme_inria:friends:collections'); ?></a></li>
						<li><a href="<?php echo $url . 'members'; ?>"><?php echo elgg_echo('members'); ?></a></li>
						<?php echo $friendrequests_li; ?>
						<?php
						if (($own->membertype == 'inria') || elgg_is_admin_logged_in()) {
							//echo '<li><a href="' . $url . 'inria/invite">' . elgg_echo('inria_invite') . '</a></li>';
						}
					// echo '<li><a href="' . elgg_get_site_url() . 'invite">' . elgg_echo("theme_inria:topbar:invite") . '</a></li>';
						?>
					</ul>
				</li>
				<?php echo $friendrequests; ?>
			<?php } ?>
	
			<?php if (elgg_is_active_plugin('event_calendar')) { ?>
				<li class="agenda"><a <?php if (elgg_in_context('event_calendar') && !elgg_in_context('groups')) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);"><?php echo elgg_echo('theme_inria:event_calendar'); ?> <i class="fa fa-caret-down"></i></a>
					<ul class="hidden">
						<?php $start_date = date('Y-m-01'); ?>
						<li><a href="<?php echo $url . 'event_calendar/list/' . $start_date . '/month/all'; ?>"><?php echo elgg_echo('event_calendar:show_all'); ?></a></li>
						<li><a href="<?php echo $url . 'event_calendar/list/' . $start_date . '/month/mine'; ?>"><?php echo elgg_echo('event_calendar:show_mine'); ?></a></li>
						<!--
						<li><a href="<?php echo $url . 'event_calendar/list/' . $start_date . '/month/friends'; ?>"><?php echo elgg_echo('event_calendar:show_friends'); ?></a></li>
						//-->
					</ul>
				</li>
			<?php } ?>
	
			<?php
			// Custom menu
			$main_menu_help_count = elgg_get_plugin_setting('help_menu_count', 'theme_inria');
			if (!empty($main_menu_help_count)) {
				?>
				<li class="help"><a href="javascript:void(0);"><?php echo elgg_echo('theme_inria:menu:firststeps'); ?> <i class="fa fa-caret-down"></i></a>
					<ul class="hidden">
						<?php
						for ($i = 1; $i <= $main_menu_help_count; $i++) {
							if ($lang == 'en') {
								$main_menu_item = elgg_get_plugin_setting('help_menu_'.$i.'_en', 'theme_inria');
							} else {
								$main_menu_item = elgg_get_plugin_setting('help_menu_'.$i, 'theme_inria');
							}
							if (!empty($main_menu_item)) {
								$main_menu_item = explode('::', $main_menu_item);
								$menu_item_url = $main_menu_item[0];
								if ($main_menu_item[1]) { $menu_item_link = $main_menu_item[1]; }
								else { $menu_item_link = $main_menu_item[0]; }
								if ($main_menu_item[2]) { $menu_item_title = $main_menu_item[2]; }
								echo '<li><a href="' . $menu_item_url . '" title="' . $menu_item_title . '">' . $menu_item_link . '</a></li>';
							}
						}
						?>
					</ul>
				</li>
				<?php
			}
			?>
	
		</li>

		</ul>
	
		<?php
		if (elgg_is_active_plugin('search')) {
		$search_text = elgg_echo('esope:search:defaulttext');
		// Select search type (filter)
		//$search_opt = array('' => elgg_echo('all'), 'object' => elgg_echo('item:object'), 'group' => elgg_echo('item:group'), 'user' => elgg_echo('item:user')); // options_values
		$search_opt = array(elgg_echo('all') => '', elgg_echo('item:object') => 'object', elgg_echo('item:group') => 'group', elgg_echo('item:user') => 'user'); // options
		$search_opt = array(elgg_echo('all') => '', elgg_echo('item:object:icon') => 'object', elgg_echo('item:user:icon') => 'user', elgg_echo('item:group:icon') => 'group'); // options
		$search_entity_type = get_input('entity_type', '');
		echo '<form action="' . $url . 'search" method="get">';
			echo '<label for="esope-search-input" class="invisible">' . $search_text . '</label>';
			$livesearch = elgg_get_plugin_setting('livesearch', 'esope');
			if ($livesearch != 'no') {
				echo elgg_view('input/autocomplete', array('name' => 'q', 'id' => 'esope-search-input', 'match_on' => 'all', 'user_return' => 'name', 'value' => $prev_q, 'placeholder' => $search_text));
			} else {
				echo elgg_view('input/text', array('name' => 'q', 'id' => 'esope-search-input', 'value' => $prev_q, 'placeholder' => $search_text));
			}
			echo '<input type="image" id="esope-search-submit-button" src="' . $urlicon . 'recherche.png" value="' . elgg_echo('esope:search') . '" />';
			echo '<br />';
			echo elgg_view('input/radio', array('name' => 'entity_type', 'options' => $search_opt, 'value' => $search_entity_type, 'align' => 'horizontal'));
		echo '</form>';
		}

		?>
		<div class="clearfloat"></div>
	</div>
	<?php
}


