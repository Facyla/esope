<?php
/**
 * Edit directory link directory elements together
 *
 * @package directory
 */

$selected_guid = elgg_get_sticky_value('directory-addrelation', 'entity_guid');
$comment = elgg_get_sticky_value('directory-addrelation', 'comment');
$selected_entity = get_entity($selected_guid);

$subtype = $vars['entity']->getSubtype();
$selected_subtype = $vars['selected-subtype'];
$guid = $vars['entity']->guid;
$offset = $vars['offset'];

elgg_load_js("lightbox");
elgg_load_css("lightbox");
//elgg_require_js("directory/embed");
elgg_load_js('elgg.directory.directory');


//echo '<h3>' . elgg_echo('directory:form:addrelation') . '</h3>';
echo '<p><em>' . elgg_echo('directory:addrelation:details') . '</em></p>';
//echo elgg_view('directory/input/add_entity', array('entity' => $vars['entity'], 'directory-addrelation' => $selected_guid));

echo '<div class="directory-addrelation">';


echo '<a href="' . elgg_get_site_url() . 'directory/embed/' . $guid . '-' . $offset . '/' . $selected_subtype . '" class="elgg-lightbox elgg-button elgg-button-action elgg-button-directory-select"><i class="fa fa-search"></i> ';
if ($selected_guid) {
	echo elgg_echo("directory:change") . '</a>';
} else {
	echo elgg_echo("directory:select:$selected_subtype") . '</a>';
}

// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'entity_guid', 'value' => $selected_guid, 'id' => 'directory-embed-' . $guid . '-' . $offset));
// Display entity content preview
echo '<blockquote id="directory-embed-details-' . $guid . '-' . $offset . '">';
if (elgg_instanceof($selected_entity, 'object')) {
	echo elgg_view('directory/embed/object/default', array('entity' => $selected_entity));
} else {
	echo elgg_echo('directory:edit:entity:none');
}
echo '</blockquote>';

echo '</div>';



echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
echo elgg_view('input/submit', array('value' => elgg_echo('directory:addrelation:submit')));

