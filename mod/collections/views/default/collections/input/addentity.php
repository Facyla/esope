<?php
$guid = $vars['guid'];
if (empty($guid)) $guid = get_input('guid', '');
$entity_guid = elgg_get_sticky_value('collections-addentity', 'entity_guid');
$comment = elgg_get_sticky_value('collections-addentity', 'comment');
$offset = $vars['offset'];
$entity = get_entity($entity_guid);

elgg_load_js("lightbox");
elgg_load_css("lightbox");
//elgg_require_js("collections/embed");
elgg_load_js("collections/edit");

echo '<div class="collection-addentity">';


echo '<a href="' . elgg_get_site_url() . 'collection/embed/' . $guid . '-' . $offset . '" class="elgg-lightbox elgg-button  elgg-button-action elgg-button-collection-select"><i class="fa fa-search"></i> ';
if ($entity_guid) {
	echo elgg_echo("collections:change_entity") . '</a>';
} else {
	echo elgg_echo("collections:select_entity") . '</a>';
}

// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'entity_guid', 'value' => $entity_guid, 'id' => 'collections-embed-' . $guid . '-' . $offset));
// Display entity content preview
echo '<blockquote id="collections-embed-details-' . $guid . '-' . $offset . '">';
if (elgg_instanceof($entity, 'object')) {
	echo elgg_view('collections/embed/object/default', array('entity' => $entity));
} else {
	echo elgg_echo('collections:edit:entity:none');
}
echo '</blockquote>';

echo '<label class="entity_comment hidden">' . elgg_echo('collections:edit:entities_comment') . ' ' . elgg_view('input/text', array('name' => 'comment', 'value' => $comment)) . '</label>';

echo '</div>';

