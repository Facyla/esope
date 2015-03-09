<?php 
/**
 * Group entity view
 * 
 * @package ElggGroups
 */

$group = $vars['entity'];

//if (elgg_in_context('dashboard')) {
if (!elgg_in_context('dashboard') && (elgg_in_context('owner_block') || elgg_in_context('widgets')) ) {
//if (elgg_in_context('owner_block') || elgg_in_context('widgets')) {
	$icon = elgg_view_entity_icon($group, 'small');
} else if (elgg_in_context('livesearch')) {
	$icon = elgg_view_entity_icon($group, 'tiny');
} else if (elgg_in_context('widgets') || elgg_in_context('search')) {
	$icon = elgg_view_entity_icon($group, 'small');
} else {
	$icon = elgg_view_entity_icon($group, 'medium');
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $group,
	'handler' => 'groups',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

// Ajout d'actions utiles dans les listings de groupes
$actions = array();
$class = '';
// group members
if ($group->isMember(elgg_get_logged_in_user_entity())) {
	$class .= 'is-group-member ';
	// group admin (& owner)
	if ($group->canEdit()) {
		$class .= 'is-group-admin ';
		if (elgg_in_context('dashboard')) {
			// edit and invite
			$url = elgg_get_site_url() . "groups/edit/{$group->getGUID()}";
			$actions[$url] = 'groups:edit';
			$url = elgg_get_site_url() . "groups/invite/{$group->getGUID()}";
			$actions[$url] = 'groups:invite';
		}
	}
	if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
		if (elgg_in_context('dashboard')) {
			// leave
			$url = elgg_get_site_url() . "action/groups/leave?group_guid={$group->getGUID()}";
			$url = elgg_add_action_tokens_to_url($url);
			$actions[$url] = 'groups:leave';
		}
	} else {
		$class .= 'is-group-owner ';
	}
} elseif (elgg_is_logged_in()) {
	// @TODO : ne pas afficher dans la sidebar
	if (!elgg_in_context('owner_block') && !elgg_in_context('widgets')) {
		// join - admins can always join.
		$url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		if ($group->isPublicMembership() || $group->canEdit()) {
			$actions[$url] = 'groups:join';
		} else {
			// request membership
			$actions[$url] = 'groups:joinrequest';
		}
	}
}
if ($actions) {
	foreach ($actions as $url => $text) {
		if (in_array($text, array('groups:join', 'groups:joinrequest', 'groups:acceptrequest'))) $vars['content'] .= elgg_view('output/url', array('href' => $url, 'text' => elgg_echo($text), 'class' => 'elgg-button elgg-button-action'));
		else $vars['content'] .= elgg_view('output/url', array('href' => $url, 'text' => elgg_echo($text), 'class' => 'elgg-button elgg-widget-button'));
	}
}


if (elgg_in_context('owner_block') || elgg_in_context('widgets')) {
	$metadata = '';
}


if ($vars['full_view']) {
	echo elgg_view('groups/profile/summary', $vars);
} else {
	// brief view
	$params = array(
		'entity' => $group,
		'metadata' => $metadata,
		'subtitle' => $group->briefdescription,
		'class' => $class,
	);
	$params = $params + $vars;
	$list_body = elgg_view('group/elements/summary', $params);

	echo '<div class="'.$class.'">' . elgg_view_image_block($icon, $list_body, $vars) . '</div>';
}
