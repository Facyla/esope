<?php
$entity = $vars['entity'];
$tags = $entity->tags;
$title = $entity->title;
$pagetype = $entity->pagetype;
$description = $entity->description;

$access = $entity->access_id;
$time_updated = $entity->time_created;

$owner_guid = $entity->owner_guid;
$owner = get_entity($owner_guid);
//$container_guid = $entity->container_guid;

if (!empty($description)) $description = elgg_view('output/longtext', array('value' => $description));

$icon = elgg_view( "graphics/icon", array( 'entity' => $vars['entity'], 'size' => 'small', ) );
$info = '';

if ($entity->canEdit()) {
	$info .= '<a href="' . elgg_get_site_url() . "collection/edit/" . $entity->guid . '" class="elgg-button elgg-button-action" style="float:right;">' . elgg_echo('edit') . '</a>';
}
$info .= '<h3><a href="' . $vars['entity']->getUrl() . '" class="entity-title">' . $title . '</a></h3>';
$info .= "<p class=\"owner_timestamp\">".elgg_echo("collections:strapline", array(elgg_view_friendly_time($time_updated), "<a href=\"" . $owner->getURL() . "\">" . $owner->name ."</a>" )) . "</p>";
$info .= elgg_get_excerpt($description);

echo elgg_view_image_block($icon, $info);

