<?php

$full = elgg_extract('full_view', $vars, FALSE);
$list_type = elgg_extract('list_type', $vars, FALSE);
$entity = elgg_extract('entity', $vars);

$tags = $entity->tags;
$title = $entity->title;
$description = $entity->description;
$access = $entity->access_id;
$time_updated = $entity->time_created;
$owner_guid = $entity->owner_guid;
$owner = get_entity($owner_guid);
//$container_guid = $entity->container_guid;


if ($full) {
	// Full view
	echo elgg_view('collections/view', $vars);
	
} else {
	// Listing view
	//if (elgg_in_context('listing') || elgg_in_context('search') || elgg_in_context('widgets')) {
	
	if (!elgg_in_context('widgets')) {
		$metadata = elgg_view_menu('entity', array(
			'entity' => $entity,
			'handler' => 'collection',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		));
	}

	if (!empty($description)) $description = elgg_view('output/longtext', array('value' => $description));

	// show icon (if set)
	$icon = elgg_view_entity_icon($entity, 'listing', array('size' => 'listing', 'align' => 'right'));

	$info = '';
	/*
	if ($entity->canEdit()) {
		$info .= '<a href="' . elgg_get_site_url() . "collection/edit/" . $entity->guid . '" class="elgg-button elgg-button-action" style="float:right;">' . elgg_echo('edit') . '</a>';
	}
	*/
	$info .= "<p class=\"owner_timestamp\">";
	$info .= elgg_echo('collections:entities:count', array(count((array) $entity->entities))) . '<br />';
	$info .= elgg_echo("collections:strapline", array(elgg_view_friendly_time($time_updated), "<a href=\"" . $owner->getURL() . "\">" . $owner->name ."</a>" ));
	$info .= "</p>";
	//$info .= elgg_get_excerpt($description);
	
	$params = array(
			'entity' => $entity,
			'metadata' => $metadata,
			'subtitle' => $info,
			'content' => elgg_get_excerpt($description),
		);
	$params = $params + $vars;
	$info = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($icon, $info);
}


