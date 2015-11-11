<?php
$guid = $vars['guid'];
if (empty($guid)) $guid = get_input('guid', '');
$entity_guid = $vars['entity_guid'];
$comment = $vars['entity_comment'];
$offset = $vars['offset'];
$entity = get_entity($entity_guid);

elgg_load_js("lightbox");
elgg_load_css("lightbox");
//elgg_require_js("directory/embed");
elgg_load_js("directory/edit");

echo '<div class="directory-edit-entity">';

echo '<a href="javascript:void(0);" class="directory-edit-delete-entity" title="' . elgg_echo('directory:edit:deleteentity') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>';

//echo '<label>' . elgg_echo('directory:edit:entities') . ' ' . elgg_view('input/entity_select', array('name' => 'entities[]', 'value' => $entity_guid)) . '</label>';
echo '<a href="' . elgg_get_site_url() . 'directory/embed/' . $guid . '-' . $offset . '" class="elgg-lightbox elgg-button elgg-button-directory-select"><i class="fa fa-search"></i> ';
if ($entity_guid) {
	echo elgg_echo("directory:change_entity") . '</a>';
} else {
	echo elgg_echo("directory:select_entity") . '</a>';
}
// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'entities[]', 'value' => $entity_guid, 'id' => 'directory-embed-' . $guid . '-' . $offset));
// Display entity content preview
echo '<blockquote id="directory-embed-details-' . $guid . '-' . $offset . '">';
if (elgg_instanceof($entity, 'object')) {
	echo elgg_view('directory/embed/object/default', array('entity' => $entity));
} else {
	echo elgg_echo('directory:edit:entity:none');
}
echo '</blockquote>';

echo '<label>' . elgg_echo('directory:edit:entities_comment') . ' ' . elgg_view('input/plaintext', array('name' => 'entities_comment[]', 'value' => $comment, 'style' => "height:4em;")) . '</label>';


echo '</div>';


