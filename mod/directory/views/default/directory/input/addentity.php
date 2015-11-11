<?php
$guid = $vars['guid'];
if (empty($guid)) $guid = get_input('guid', '');
$entity_guid = elgg_get_sticky_value('directory-addentity', 'entity_guid');
$comment = elgg_get_sticky_value('directory-addentity', 'comment');
$offset = $vars['offset'];
$entity = get_entity($entity_guid);

elgg_load_js("lightbox");
elgg_load_css("lightbox");
//elgg_require_js("directory/embed");
elgg_load_js("directory/edit");

echo '<div class="directory-addentity">';


echo '<a href="' . elgg_get_site_url() . 'directory/embed/' . $guid . '-' . $offset . '" class="elgg-lightbox elgg-button  elgg-button-action elgg-button-directory-select"><i class="fa fa-search"></i> ';
if ($entity_guid) {
	echo elgg_echo("directory:change_entity") . '</a>';
} else {
	echo elgg_echo("directory:select_entity") . '</a>';
}

// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'entity_guid', 'value' => $entity_guid, 'id' => 'directory-embed-' . $guid . '-' . $offset));
// Display entity content preview
echo '<blockquote id="directory-embed-details-' . $guid . '-' . $offset . '">';
if (elgg_instanceof($entity, 'object')) {
	echo elgg_view('directory/embed/object/default', array('entity' => $entity));
} else {
	echo elgg_echo('directory:edit:entity:none');
}
echo '</blockquote>';

echo '<label>' . elgg_echo('directory:edit:entities_comment') . ' ' . elgg_view('input/text', array('name' => 'comment', 'value' => $comment)) . '</label>';

echo '</div>';

