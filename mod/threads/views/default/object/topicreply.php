<?php
/*
 * Embeds an edit link for the annotation
 */

$entity = elgg_extract('entity', $vars);

$owner = get_entity($entity->owner_guid);
if (!$entity || !$owner) {
	return true;
}
$icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = "<a href=\"{$owner->getURL()}\">$owner->name</a>";

$menu = elgg_view_menu('reply', array(
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-entity elgg-menu-hz',
));

$text = elgg_view("output/longtext", array("value" => $entity->description));

$friendlytime = elgg_view_friendly_time($entity->time_created);

$replies = elgg_view('discussion/replies', array('entity' => $entity));

$body = <<<HTML
<div class="mbn">
	$menu
	$owner_link
	<span class="elgg-subtext">
		$friendlytime
	</span>
	$text
</div>
HTML;

echo elgg_view_image_block($icon, $body);

if (get_input('guid') == $entity->guid) {

	$box = false;
	
	if ($entity->canEdit() && get_input('box') == "edit") {
		$box = 'edit';
	}
	if ($entity->canAnnotate() && get_input('box') == "reply") {
		$box = 'reply';
	}
	
	if ($box) {	
		$form = elgg_view_form('discussion/reply/save', array(), array_merge(array(
					'entity' => $entity,
					'reply' => $box == 'reply',
				), $vars)
			);
		echo "<div class=\"mvl replies\" id=\"$box-topicreply-$entity->guid\">$form</div>";
	}
}

echo $replies;
