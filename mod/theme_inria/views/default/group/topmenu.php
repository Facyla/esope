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

// If files or bookmarks enabled
if (($group->bookmarks_enable == 'yes') || ($group->file_enable == 'yes')) 
$tabs['ressources'] = array(
	'text' => elgg_echo('theme_inria:groups:ressources'),
	'href' => $vars['url'] . 'ressources/group/' . $group->guid . '/all',
	'selected' => (elgg_in_context('ressources') || elgg_in_context('files') || elgg_in_context('bookmarks')),
	'priority' => 300,
);

// If wiki enabled
if ($group->pages_enable == 'yes') 
$tabs['pages'] = array(
	'text' => elgg_echo('theme_inria:groups:pages'),
	'href' => $vars['url'] . 'pages/group/' . $group->guid . '/all',
	'selected' => (elgg_in_context('pages')),
	'priority' => 300,
);

// Build action menu
if (isset($CONFIG->menus['title'])) { $groupmenus = $CONFIG->menus['title']; } else { $menu = array(); }
$weight = 500;
if ($groupmenus) foreach ($groupmenus as $menu) {
	$menu->class = null; // Clears remaining link classes (elgg-button-action...)
	$menu->setItemClass('grouptab-action');
	$menu->setLinkClass('grouptab-action-link');
	$menu->setWeight($weight);
	$weight--; // Keep ordering (would be inverted otherwise, as menus floats right)
	elgg_register_menu_item('group_filter', $menu);
	/*
		$tabs[$menu->name] = array(
			'text' => $menu->text,
			'href' => $menu->href,
			'selected' => false,
			'priority' => 800,
			'style' => 'float:right;',
		);
	*/
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


