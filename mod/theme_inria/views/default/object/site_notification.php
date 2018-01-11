<?php
/**
 * Site notification view
 */

$entity = $vars['entity'];

$size = 'small';
if (elgg_in_context('topbar')) { $size = 'tiny'; }

$icon = '';
$header = '';
$text = '';

// Icon : actor (it's not river : no action)
$actor = $entity->getActor();
if ($actor ) {
	//$icon = elgg_view_entity_icon($actor, $size);
	if (!elgg_in_context('topbar') && (elgg_instanceof($actor, 'user') || elgg_instanceof($actor, 'group') || elgg_instanceof($actor, 'object'))) {
		if (elgg_instanceof($actor, 'user')) {
			$icon = '<a href="' . $actor->getURL() . '" class="elgg-avatar"><img src="' . $actor->getIconURL(array('size' => $size)) . '" /></a>';
		} else {
			$icon = '<a href="' . $actor->getURL() . '"><img src="' . $actor->getIconURL(array('size' => $size)) . '" /></a>';
		}
	} else {
		if (elgg_instanceof($actor, 'user')) {
			$icon = '<span class="elgg-avatar"><img src="' . $actor->getIconURL(array('size' => $size)) . '" /></span>';
		} else {
			$icon = '<img src="' . $actor->getIconURL(array('size' => $size)) . '" />';
		}
	}
}

// Header = date + optional delete action ?
$header .= '<span class="elgg-river-timestamp"><time title="" datetime="' . date('U', $entity->getTimeCreated()) . '">' . elgg_view_friendly_time($entity->getTimeCreated()) . '</time></span>';

//$text .= '<div class="elgg-body">' . $entity->description . '</div>';
$text .= '<div class="elgg-body"><strong>' . $entity->description . '</strong></div>';


// Wrap in a link
$url = $entity->getURL();
if ($url) {
	$text = elgg_view('output/url', array(
		'text' => $text,
		'href' => $url,
		'is_trusted' => true,
		'class' => 'site-notifications-link',
		'id' => 'site-notifications-link-' . $entity->guid,
	));
} else {
	// Use same page URL but still display a link s notification can be deleted once read
	$text = elgg_view('output/url', array(
		'text' => $text,
		'href' => current_page_url(),
		//'href' => '#',
		'is_trusted' => true,
		'class' => 'site-notifications-link',
		'id' => 'site-notifications-link-' . $entity->guid,
	));
	// Note : SiteNotification object may not have any URL, and this is not an error but only a special case
	//error_log("DEBUG object/site_notification {$entity->guid} : no object entity passed so no URL available");
}

if (elgg_in_context('topbar')) {
	$menu = elgg_view('output/url', array(
		'name' => 'delete',
		'href' => 'action/site_notifications/delete?guid=' . $entity->guid,
		'text' => elgg_view_icon('delete'),
		'is_action' => true,
		'link_class' => 'site-notifications-delete hidden',
		'id' => 'site-notifications-delete-' . $entity->guid,
		'style' => "display: none;",
	));
	echo elgg_view_image_block($icon, $header . $text, array(
		'image_alt' => $menu,
		'class' => 'pvn'
	));
} else {
	// @TODO : Mark as read once displayed ?
	//$entity->setRead();
	
	/*
	elgg_register_menu_item('site_notifications', array(
		'name' => 'time',
		'href' => false,
		'text' => elgg_view_friendly_time($entity->getTimeCreated()),
	));
	*/
	elgg_register_menu_item('site_notifications', array(
		'name' => 'delete',
		'href' => 'action/site_notifications/delete?guid=' . $entity->guid,
		'text' => elgg_view_icon('delete'),
		'is_action' => true,
		'link_class' => 'site-notifications-delete',
		'id' => 'site-notifications-delete-' . $entity->guid,
	));
	$menu = elgg_view_menu('site_notifications', array(
		'class' => 'elgg-menu-hz elgg-menu-entity',
	));

	$checkbox = elgg_view('input/checkbox', array(
		'name' => 'notification_id[]', 
		'value' => $entity->getGUID(), 
		'default' => false
	));

	$list_body = elgg_view_image_block($icon, $header . $text, array(
		'image_alt' => $menu,
		'class' => 'pvn'
	));

	echo elgg_view_image_block($checkbox, $list_body);
}

