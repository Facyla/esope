<?php 
/**
 * Group entity view
 * 
 * @package ElggGroups
 */

$group = $vars['entity'];
$ownguid = elgg_get_logged_in_user_guid();

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
		if ($members_count > 1) {
			$members_text = elgg_echo('theme_inria:groups:entity_menu:title', array($members_count));
		} else {
			$members_text = elgg_echo('theme_inria:groups:entity_menu:title:singular', array($members_count));
		}
		if ($all_members != $members_count) {
			if ($members_count > 1) {
				$members_title = elgg_echo('theme_inria:groups:entity_menu', array($all_members, $members_count));
			} else {
				if ($all_members > 1) {
					$members_title = elgg_echo('theme_inria:groups:entity_menu:singular', array($all_members, $members_count));
				} else {
					$members_title = elgg_echo('theme_inria:groups:entity_menu:none', array($all_members, $members_count));
				}
			}
		} else {
			if ($all_members > 1) {
				$members_title = elgg_echo('theme_inria:groups:entity_menu:noinactive', array($all_members));
			} else {
				$members_title = elgg_echo('theme_inria:groups:entity_menu:noinactive:singular', array($all_members));
			}
		}
		$metadata .= '<li class="members-count" title="' . $members_title . '">' . $members_text . '</li>';
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
	
	
	// User favorites groups
	// @TODO limit to 4 groups ?
	if ($group->isMember()) {
		if (check_entity_relationship($group->guid, 'favorite', $ownguid)) {
			$pin_title = elgg_echo('favorite:group:remove:title');
			$pin_text = '<i class="fa fa-star"></i>&nbsp;' . elgg_echo('favorite:group:remove');
		} else {
			$pin_title = elgg_echo('favorite:group:add:title');
			$pin_text = '<i class="fa fa-star-o"></i>&nbsp;' . elgg_echo('favorite:group:add');
		}
		//echo '<div class="favorite-group float-alt">' . elgg_view('output/url', array(
		$actions = '<div class="iris-object-actions"><ul class="elgg-menu-entity-alt float-alt"><li class="favorite-group">' . elgg_view('output/url', array(
				'href' => "action/theme_inria/favorite?guid={$group->guid}",
				'text' => $pin_text,
				'title' => $pin_title,
				'is_action' => true,
			)) . '</li></ul></div>';
	}
	
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
	$list_body .= $actions;

	echo elgg_view_image_block($icon, $list_body, $vars);
}
