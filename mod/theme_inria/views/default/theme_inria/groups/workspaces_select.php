<?php
// Workspaces tabs

$main_group = elgg_extract('main_group', $vars);
$group = elgg_extract('group', $vars);
$link_type = elgg_extract('link_type', $vars, 'home'); // home (default), workspace, invite, edit, members

$max_title = elgg_extract('max_title', $vars, 30);

$all_subgroups_guids = AU\SubGroups\get_all_children_guids($main_group);

$url = elgg_get_site_url();

$workspaces_select = '';
//$workspaces_select .= '<label for="group-switch">' . elgg_echo('theme_inria:group:switch') . '</label>';


$workspaces_opt = array();

// Main workspace
$opt_url = theme_inria_get_group_tab_url($main_group, $link_type);
if ($group->guid == $main_group->guid) {
	$workspaces_opt[$opt_url] = elgg_echo('theme_inria:workspace:title:current', array($main_group->name));
	$value = $opt_url;
} else {
	$workspaces_opt[$opt_url] = elgg_echo('theme_inria:workspace:title:main', array($main_group->name));
}

// Options des sous-groupes
if ($all_subgroups_guids) {
	foreach($all_subgroups_guids as $k => $guid) {
		$ent = get_entity($guid);
		$opt_url = theme_inria_get_group_tab_url($ent, $link_type);
		//$title_excerpt = elgg_get_excerpt($ent->name, $max_title);
		if ($ent->guid == $group->guid) {
			$workspaces_opt[$opt_url] = elgg_echo('theme_inria:workspace:title:current', array($ent->name));
			$value = $opt_url;
		} else {
			$workspaces_opt[$opt_url] = elgg_echo('theme_inria:workspace:title', array($ent->name));
		}
	}
}

$workspaces_select .= elgg_view('input/select', array(
		'name' => "group-switch",
		'id' => "group-switch",
		'value' => $value,
		'options_values' => $workspaces_opt,
		'onChange' => "javascript:window.location = $(this).val(); return false;",
		'class' => "",
		'style' => "",
	));

echo '<div class="group-workspace-select">' . $workspaces_select . '</div>';

