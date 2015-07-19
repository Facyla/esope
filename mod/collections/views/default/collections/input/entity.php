<?php

$guid = $vars['guid'];
$entity_guid = $vars['entity_guid'];
$comment = $vars['entity_comment'];
$offset = $vars['offset'];
$entity = get_entity($entity_guid);

elgg_load_js("lightbox");
elgg_load_css("lightbox");
//elgg_require_js("collections/embed");
elgg_load_js("collections/edit");

echo '<div class="collection-edit-entity">';

echo '<a href="javascript:void(0);" class="collection-edit-delete-entity" title="' . elgg_echo('collections:edit:deleteentity') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>';

//echo '<label>' . elgg_echo('collections:edit:entities') . ' ' . elgg_view('input/entity_select', array('name' => 'entities[]', 'value' => $entity_guid)) . '</label>';
echo '<a href="' . elgg_get_site_url() . 'collection/embed/' . $guid . '-' . $offset . '" class="elgg-lightbox">';
if ($entity_guid) {
	echo elgg_echo("collections:change_entity") . '</a>';
} else {
	echo elgg_echo("collections:select_entity") . '</a>';
}
// @TODO autocomplete field ?
echo elgg_view('input/hidden', array('name' => 'entities[]', 'value' => $entity_guid, 'id' => 'collections-embed-' . $guid . '-' . $offset));
echo '<div id="collections-embed-details-' . $guid . '-' . $offset . '">';
if (elgg_instanceof($entity, 'object')) {
	echo elgg_view('collections/embed/object/default', array('entity' => $entity));
}
echo '</div>';

echo '<label>' . elgg_echo('collections:edit:entities_comment') . ' ' . elgg_view('input/plaintext', array('name' => 'entities_comment[]', 'value' => $comment)) . '</label>';


echo '</div>';


