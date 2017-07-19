<?php 
/**
 * Group entity view
 * 
 * @package ElggGroups
 */

$group = $vars['entity'];

//$icon = elgg_view_entity_icon($group, 'tiny');
// Iris : bigger images
$size = 'tiny';
if (elgg_in_context('search')) { $size = 'large'; }

$group_url = $group->getURL();
if ($group->isMember()) { $group_url = elgg_get_site_url() . 'groups/workspace/' . $group->guid; }
//$icon = elgg_view_entity_icon($entity, $size, $vars);
$icon = '<a href="' . $group_url . '"><img src="' . $group->getIconUrl(array('size' => $size)) . '" alt="' . $group->name . '"></a>';


if (elgg_in_context('search')) {
	$metadata = '<ul class="elgg-menu elgg-menu-entity elgg-menu-hz elgg-menu-entity-default">';
		
		// Access
		$metadata .= '<li class="group-access">' . elgg_view('output/access', array('entity' => $group)) . '</li>';
		
		// Nb de membres
		$all_members = $group->getMembers(array('count' => true));
		$members_count = $group->getMembers(array('count' => true, 'wheres' => array(theme_inria_active_members_where_clause())));
		$members = $group->getMembers(array('wheres' => array(theme_inria_active_members_where_clause())));
		$members_string = elgg_echo('theme_inria:groups:entity_menu:noinactive', array($all_members));
		if ($all_members != $members_count) {
			if ($members_count > 1) {
				$members_string = elgg_echo('theme_inria:groups:entity_menu', array($all_members, $members_count));
			} else {
				if ($all_members > 1) {
					$members_string = elgg_echo('theme_inria:groups:entity_menu:singular', array($all_members, $members_count));
				} else {
					$members_string = elgg_echo('theme_inria:groups:entity_menu:none', array($all_members, $members_count));
				}
			}
		}
		$metadata .= '<li class="members-count">' . $members_string . '</li>';
				$metadata .= '';
		// Type adhésion ou déjà membre
		if ($group->isMember()) {
			$metadata .= '<li class="already-member">' . elgg_echo('theme_inria:group:alreadymember') . '&nbsp;<i class="fa fa-check-circle"></i>' . '</li>';
		} else {
			// Membership
			//$metadata .= elgg_echo('theme_inria:groupmembership') . '&nbsp;: ';
			if ($group->membership == ACCESS_PUBLIC) {
				$metadata .= '<li class="membership-group-open" title="' . elgg_echo("theme_inria:groupmembership:open:details") . '">' . elgg_echo("theme_inria:groupmembership:open") . '</li>';
			} else {
				$metadata .= '<li class="membership-group-closed" title="' . elgg_echo("theme_inria:groupmembership:closed:details") . '">' . elgg_echo("theme_inria:groupmembership:closed") . '</li>';
			}
		}
		
	$metadata .= '</ul>';
} else {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $group,
		'handler' => 'groups',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

// Group tools support adds one condition - but won't block if plugin disabled
//if (elgg_in_context('owner_block') || elgg_in_context('widgets')) {
if ((elgg_in_context('owner_block') || elgg_in_context('widgets')) && !elgg_in_context("widgets_groups_show_members")) {
	$metadata = '';
}


if ($vars['full_view']) {
	echo elgg_view('groups/profile/summary', $vars);
} else {
	// brief view
	$params = array(
		'entity' => $group,
		'metadata' => $metadata,
		//'subtitle' => $group->briefdescription,
	);
	$params = $params + $vars;
	$list_body = elgg_view('group/elements/summary', $params);

	echo elgg_view_image_block($icon, $list_body, $vars);
}
