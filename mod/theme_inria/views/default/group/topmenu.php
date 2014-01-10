<?php
$group = $vars['entity'];
$group_filter = get_input('groupfilter', '');

echo '<div class="group-top-menu">';

$tabs['home'] = array(
	'text' => "Présentation",
	'href' => $group->getURL(),
	'selected' => ($group_filter == ''),
	'priority' => 200,
);

$tabs['articles'] = array(
	'text' => "Articles",
	'href' => $group->getURL() . '?groupfilter=articles',
	'selected' => ($group_filter == 'articles'),
	'priority' => 300,
);

// If forum enabled
$tabs['discussion'] = array(
	'text' => "Discussion",
	'href' => $group->getURL() . '?groupfilter=discussion',
	'selected' => ($group_filter == 'discussion'),
	'priority' => 300,
);

// If files or bookmarks enabled
$tabs['ressources'] = array(
	'text' => "Ressources",
	'href' => $group->getURL() . '?groupfilter=ressources',
	'selected' => ($group_filter == 'ressources'),
	'priority' => 300,
);

// If wiki enabled
/*
$tabs['pages'] = array(
	'text' => "Discussion",
	'href' => $group->getURL() . '?groupfilter=discussion',
	'selected' => ($group_filter == 'discussion'),
	'priority' => 300,
);
*/

// Build action menu
if (isset($CONFIG->menus['title'])) { $groupmenus = $CONFIG->menus['title']; } else { $menu = array(); }
foreach ($groupmenus as $menu) {
	$tab['name'] = $menu->name;
	$menu->setItemClass('grouptab-action');
	$menu->setLinkClass('grouptab-action-link');
	$menu->setWeight(800);
	elgg_register_menu_item('filter', $menu);
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
	elgg_register_menu_item('filter', $tab);
}

// Group menu actions goes to the right
echo elgg_view_menu('title', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
// Group menu tabs go to the left
echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

echo '</div>';


