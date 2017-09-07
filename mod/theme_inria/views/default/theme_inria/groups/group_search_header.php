<?php
$group = elgg_extract('entity', $vars);
$main_group = theme_inria_get_main_group($group);

$q = get_input('q');

// Espaces de travail : groupe principal + sous-groupes
// Note : on prend tous les sous-groupes qq soit le niveau - mais on ne pourra créer de nouveaux sous-groupes qu'au 1er niveau
//$group = AU\SubGroups\get_subgroups($group, 0);
$all_subgroups_guids = AU\SubGroups\get_all_children_guids($main_group);

$url = elgg_get_site_url();


$search_icon = $search_form = '';
$search_form = '<div class="iris-search-image"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M84.7 81.2L66.8 63.3c9.3-11.8 8.5-28.9-2.3-39.8 -5.7-5.7-13.2-8.8-21.2-8.8 -8 0-15.5 3.1-21.2 8.8 -5.7 5.7-8.8 13.2-8.8 21.2 0 8 3.1 15.5 8.8 21.2 5.8 5.8 13.5 8.8 21.2 8.8 6.6 0 13.2-2.2 18.6-6.4l17.9 17.9c0.7 0.7 1.6 1 2.5 1s1.8-0.3 2.5-1C86 84.8 86 82.6 84.7 81.2zM27 61c-4.3-4.3-6.7-10.1-6.7-16.3s2.4-11.9 6.7-16.3c4.3-4.3 10.1-6.7 16.3-6.7s11.9 2.4 16.3 6.7c4.3 4.3 6.7 10.1 6.7 16.3S63.9 56.7 59.5 61c-4.3 4.3-10.1 6.7-16.3 6.7S31.3 65.4 27 61z"/></svg></div>';
$search_form = '<div class="iris-search-quickform">';
	//$search_form .= elgg_view_form('search', $vars);
	
	$search_entity_type = '';
	$search_entity_type = 'object';
	
	// Main search term field - jQuerysynced with advanced search form input field
	$search_form .= '<form id="iris-search-quickform">';
		$search_form .= '<label for="iris-search-header-input" class="invisible">' . $search_text . '</label>';
		$search_form .= elgg_view('input/text', array('name' => 'q', 'id' => 'iris-search-header-input', 'value' => $q, 'placeholder' => $search_text));
		//$search_form .= '<noscript><input type="image" id="iris-topbar-search-submit" src="' . $urlicon . 'recherche.png" value="' . elgg_echo('esope:search') . '" /></noscript>';
		$search_form .= '<input type="reset" value="X">';
		$search_form .= '<noscript><button type="submit" id="iris-search-header-submit" title="' . elgg_echo('esope:search') . '"><i class="fa fa-search"></i></button></noscript>';
	$search_form .= '</form>';
$search_form .= '</div>';



$banner_css = '#424B5F';
if (!empty($group->banner)) {
	//$banner_css = "linear-gradient(rgba(66, 75, 95, 0.45), rgba(66, 75, 95, 0.45)), #424B5F url('{$url}groups/file/{$group->guid}/banner') no-repeat center/cover";
	$banner_css = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), #424B5F url('{$url}groups/file/{$group->guid}/banner?icontime={$group->bannertime}') no-repeat center/cover";
}
?>
<div class="iris-group-header" style="background: <?php echo $banner_css; ?>;">
	
	<div class="iris-group-image" style="background: white url('<?php echo $group->getIconURL(array('size' => 'large')); ?>') no-repeat center/cover;">
	</div>
	
	<div class="iris-group-title">
		<?php
		/*
		echo '<div class="iris-group-community">';
		if (!empty($group->community)) { echo elgg_echo('community') . ' ' . $group->community; }
		echo '</div>';
		*/
		echo '<h2 class="float">' . elgg_echo('theme_inria:search') . ' - ' . $group->name . '</h2>';
		if (!empty($q)) { echo '<span class="iris-search-q-results">' . elgg_echo('theme_inria:search:title', array($q)) . '</span>'; }
		echo '<div class="clearfloat"></div>';
		
		if (elgg_is_active_plugin('search')) { echo $search_form; }
		/*
		echo '<div class="iris-group-subtitle">' . $group->briefdescription . '</div>';
		echo '<div class="iris-group-rules">';
			// Community
			if (!empty($main_group->community)) { echo '<span class="iris-group-community">' . elgg_echo('community') . ' ' . $main_group->community . '</span>'; }
			// Access
			echo '<span class="group-access">' . elgg_echo('theme_inria:access:groups') . '&nbsp;: ' . elgg_view('output/access', array('entity' => $main_group)) . '</span>';
			// Membership
			echo '<span class="group-membership">' . elgg_echo('theme_inria:groupmembership') . '&nbsp;: ';
			if ($main_group->membership == ACCESS_PUBLIC) {
				//echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . ' - ' . elgg_echo("theme_inria:groupmembership:open:details");
				echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . '</span>';
			} else {
				//echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . ' - ' . elgg_echo("theme_inria:groupmembership:closed:details");
				echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . '</span>';
			}
			echo '</span>';
		echo '</div>';
		*/
		?>
	</div>
	
	<div class="iris-group-menu">
		<?php
		// Espaces de travail : si > 3 onglets, on en affiche 2 et le reste en sous-menu + limitation longueur du titre
		$max_title = 30;
		$max_title_more = 50;
		$more_tabs_threshold = 1; // Tabs in addition to main workspace tab (index)
		$add_more_tab = (sizeof($all_subgroups_guids) > $more_tabs_threshold+1);
		$more_tabs = '';
		$more_selected = false;
		
		// Current group home page
		if (current_page_url() == $group->getURL()) {
			echo '<a href="' . $group->getURL() . '" class="tab elgg-state-selected">' . elgg_echo('theme_inria:group:presentation') . '</a>';
		} else {
			echo '<a href="' . $group->getURL() . '" class="tab">' . elgg_echo('theme_inria:group:presentation') . '</a>';
		}
		
		// Main workspace
		$tab_class = '';
		if (($main_group->guid == $group->guid) && (current_page_url() != $group->getURL())) { $tab_class .= " elgg-state-selected"; }
		echo '<a href="' . $url . 'groups/workspace/' . $main_group->guid . '" class="tab' . $tab_class . '" title="' . $main_group->name . '">' . elgg_get_excerpt($main_group->name, $max_title) . '</a>';
		
		// Workspaces
		if (current_page_url() == $group->getURL()) {
			if ($all_subgroups_guids) {
				foreach($all_subgroups_guids as $k => $guid) {
					$ent = get_entity($guid);
					if ($add_more_tab && ($k >= $more_tabs_threshold)) {
						$more_tabs .= '<a href="' . $url . 'groups/workspace/' . $ent->guid . '" class="tab" title="' . $ent->name . '">' . elgg_get_excerpt($ent->name, $max_title_more) . '</a>';
					} else {
						echo '<a href="' . $url . 'groups/workspace/' . $ent->guid . '" class="tab" title="' . $ent->name . '">' . elgg_get_excerpt($ent->name, $max_title) . '</a>';
					}
				}
			}
		} else {
			// Workspaces
			if ($all_subgroups_guids) {
				foreach($all_subgroups_guids as $k => $guid) {
					$ent = get_entity($guid);
					$workspace_url = $url . 'groups/workspace/' . $ent->guid;
					$tab_class = '';
					if ($ent->guid == $group->guid) { $tab_class .= " elgg-state-selected"; $more_selected = true; }
					$title_excerpt = elgg_get_excerpt($ent->name, $max_title);
					if ($add_more_tab && ($k >= $more_tabs_threshold)) {
						$title_excerpt = elgg_get_excerpt($ent->name, $max_title_more);
						$more_tabs .= '<a href="' . $workspace_url . '" class="tab' . $tab_class . '" title="' . $ent->name . '">' . $title_excerpt . '</a>';
					} else {
						echo '<a href="' . $workspace_url . '" class="tab' . $tab_class . '" title="' . $ent->name . '">' . $title_excerpt . '</a>';
					}
				}
			}
		}
		if ($add_more_tab) {
			if ($more_selected) {
				echo '<span class="tab tab-more active">';
			} else {
				echo '<span class="tab tab-more">';
			}
			echo '<a href="javascript:void(0);" onClick="javascript:$(\'.iris-group-menu .tab-more-content\').toggleClass(\'hidden\')">' . elgg_echo('theme_inria:workspaces:more', array((sizeof($all_subgroups_guids) - $more_tabs_threshold))) . '</a>
					<div class="tab-more-content hidden">' . $more_tabs . '</div>
			</span>';
		}
		
		// Group search
		if (elgg_is_active_plugin('search')) {
			//echo '<a href="' . $url . 'groups/search/' . $group->guid . '" class="search float-alt"><i class="fa fa-search"></i></a>';
			echo '<a href="javascript:void(0);" class="search float-alt"><i class="fa fa-search"></i></a>';
		}
		
		// New subgroup (of level 1)
		if (elgg_is_active_plugin('au_subgroups') && ($main_group->subgroups_enable == 'yes')) {
			echo '<a href="' . $url . 'groups/subgroups/add/' . $main_group->guid . '" class="add float-alt">+&nbsp;' . elgg_echo('theme_inria:group:workspace:add') . '</a>';
		}
		?>
	</div>
	
</div>

