<?php

	// Groupes
	$groups = '';
	if (elgg_is_active_plugin('groups')) {
		// Liste de ses groupes
		$options = array( 'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ownguid, 'inverse_relationship' => false, 'limit' => 99, 'order_by' => 'time_created asc');
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
		$mygroups = elgg_get_entities_from_relationship($options);
		foreach ($mygroups as $group) {
			//$groups .= '<div class="iris-home-group">' . elgg_view_entity_icon($group, 'medium') . '</div>';
			$groups .= '<div class="iris-home-group float"><img src="' . $group->getIconURL('medium') . '" alt="' . $group->name . '" title="' . $group->name . ' : ' . $group->briefdescription . '" /></div>';
		}
			$groups .= '<div class="iris-home-group iris-home-group-add iris-user-groups-add float"><a href="' . elgg_get_site_url() . 'groups/add" title="">+</a></div>';
		
		// "Invitations" dans les groupes : affiché seulement s'il y a des invitations en attente
		$group_invites = groups_get_invited_groups(elgg_get_logged_in_user_guid());
		$invites_count = sizeof($group_invites);
		if ($invites_count > 0) {
			$groupinvites = '<div class="iris-home-group-invites">';
			if ($invites_count > 1) {
				$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '">' . $invites_count . '</a></li>';
			} else {
				$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '">' . $invites_count . '</a></li>';
			}
			$groupinvites = '</div>';
		}
	}

echo '<div id="sidebar-my-groups">
	<h3><a href="' . elgg_get_site_url() . 'groups/mine" title="' . elgg_echo('theme_inria:groups:mine:tooltip') . '">' . elgg_echo("theme_inria:mygroups") . ' &nbsp; &#9654;</a></h3>
	' . $groups . '
	' . $invites . '
	</div>';

