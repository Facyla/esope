<?php
// Iris object header

$entity = elgg_extract('entity', $vars, FALSE);
$mode = elgg_extract('mode', $vars, FALSE);

$page_owner = elgg_get_page_owner_entity();
$owner = $entity->getOwnerEntity();


// ICONS AND IMAGES
$profile_type = esope_get_user_profile_type($owner);
if (empty($profile_type)) { $profile_type = 'external'; }
// Archive : replace profile type by member status archived
if ($owner->memberstatus == 'closed') { $profile_type = 'archive'; }
$owner_icon = '<span class="elgg-avatar elgg-avatar-medium profile-type-' . $profile_type . '"><a href="' . $owner->getURL() . '" title="' . $owner->name . '" class="elgg-avatar medium"><img src="' . $owner->getIconURL(array('size' => 'medium')) . '" /></a></span>';


// TOP MENU
$menu = elgg_view_menu('entity', array(
		'entity' => $entity,
		'handler' => $entity->getSubtype(),
		'sort_by' => 'priority',
		'class' => 'elgg-menu-vert',
	));
$header = '<div class="entity-headline">';
	if ($mode != 'listing') {
		$header .= '<div class="owner-icon"><a href="' . $owner->getURL() . '" title="' . $owner->name . '" class="elgg-avatar medium profile-type-' . $profile_type . '"><img src="' . $owner->getIconURL(array('size' => 'small')) . '" /></a></div>';
	}
	
	$header .= '<div class="entity-title">';
		$header .= '<strong>' . $owner->name . '</strong>';
		
		// Add profile type badge, if defined
		if (in_array($profile_type, array('external', 'archive'))) { $header .= '<span class="iris-badge"><span class="iris-badge-' . $profile_type . '" title="' . elgg_echo('profile:types:'.$profile_type.':description') . '">' . elgg_echo('profile:types:'.$profile_type) . '</span></span>'; }
		
		$header .= '<span class="elgg-river-timestamp">' . elgg_view_friendly_time($entity->time_created) . '</span>';
		//$header .= elgg_view('output/access', array('entity' => $entity));
	$header .= '</div>';
	
	$header .= '<div class="entity-submenu">
		<a href="javascript:void(0);" onClick="$(this).parent().find(\'.entity-submenu-content\').toggleClass(\'hidden\')"><i class="fa fa-ellipsis-h"></i></a>
		<div class="entity-submenu-content hidden">' . $menu . '</div>
	</div>';
$header .= '</div>';


echo $header;


