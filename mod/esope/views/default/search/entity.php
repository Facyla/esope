<?php
/**
 * Default view for an entity returned in a search
 *
 * Display largely controlled by a set of overrideable volatile data:
 *   - search_icon (defaults to entity icon)
 *   - search_matched_title 
 *   - search_matched_description
 *   - search_matched_extra
 *   - search_url (defaults to entity->getURL())
 *   - search_time (defaults to entity->time_updated or entity->time_created)
 *
 * @uses $vars['entity'] Entity returned in a search
 */

$entity = $vars['entity'];

// Don't display users if they don't allow their profile to be displayed
// @TODO : note this can let to 
if (elgg_instanceof ($entity, 'user')) {
	$allowed = esope_user_profile_gatekeeper($entity, false);
	if (!$allowed) {
		$icon_url = elgg_get_site_url() . "_graphics/icons/default/tiny.png";
		$spacer_url = elgg_get_site_url() . '_graphics/spacer.gif';
		$icon = '<div class="elgg-avatar elgg-avatar-tiny"><a>' . elgg_view('output/img', array('src' => $spacer_url, 'style' => "background: url($icon_url) no-repeat;")) . '</a></div>';
		$body = elgg_echo('InvalidParameterException:NoEntityFound');
		echo elgg_view_image_block($icon, $body);
		return;
	}
}

$icon = $entity->getVolatileData('search_icon');
if (!$icon) {
	// display the entity's owner by default if available.
	// @todo allow an option to switch to displaying the entity's icon instead.
	$type = $entity->getType();
	if ($type == 'user' || $type == 'group') {
		$icon = elgg_view_entity_icon($entity, 'tiny');
	} elseif ($owner = $entity->getOwnerEntity()) {
		$icon = elgg_view_entity_icon($owner, 'tiny');
	} else {
		// display a generic icon if no owner, though there will probably be
		// other problems if the owner can't be found.
		$icon = elgg_view_entity_icon($entity, 'tiny');
	}
}

$title = $entity->getVolatileData('search_matched_title');
$description = $entity->getVolatileData('search_matched_description');
$extra_info = $entity->getVolatileData('search_matched_extra');
$url = $entity->getVolatileData('search_url');
// Remove highlighting if empty search, otherwise there is a display bug with UTF8 characters
$q = get_input('q');
if (empty(trim($q))) {
	$title = strip_tags($title);
	$description = strip_tags($description);
	$extra_info = strip_tags($extra_info);
}

if (!$url) {
	$url = $entity->getURL();
}

$title = "<a href=\"$url\">$title</a>";
$time = $entity->getVolatileData('search_time');
if (!$time) {
	$tc = $entity->time_created;
	$tu = $entity->time_updated;
	$time = elgg_view_friendly_time(($tu > $tc) ? $tu : $tc);
}

$body = "<p class=\"mbn\">$title</p>$description";
if ($extra_info) {
	$body .= "<p class=\"elgg-subtext\">$extra_info</p>";
}
$body .= "<p class=\"elgg-subtext\">$time</p>";

echo elgg_view_image_block($icon, $body);
