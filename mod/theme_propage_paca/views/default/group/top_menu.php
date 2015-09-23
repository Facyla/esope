<?php

$group = elgg_get_page_owner_entity();
if (elgg_instanceof($group, 'group')) {
	$url = elgg_get_site_url();
	
	// Add per-group custom CSS
	if (!empty($group->customcss)) { echo '<style>' . $group->customcss . '</style>'; }
	
	// Can be used to add a custom group tab menu
	// Menu du Pôle
	if (theme_afparh_is_pole($group)) {
		// Add pole context for navigation menu selection
		elgg_push_context('poles-rh');
		// Tabs <=> rubrique dans l'accueil du groupe
		$rubrique = get_input('rubrique', false);
		
		// Consulter : accueil du Pôle
		$tabs['consult'] = array(
				'href' => "{$url}pages/group/{$group->guid}/all", 'text' => elgg_echo('theme_afparh:pole:consult'),
				'priority' => 100, 'selected' => (elgg_in_context('pages')),
			);
		// Diffuser : diffusion nouvel article, lien, fichier
		$tabs['publish'] = array(
				'href' => $group->getURL() . '?rubrique=publish', 'text' => elgg_echo('theme_afparh:pole:publish'),
				'priority' => 200, 'selected' => ($rubrique == 'publish'),
			);
		// Echanger : forum du Pôle
		$tabs['forum'] = array(
				'href' => "{$url}discussion/owner/{$group->guid}", 'text' => elgg_echo('theme_afparh:pole:forum'),
				'priority' => 300, 'selected' => (full_url() == "{$url}discussion/owner/{$group->guid}"),
			);
		// Produire : Liste des groupes de travail du Pôle
		$tabs['produce'] = array(
				'href' => $group->getURL() . '?rubrique=groups', 'text' => elgg_echo('theme_afparh:pole:produce'),
				'priority' => 400, 'selected' => ($rubrique == 'groups'),
			);
		
	} else if (elgg_get_plugin_setting('groups_topmenu', 'adf_public_platform') == 'yes') {
		// Default Esope top menu
		$context = elgg_get_context();

		$tabs['home'] = array(
			'text' => elgg_echo('esope:groups:home'),
			'href' => $group->getURL(),
			'selected' => ((full_url() == $group->getURL())),
			'priority' => 100,
		);
		
		// CUSTOM TABS (up to 8)
		// Note : requires that customtab1 to 5 are configured in some way (easiest : use custom group field with profile_manager)
		
		for ($i = 1; $i <= 8; $i++) {
			// Custom tab #$i
			if (!empty($group->{"customtab$i"})) {
				$tabinfo = explode('::', $group->{"customtab$i"});
				$tabs["customtab$i"] = array(
					'href' => $tabinfo[0], 'text' => $tabinfo[1], 'title' => str_replace('"', "'", $tabinfo[2]),
					'selected' => (full_url() == $tabinfo[0]), 'priority' => 300,
				);
				if (esope_is_external_link($tabinfo[0])) $tabs["customtab$i"]['target'] = '_blank';
			}
		}
	}
	
	
	// Register tabs to our new menu
	if ($tabs) {
		foreach ($tabs as $name => $tab) {
			$tab['name'] = $name;
			elgg_register_menu_item('group_topmenu', $tab);
		}
		// Render tabs
		echo '<div class="group-top_menu">';
		echo elgg_view_menu('group_topmenu', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
		echo '</div>';
	}
	
	// Display group stats
	echo elgg_view('group/group_stats', array('entity' => $group, 'full_view' => true));
}


