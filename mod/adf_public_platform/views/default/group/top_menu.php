<?php

$group = elgg_get_page_owner_entity();
if (elgg_instanceof($group, 'group')) {
	
	// Add per-group custom CSS
	if (!empty($group->customcss)) { echo '<style>' . $group->customcss . '</style>'; }
	
	// Can be used to add a custom group tab menu
	if (elgg_get_plugin_setting('groups_topmenu', 'adf_public_platform') == 'yes') {
		
		$context = elgg_get_context();

		//global $CONFIG;

		$tabs['home'] = array(
			'text' => elgg_echo('esope:groups:home'),
			'href' => $group->getURL(),
			'selected' => (($context == 'group_home') || (full_url() == $group->getURL())),
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
		
		
		// Register tabs to our new menu
		foreach ($tabs as $name => $tab) {
			$tab['name'] = $name;
			elgg_register_menu_item('group_topmenu', $tab);
		}
		
		// Render tabs
		echo '<div class="group-top_menu">';
		echo elgg_view_menu('group_topmenu', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
		echo '</div>';
		
	}
}


