<?php
$group = elgg_extract('entity', $vars);
$group_name = elgg_get_excerpt($group->name, 50);

$q = get_input('q');

$url = elgg_get_site_url();

$icon_field = $banner_field = '';
// Edition des icônes du groupe : ssi ds le group principal
if (elgg_in_context('group_edit') && ($group->guid == $group->guid) && $group->canEdit()) {
	$icon_field = '<label for="icon">
			<i class="fa fa-camera"></i><br />' . elgg_echo('groups:icon:inline') . '
		</label>';
	$banner_field = '<label for="banner">
			<i class="fa fa-camera"></i><br />' . elgg_echo('groups:banner:inline') . '
		</label>';
}

$search_icon = $search_form = '';
if (elgg_in_context('search')) {
	$search_form = '<div class="iris-search-image"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M84.7 81.2L66.8 63.3c9.3-11.8 8.5-28.9-2.3-39.8 -5.7-5.7-13.2-8.8-21.2-8.8 -8 0-15.5 3.1-21.2 8.8 -5.7 5.7-8.8 13.2-8.8 21.2 0 8 3.1 15.5 8.8 21.2 5.8 5.8 13.5 8.8 21.2 8.8 6.6 0 13.2-2.2 18.6-6.4l17.9 17.9c0.7 0.7 1.6 1 2.5 1s1.8-0.3 2.5-1C86 84.8 86 82.6 84.7 81.2zM27 61c-4.3-4.3-6.7-10.1-6.7-16.3s2.4-11.9 6.7-16.3c4.3-4.3 10.1-6.7 16.3-6.7s11.9 2.4 16.3 6.7c4.3 4.3 6.7 10.1 6.7 16.3S63.9 56.7 59.5 61c-4.3 4.3-10.1 6.7-16.3 6.7S31.3 65.4 27 61z"/></svg></div>';
	$search_form = '<div class="iris-search-quickform">
			<h2>' . elgg_echo('search') . '</h2>';
			
		if (!empty($q)) { $search_form .= '<span class="iris-search-q-results">' . elgg_echo('theme_inria:search:title', array($q)) . '</span>'; }
			//$search_form .= elgg_view_form('search', $vars);
			
			$search_entity_type = '';
			if (elgg_in_context('groups')) {
				$search_entity_type = 'group';
			} else if (elgg_in_context('members')) {
				$search_entity_type = 'user';
			} else if (elgg_in_context('objects')) {
				$search_entity_type = 'object';
			}
			
			// Main search term field - jQuerysynced with advanced search form input field
			$search_form .= '<form id="iris-search-quickform">';
				$search_form .= '<label for="iris-search-header-input" class="invisible">' . $search_text . '</label>';
				$search_form .= elgg_view('input/text', array('name' => 'q', 'id' => 'iris-search-header-input', 'value' => $q, 'placeholder' => $search_text));
				//$search_form .= '<noscript><input type="image" id="iris-topbar-search-submit" src="' . $urlicon . 'recherche.png" value="' . elgg_echo('esope:search') . '" /></noscript>';
				$search_form .= '<input type="reset" value="X">';
				$search_form .= '<noscript><button type="submit" id="iris-search-header-submit" title="' . elgg_echo('esope:search') . '"><i class="fa fa-search"></i></button></noscript>';
			$search_form .= '</form>';
		$search_form .= '</div>';
}


$banner_css = '#424B5F';
if (!empty($group->banner)) {
	//$banner_css = "linear-gradient(rgba(66, 75, 95, 0.45), rgba(66, 75, 95, 0.45)), #424B5F url('{$url}groups/file/{$group->guid}/banner') no-repeat center/cover";
	$banner_css = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), #424B5F url('{$url}groups/file/{$group->guid}/banner?icontime={$group->bannertime}') no-repeat center/cover";
}
?>
<div class="iris-group-header" style="background: <?php echo $banner_css; ?>;">
	<?php echo $banner_field; ?>
	
	<div class="iris-group-image" style="background: white url('<?php echo $group->getIconURL(array('size' => 'large')); ?>') no-repeat center/cover;">
		<?php echo $icon_field; ?>
	</div>
	
	<div class="iris-group-title">
		
		<?php
		// Membership to main group
		$actions_content = '';
		if (!elgg_in_context('group_edit') && !elgg_in_context('group_members') && !elgg_in_context('group_invites') && !elgg_in_context('group_members')) {
			// group members
			if ($group->isMember() || elgg_is_admin_logged_in()) {
				/*
				if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
					// leave
					$actions_content .= elgg_view('output/url', array(
							'href' => $url . "action/groups/leave?group_guid={$group->guid}",
							'text' => '<i class="fa fa-sign-out"></i>',
							'title' => elgg_echo('groups:leave'),
							'class' => "group-leave",
							'is_action' => true,
						));
				}
				*/
			} elseif (elgg_is_logged_in()) {
				// join - admins can always join.
				if ($group->isPublicMembership() || $group->canEdit()) {
					$actions_content .= elgg_view('output/url', array(
							'href' => $url . "action/groups/join?group_guid={$group->guid}",
							'text' => '<i class="fa fa-sign-in"></i>',
							'title' => elgg_echo('groups:join'),
							'class' => "group-join",
							'is_action' => true,
						));
				} else {
					// request membership
					$actions_content .= elgg_view('output/url', array(
							'href' => $url . "action/groups/join?group_guid={$group->guid}",
							'text' => '<i class="fa fa-sign-in"></i>',
							'title' => elgg_echo('groups:joinrequest'),
							'class' => "group-request",
							'is_action' => true,
						));
				}
			}
		}
		if (!empty($actions_content)) {
			echo '<div class="group-membership-actions">' . $actions_content . '</div>';
		}
		
		echo '<h2>' . $group_name . '</h2>';
		echo '<div class="iris-group-subtitle">' . elgg_get_excerpt($group->briefdescription) . '</div>';
		echo '<div class="iris-group-rules">';
			// Community
			if (!empty($group->community)) { echo '<span class="iris-group-community">' . elgg_echo('community') . ' ' . $group->community . '</span>'; }
			// Access
			echo '<span class="group-access">' . elgg_echo('theme_inria:access:groups') . '&nbsp;: ' . elgg_view('output/access', array('entity' => $group)) . '</span>';
			// Membership
			echo '<span class="group-membership">' . elgg_echo('theme_inria:groupmembership') . '&nbsp;: ';
			if ($group->membership == ACCESS_PUBLIC) {
				//echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . ' - ' . elgg_echo("theme_inria:groupmembership:open:details");
				echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . '</span>';
			} else {
				//echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . ' - ' . elgg_echo("theme_inria:groupmembership:closed:details");
				echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . '</span>';
			}
			echo '</span>';
		echo '</div>';
		?>
	</div>
	
	
	<div class="iris-group-menu">
		<?php
		// Espaces de travail : si > 3 onglets, on en affiche 2 et le reste en sous-menu + limitation longueur du titre
		$max_title = 30;
		$max_title_more = 50;
		$more_tabs_threshold = 0; // Tabs in addition to main workspace tab (index)
		$more_tabs = '';
		$more_selected = false;
		
		// Main group presentation page
		if (current_page_url() == $group->getURL() || (($group->guid == $group->guid) && (elgg_in_context('group_edit') || elgg_in_context('group_members') || elgg_in_context('group_invites')))) {
			echo '<a href="' . $group->getURL() . '" class="tab elgg-state-selected">' . elgg_echo('theme_inria:group:presentation') . '</a>';
		} else {
			echo '<a href="' . $group->getURL() . '" class="tab">' . elgg_echo('theme_inria:group:presentation') . '</a>';
		}
		
		if ($group->isMember() || elgg_is_admin_logged_in()) {
			// Main workspace
			$tab_class = '';
			if (($group->guid == $group->guid) && (current_page_url() != $group->getURL()) && !elgg_in_context('group_edit') && !elgg_in_context('group_members') && !elgg_in_context('group_invites')) { $tab_class .= " elgg-state-selected"; }
			//echo '<a href="' . $url . 'groups/workspace/' . $group->guid . '" class="tab' . $tab_class . '" title="' . $group->name . '">' . elgg_get_excerpt($group->name, $max_title) . '</a>';
			$workspace_name = $group->workspace_name; // Custom title
			if (empty($workspace_name)) { $workspace_name = elgg_echo('theme_inria:workspace:main'); }
			echo '<a href="' . $url . 'groups/workspace/' . $group->guid . '" class="tab' . $tab_class . '" title="' . elgg_echo('workspace:title:main', array($group->name)) . '">' . $workspace_name . '</a>';
		}
		
		// Group search
		if (elgg_is_active_plugin('search')) {
			echo '<a href="' . $url . 'groups/search/' . $group->guid . '" class="search float-alt"><i class="fa fa-search"></i></a>';
		}
		
		// New subgroup (of level 1)
		if (elgg_is_active_plugin('au_subgroups') && !elgg_in_context('group_edit') && ($group->guid == $group->guid) && ($group->subgroups_enable == 'yes') && ($group->canEdit() || ($group->isMember() && ($group->subgroups_members_create_enable == 'yes')))) {
			echo '<a href="' . $url . 'groups/subgroups/add/' . $group->guid . '" class="add float-alt">' . elgg_echo('theme_inria:group:workspace:add') . '</a>';
			// <i class="fa fa-plus-square-o"></i>&nbsp;
		}
		?>
	</div>
	
</div>

