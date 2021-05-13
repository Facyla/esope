<?php
/**
 * Elgg owner block
 * Displays page ownership information
 *
 * @uses $vars['show_owner_block_menu'] (bool) Show the owner_block menu for the current page owner (default: true)
 */

// groups and other users get owner block
$owner = elgg_get_page_owner_entity();
if (!($owner instanceof ElggGroup || $owner instanceof ElggUser)) {
	return;
}

elgg_push_context('owner_block');

// @TODO : Autant le refaire avec image de fond ?
$header = elgg_view_entity($owner, [
	'item_view' => 'object/elements/chip',
	'icon' => elgg_view_entity_icon($owner, 'large'),
]);

$extra_class = '';
$body = '';

// Group search
//if ($owner instanceof ElggGroup && !elgg_in_context('group_profile')) {
if ($owner instanceof ElggGroup) {
	if (elgg_is_active_plugin('search')) {
		// Search for content in this group
		$group_search = elgg_view_form('groups/search', [
			'action' => 'search',
			'method' => 'get',
			'disable_security' => true,
			'prevent_double_submit' => true,
		], ['entity' => $owner] + $vars);
		$body .= '<h4>' . elgg_echo('groups:search_in_group') . '</h4>' . $group_search;
	}
}

if (elgg_extract('show_owner_block_menu', $vars, true)) {
	$menu_params = elgg_extract('owner_block_menu_params', $vars, []);
	$menu_params['entity'] = $owner;

	$body .= elgg_view_menu('owner_block', $menu_params);
} else {
	$extra_class = 'elgg-owner-block-empty';
}

if (elgg_view_exists('page/elements/owner_block/extend')) {
	$body .= elgg_view('page/elements/owner_block/extend', $vars);
}

echo elgg_view_module('info', '', $body, [
	'header' => $header,
	'class' => ['elgg-owner-block', $extra_class],
]);

elgg_pop_context();
