<?php
$entity = elgg_extract('entity', $vars);
if (!elgg_instanceof($entity, 'object', 'slider')) { return; }

$tags = $entity->tags;
$title = $entity->title;
$pagetype = $entity->pagetype;
$description = $entity->description;
$access = $entity->access_id;
$time_updated = $entity->time_updated;
$owner_guid = $entity->owner_guid;
$owner = get_entity($owner_guid);
//$container_guid = $entity->container_guid;

if (!empty($description)) {
	$description = elgg_view('output/longtext', array('value' => $description));
}

$icon = elgg_view( "graphics/icon", array( 'entity' => $vars['entity'], 'size' => 'small', ) );
$info = '';

$info .= elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'slider',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$info .= '<h3><a href="' . $vars['entity']->getUrl() . '" class="entity-title">' . $title . '</a></h3>';
$info .= "<p class=\"owner_timestamp\">".elgg_echo("slider:strapline", array(elgg_view_friendly_time($time_updated), "<a href=\"" . $owner->getURL() . "\">" . $owner->name ."</a>" )) . "</p>";
$info .= elgg_get_excerpt($description);

echo elgg_view_image_block($icon, $info);

