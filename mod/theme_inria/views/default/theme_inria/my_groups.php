<?php

// Groupes
$groups = '';
$groups_more = '';
if (elgg_is_active_plugin('groups')) {
	$ownguid = elgg_get_logged_in_user_guid();
	$max_groups = 4;
	
	// D'abord les favoris, puis les autres groupes
	// Favorite groups first
	$favorite_guids = array();
	$favorite_options = array(
		'type' => 'group', 'relationship' => 'favorite', 
		'relationship_guid' => $ownguid, 'inverse_relationship' => true, 
		'limit' => false,
	);
	if (elgg_is_active_plugin('au_subgroups')) {
		// Don't list subgroups here (they are now considered as workspaces)
		$db_prefix = elgg_get_config('dbprefix');
		$favorite_options['wheres'] = array("NOT EXISTS (SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "')");
	}
	$favorite_groups = elgg_get_entities_from_relationship($favorite_options);
	if ($favorite_groups) {
		foreach ($favorite_groups as $ent) {
			if ($ent->isMember()) {
				$favorite_guids[] = $ent->guid;
			}
		}
	}
	
	// Liste de ses groupes
	$options = array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ownguid, 'inverse_relationship' => false, 'limit' => false, 'order_by' => 'time_created asc');
	
	// Exclude favorite groups if any (already listed above)
	if (sizeof($favorite_guids) > 0) {
		$options['wheres'][] = "e.guid NOT IN (" . implode(',', $favorite_guids) . ")";
	}
	/*
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
	*/
	if (elgg_is_active_plugin('au_subgroups')) {
		// Don't list subgroups here (they are now considered as workspaces)
		$db_prefix = elgg_get_config('dbprefix');
		$options['wheres'][] = "NOT EXISTS (SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "')";
	}
	$mygroups = elgg_get_entities_from_relationship($options);
	
	// My groups count
	$mygroups_count = elgg_get_entities_from_relationship($options + array('count' => true));
	if (sizeof($favorite_guids) > 0) { $mygroups_count += sizeof($favorite_guids); }
	
	// Display groups (favorites first)
	if ($mygroups) {
		$displayed = 0;
		foreach ($favorite_guids as $guid) {
			//$groups .= '<div class="iris-home-group">' . elgg_view_entity_icon($group, 'medium') . '</div>';
			$group = get_entity($guid);
			$group_url = elgg_get_site_url() . 'groups/workspace/' . $group->guid;
			if ($displayed < $max_groups) {
				$groups .= '<div class="iris-home-group float"><a href="' . $group_url . '"><img src="' . $group->getIconURL('medium') . '" alt="' . $group->name . '" title="' . $group->name . ' : ' . $group->briefdescription . '" /></a></div>';
			} else {
				$groups_more .= '<div class="iris-home-group float hidden"><a href="' . $group_url . '"><img src="' . $group->getIconURL('medium') . '" alt="' . $group->name . '" title="' . $group->name . ' : ' . $group->briefdescription . '" /></a></div>';
			}
			$displayed++;
		}
		foreach ($mygroups as $k => $group) {
			//$groups .= '<div class="iris-home-group">' . elgg_view_entity_icon($group, 'medium') . '</div>';
			$group_url = elgg_get_site_url() . 'groups/workspace/' . $group->guid;
			if ($displayed < $max_groups) {
				$groups .= '<div class="iris-home-group float"><a href="' . $group_url . '"><img src="' . $group->getIconURL('medium') . '" alt="' . $group->name . '" title="' . $group->name . ' : ' . $group->briefdescription . '" /></a></div>';
			} else {
				$groups_more .= '<div class="iris-home-group float hidden"><a href="' . $group_url . '"><img src="' . $group->getIconURL('medium') . '" alt="' . $group->name . '" title="' . $group->name . ' : ' . $group->briefdescription . '" /></a></div>';
			}
			$displayed++;
		}
	}
	
	// Lien pour créer un nouveau groupe
	//$groups .= '<div class="iris-home-group iris-home-group-add iris-user-groups-add float"><a href="' . elgg_get_site_url() . 'groups" title="">+</a></div>';
	
	// Add toggle for next groups
	if ($mygroups_count > $max_groups) {
		$count = $mygroups_count - $max_groups;
		$style = '';
		if (strlen((string)$count) > 2) { $style = 'font-size: 1rem; line-height: 1rem; padding-top: 0.7rem;'; }
		$groups .= '<div class="iris-home-group iris-home-group-add iris-user-groups-add float" style="' . $style . '"><a href="javascript:void(0);" onClick="javascript:$(\'.iris-home-group.hidden\').removeClass(\'hidden\'); $(this).parent().hide();" title="' . elgg_echo('theme_inria:viewall') . '">+' . $count . '</a></div>';
		//$groups .= '<div class="clearfloat"></div><p><a href="javascript:void(0);" onClick="javascript:$(\'.iris-home-group.hidden\').removeClass(\'hidden\'); $(this).hide();">' . elgg_echo('theme_inria:viewall') . '</a></p>';
	}
	
	// "Invitations" dans les groupes : affiché seulement s'il y a des invitations en attente
	$group_invites = groups_get_invited_groups(elgg_get_logged_in_user_guid());
	$invites_count = sizeof($group_invites);
	if ($invites_count > 0) {
		$groupinvites = '<div class="iris-home-group-invites">';
		if ($invites_count > 1) {
			$invites = '<p><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '</a></p>';
		} else {
			$invites = '<p><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '</a></p>';
		}
		$groupinvites = '</div>';
	}
}

echo '<div id="sidebar-my-groups">
		<h3><a href="' . elgg_get_site_url() . 'groups/member" title="' . elgg_echo('theme_inria:groups:mine:tooltip') . '">' . elgg_echo("theme_inria:mygroups") . ' &nbsp; &#9654;</a></h3>
		<div class="iris-home-my-groups">
			' . $groups . $groups_more . '
		</div>
		<div class="iris-home-my-groups-invites">
			' . $invites . '
		</div>
	</div>';

