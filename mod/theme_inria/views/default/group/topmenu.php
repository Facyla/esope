<?php
$group = $vars['entity'];
$group_filter = get_input('groupfilter', '');
$context = elgg_get_context();

//global $CONFIG;
//echo print_r($CONFIG->context, true);

echo '<div class="group-top-menu">';

$tabs['home'] = array(
	'text' => elgg_echo('theme_inria:groups:presentation'),
	'href' => $group->getURL(),
	'selected' => ($context == 'group_profile'),
	'priority' => 200,
);

/*
// If blog enabled
if ($group->blog_enable == 'yes') 
$tabs['articles'] = array(
	'text' => elgg_echo('theme_inria:groups:blog'),
	'href' => $vars['url'] . 'blog/group/' . $group->guid . '/all',
	'selected' => (elgg_in_context('blog')),
	'priority' => 300,
);

// If forum enabled
if ($group->forum_enable == 'yes') 
$tabs['discussion'] = array(
	'text' => elgg_echo('theme_inria:groups:forum'),
	'href' => $vars['url'] . 'discussion/owner/' . $group->guid,
	'selected' => (elgg_in_context('discussion')),
	'priority' => 300,
);
*/

// If files or bookmarks enabled
// Files are always active, even if the "tool" is disabled (can be embedded)
//if (($group->bookmarks_enable == 'yes') || ($group->file_enable == 'yes')) 
$tabs['ressources'] = array(
	'text' => elgg_echo('theme_inria:groups:ressources'),
	'href' => $vars['url'] . 'ressources/group/' . $group->guid . '/all',
	'selected' => (elgg_in_context('ressources') || elgg_in_context('files') || elgg_in_context('bookmarks')),
	'priority' => 300,
);

/*
// If wiki enabled
if ($group->pages_enable == 'yes') 
$tabs['pages'] = array(
	'text' => elgg_echo('theme_inria:groups:pages'),
	'href' => $vars['url'] . 'pages/group/' . $group->guid . '/all',
	'selected' => (elgg_in_context('pages')),
	'priority' => 300,
);
*/


// CUSTOM TABS
// Note : requires that customtab1 to 5 are configured in some way (easiest : custom group field)

// Custom tab #1
if (!empty($group->customtab1)) {
	$tabinfo = explode('::', $group->customtab1);
	$tabs['customtab1'] = array(
		'href' => $tabinfo[0], 'text' => $tabinfo[1], 'title' => str_replace('"', "'", $tabinfo[2]),
		'selected' => (full_url() == $tabinfo[0]), 'priority' => 300,
	);
	if (esope_is_external_link($tabinfo[0])) $tabs['customtab1']['target'] = '_blank';
}

// Custom tab #2
if (!empty($group->customtab2)) {
	$tabinfo = explode('::', $group->customtab2);
	$tabs['customtab2'] = array(
		'href' => $tabinfo[0], 'text' => $tabinfo[1], 'title' => str_replace('"', "'", $tabinfo[2]),
		'selected' => (full_url() == $tabinfo[0]), 'priority' => 300,
	);
	if (esope_is_external_link($tabinfo[0])) $tabs['customtab2']['target'] = '_blank';
}

// Custom tab #3
if (!empty($group->customtab3)) {
	$tabinfo = explode('::', $group->customtab3);
	$tabs['customtab3'] = array(
		'href' => $tabinfo[0], 'text' => $tabinfo[1], 'title' => str_replace('"', "'", $tabinfo[2]),
		'selected' => (full_url() == $tabinfo[0]), 'priority' => 300,
	);
	if (esope_is_external_link($tabinfo[0])) $tabs['customtab3']['target'] = '_blank';
}

// Custom tab #4
if (!empty($group->customtab4)) {
	$tabinfo = explode('::', $group->customtab4);
	$tabs['customtab4'] = array(
		'href' => $tabinfo[0], 'text' => $tabinfo[1], 'title' => str_replace('"', "'", $tabinfo[2]),
		'selected' => (full_url() == $tabinfo[0]), 'priority' => 300,
	);
	if (esope_is_external_link($tabinfo[0])) $tabs['customtab4']['target'] = '_blank';
}

// Custom tab #5
if (!empty($group->customtab5)) {
	$tabinfo = explode('::', $group->customtab4);
	$tabs['customtab5'] = array(
		'href' => $tabinfo[0], 'text' => $tabinfo[1], 'title' => str_replace('"', "'", $tabinfo[2]),
		'selected' => (full_url() == $tabinfo[0]), 'priority' => 300,
	);
	if (esope_is_external_link($tabinfo[0])) $tabs['customtab5']['target'] = '_blank';
}

// Partage folder
if (!empty($group->cmisfolder)) {
	$tabinfo = explode('::', $group->cmisfolder);
	// Forme d'une URL de partage : share/page/folder-details?nodeRef=workspace://SpacesStore/ + identifiant Alfresco
	$needle = 'SpacesStore/';
	// Keep only useful info if full URL was provided
	if (strrpos($tabinfo[0], $needle) !== false) {
		$folder_parts = explode($needle, $tabinfo[0]);
		$folder = end($folder_parts);
		// We have a valid URL : now determine title, and finally add new tab
		if (!empty($folder)) {
			if (!empty($tabinfo[1])) { $text = $tabinfo[1]; } else { $text = elgg_echo('elgg_cmis:widget:cmis_folder'); }
			$tabs['cmisfolder'] = array(
				'href' => $tabinfo[0], 'text' => $text, 'title' => str_replace('"', "'", $tabinfo[2]),
				'selected' => (full_url() == $tabinfo[0]), 'priority' => 300,
			);
			if (esope_is_external_link($tabinfo[0])) $tabs['cmisfolder']['target'] = '_blank';
		}
	}
}


// Build action menu
if (elgg_in_context('group_profile')) {
	if (isset($CONFIG->menus['title'])) { $groupmenus = $CONFIG->menus['title']; } else { $menu = array(); }
	$weight = 500;
	if ($groupmenus) foreach ($groupmenus as $menu) {
		$menu->class = null; // Clears remaining link classes (elgg-button-action...)
		$menu->setItemClass('grouptab-action');
		$menu->setLinkClass('grouptab-action-link');
		$menu->setWeight($weight);
		$weight--; // Keep ordering (would be inverted otherwise, as menus float right)
		elgg_register_menu_item('group_filter', $menu);
	}
}


foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;
	elgg_register_menu_item('group_filter', $tab);
}

// Group menu actions goes to the right
//echo elgg_view_menu('title', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz elgg-menu-right'));
// Group menu tabs go to the left
echo elgg_view_menu('group_filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

echo '</div>';


