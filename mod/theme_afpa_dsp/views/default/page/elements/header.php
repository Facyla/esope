<?php
/* Esope replaces topbar + header by a single header
 * See page/elements/topbar view for topbar content
 *
 * The main navigation menu is defined and customized here
 * Theme settings allow to choose between theme hardcoded menu (dynamic), or a custom (but more static) menu
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



/* @TODO Use custom menus from theme settings
 * Accepted values :
 * empty => use hardcoded theme menu (below)
 * 'none' => do not display menu
 * any other value => display corresponding menu (using translations if available)
 * 
 * Test to display menu : $menu => false = do not use menu | 'none' = empty menu | $name = display menu $name
 * if ($menu && ($menu != 'none')) { echo $navigation_menu; }
 */
$topbar_menu = false;
$topbar_menu_public = false;
if (elgg_is_active_plugin('elgg_menus')) {
	$lang = get_language();
	// Main navigation menu
	$menu = elgg_get_plugin_setting('menu_navigation', 'esope');
	if (empty($menu)) {
		$menu = false;
	} else {
		if ($menu != 'none') {
			// Get translated menu, if exists
			$lang_menu = elgg_menus_get_menu_config($menu . '-' . $lang);
			if ($lang_menu) { $menu = $menu . '-' . $lang; }
			// Compute menu
			$navigation_menu = elgg_view_menu($menu, array('sort_by' => 'priority', 'class' => 'elgg-menu elgg-menu-navigation elgg-menu-navigation-alt elgg-menu-hz'));
		}
	}
	// Main navigation public menu
	$menu_public = elgg_get_plugin_setting('menu_navigation_public', 'esope');
	if (empty($menu_public)) {
		$menu_public = false;
	} else {
		if ($menu_public != 'none') {
			// Get translated menu, if exists
			$lang_menu = elgg_menus_get_menu_config($menu_public . '-' . $lang);
			if ($lang_menu) { $menu_public = $menu_public . '-' . $lang; }
			// Compute menu
			$navigation_menu_public = elgg_view_menu($menu_public, array('sort_by' => 'priority', 'class' => 'elgg-menu elgg-menu-navigation elgg-menu-navigation-alt elgg-menu-hz'));
		}
	}
}


$site = elgg_get_site_entity();
$title = $site->name;
$prev_q = get_input('q', '');

// Compute only if it will be displayed...
if (elgg_is_logged_in() && !$menu) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	// Groupes
	$groups = '';
	if (elgg_is_active_plugin('groups')) {
		// Liste de ses groupes
		$options = array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ownguid, 'inverse_relationship' => false, 'limit' => 99, 'order_by' => 'time_created asc');
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
		if ($invites_count == 1) {
			$invites = '<li class="elgg-menu-counter"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '">' . $invites_count . '</a></li>';
		} else if ($invites_count > 1) {
			$invites = '<li class="elgg-menu-counter"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '">' . $invites_count . '</a></li>';
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
	
	// NAVIGATION LOGGED IN MENU
	if ($menu) {
		if ($menu != 'none') {
			// Close enclosing divs and reopen new ones
			echo '</div><div id="transverse" class="elgg-page-sitemenu is-not-floatable"><div class="elgg-inner">';
			echo '<div class="menu-navigation-toggle"><i class="fa fa-bars"></i> ' . elgg_echo('esope:menu:navigation') . '</div>';
			echo $navigation_menu;
			echo '<div class="clearfloat"></div></div>';
		}
	} else {
		// Close enclosing divs and reopen new ones
		echo '</div><div id="transverse" class="elgg-page-sitemenu is-not-floatable"><div class="elgg-inner">';
		echo '<div class="menu-navigation-toggle"><i class="fa fa-bars"></i> ' . elgg_echo('esope:menu:navigation') . '</div>';
		?>
		<ul class="elgg-menu elgg-menu-navigation elgg-menu-navigation-alt">
			<li class="home"><a href="<?php echo $url; ?>" <?php if ((current_page_url() == $url) || (current_page_url() == $url . 'activity')) { echo 'class="active elgg-state-selected"'; } ?> ><?php echo elgg_echo('esope:homepage'); ?></a>
				<?php if (elgg_is_active_plugin('dashboard')) { ?>
					<ul class="hidden">
						<li><a href="<?php echo $url; ?>" ><?php echo elgg_echo('dashboard'); ?></a></li>
						<li><a href="<?php echo $url; ?>activity" ><?php echo elgg_echo('activity'); ?></a></li>
					</ul>
				<?php } ?>
			</li>
	
			<?php /* activity : Fil d'activité du site */ ?>
			
			<?php if (elgg_is_active_plugin('knowledge_database')) { ?>
				<li class="kdb"><a <?php if(elgg_in_context('knowledge_database') || (current_page_url() == $url . 'kdb')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url; ?>kdb"><?php echo elgg_echo('kdb'); ?></a></li>
			<?php } ?>
			
			<?php if (elgg_is_active_plugin('groups')) { ?>
				<li class="groups"><a <?php if(elgg_in_context('groups') || (elgg_instanceof(elgg_get_page_owner_entity(), 'group'))) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url; ?>groups/featured"><?php echo elgg_echo('groups:featured'); ?></a>
					<ul class="hidden">
						<?php echo $featured_groups; ?>
					</ul>
				</li>
				<?php echo $invites; ?>
				
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
		echo '<div class="clearfloat"></div></div>';
	}
	
// NAVIGATION PUBLIC MENU
} else {
	if ($menu_public && ($menu_public != 'none')) {
		echo '</div><div id="transverse" class="elgg-page-sitemenu is-not-floatable"><div class="elgg-inner">';
		echo '<div class="menu-navigation-toggle"><i class="fa fa-bars"></i> ' . elgg_echo('esope:menu:navigation') . '</div>';
		echo $navigation_menu_public;
		echo '<div class="clearfloat"></div></div>';
	} else {
	}
}

