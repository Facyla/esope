<?php
// Workspaces tabs

$main_group = elgg_extract('main_group', $vars);
$group = elgg_extract('group', $vars);
$link_type = elgg_extract('link_type', $vars, 'home'); // home (default), workspace, invite, edit, members

$max_title = elgg_extract('max_title', $vars, 15);
$max_title_more = elgg_extract('max_title_more', $vars, 30);
$more_tabs_threshold = elgg_extract('more_tabs_threshold', $vars, 1);

$all_subgroups_guids = AU\SubGroups\get_all_children_guids($main_group);
$add_more_tab = (sizeof($all_subgroups_guids) > $more_tabs_threshold+1);

$url = elgg_get_site_url();

$workspaces_tabs = '';
$workspaces_tabs .= '<div class="group-workspace-tabs"><ul class="elgg-tabs elgg-htabs">';
	
	// Main workspace
	if ($group->guid == $main_group->guid) { $workspaces_tabs .= '<li class="elgg-state-selected">'; } else { $workspaces_tabs .= '<li>'; }
	$main_group_url = theme_inria_get_group_tab_url($main_group, $link_type);
	$workspaces_tabs .= '<a href="' . $main_group_url . '" title="' . elgg_echo('theme_inria:workspace:title', array($main_group->name)) . '">' . elgg_get_excerpt($main_group->name, $max_title) . '</a></li>';
	// Onglets des sous-groupes
	// Note : on prend tous les sous-groupes qq soit le niveau - mais on ne pourra créer de nouveaux sous-groupes qu'au 1er niveau
	// Espaces de travail : si > 3 onglets, on en affiche 2 et le reste en sous-menu + limitation longueur du titre
	$more_tabs = '';
	$more_selected = false;
	if ($all_subgroups_guids) {
		foreach($all_subgroups_guids as $k => $guid) {
			$ent = get_entity($guid);
			$tab_url = theme_inria_get_group_tab_url($ent, $link_type);
			$title_excerpt = elgg_get_excerpt($ent->name, $max_title);
			$tab_class = '';
			if ($ent->guid == $group->guid) { $tab_class .= "elgg-state-selected"; }
			if ($add_more_tab && ($k >= $more_tabs_threshold)) {
				if ($ent->guid == $group->guid) { $more_selected = true; }
				$title_excerpt = elgg_get_excerpt($ent->name, $max_title_more);
				$more_tabs .= '<li class="' . $tab_class . '"><a href="' . $tab_url . '" title="' . elgg_echo('theme_inria:workspace:title', array($ent->name)) . '">' . $title_excerpt . '</a></li>';
			} else {
				$workspaces_tabs .= '<li class="' . $tab_class . '"><a href="' . $tab_url . '" title="' . elgg_echo('theme_inria:workspace:title', array($ent->name)) . '">' . $title_excerpt . '</a></li>';
			}
			
		}
	}
	if ($add_more_tab) {
		if ($more_selected) {
			$workspaces_tabs .= '<li class="tab tab-more active">';
		} else {
			$workspaces_tabs .= '<li class="tab tab-more">';
		}
		$workspaces_tabs .= '<a href="javascript:void(0);" onClick="javascript:$(this).parent().toggleClass(\'elgg-state-selected\'); $(this).parent().find(\'.tab-more-content\').toggleClass(\'hidden\')">' . elgg_echo('theme_inria:workspaces:more', array((sizeof($all_subgroups_guids) - $more_tabs_threshold))) . '</a>
				<ul class="tab-more-content hidden">' . $more_tabs . '</ul>
		</li>';
	}
	
$workspaces_tabs .= '</ul></div>';


echo $workspaces_tabs;

