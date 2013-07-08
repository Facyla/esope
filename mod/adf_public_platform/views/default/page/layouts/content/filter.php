<?php
/**
 * Main content filter
 *
 * Select between user, friends, and all content
 *
 * @uses $vars['filter_context']  Filter context: all, friends, mine
 * @uses $vars['filter_override'] HTML for overriding the default filter (override)
 * @uses $vars['context']         Page context (override)
 */

if (isset($vars['filter_override'])) {
	echo $vars['filter_override'];
	return true;
}

$context = elgg_extract('context', $vars, elgg_get_context());

if (elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');
	
	// Add choice to disable some filter
	$disable_friends = elgg_get_plugin_setting('disable_friends', 'adf_public_platform');
	$disable_mine = elgg_get_plugin_setting('disable_mine', 'adf_public_platform');
	$disable_all = elgg_get_plugin_setting('disable_all', 'adf_public_platform');

	// generate a list of default tabs
	if ($disable_all != 'yes') {
		$tabs['all'] = array(
				'text' => elgg_echo('all'),
				'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
				'selected' => ($filter_context == 'all'),
				'priority' => 200,
			);
	}
	if ($disable_mine != 'yes') {
		$tabs['mine'] = array(
			'text' => elgg_echo('mine'),
			'href' => (isset($vars['mine_link'])) ? $vars['mine_link'] : "$context/owner/$username",
			'selected' => ($filter_context == 'mine'),
			'priority' => 300,
		);
	}
	$disable_friends = elgg_get_plugin_setting('disable_friends', 'adf_public_platform');
	if ($disable_friends != 'yes') {
		$tabs['friend'] = array(
			'text' => elgg_echo('friends'),
			'href' => (isset($vars['friend_link'])) ? $vars['friend_link'] : "$context/friends/$username",
			'selected' => ($filter_context == 'friends'),
			'priority' => 400,
		);
	}
	
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		
		elgg_register_menu_item('filter', $tab);
	}

	echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
