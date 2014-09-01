<?php
/**
 * Elgg GUID Tool
 * 
 * @package ElggGUIDTool
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

global $CONFIG;

$format = $vars['format'];
if (!$format) $format = 'opendd';

$entity_guid = get_input('entity_guid');

echo '<div id="edit">';

// @TODO : make it a proper form + action
// Note : based on export/entity view
$entity = get_entity($entity_guid);
if (!$entity) {
	throw new InvalidParameterException(elgg_echo('InvalidParameterException:NoEntityFound'));
}

if ($entity->isEnabled()) {
	// Entity is enabled
	//echo '<p><blockquote>' . elgg_echo('guidtool:entity:enabled') . '</blockquote></p>';
	// @TODO disable it ?
} else {
	// Entity is not enabled (hidden)
	echo '<p><blockquote>' . elgg_echo('guidtool:entity:disabled') . '</blockquote></p>';
	// @TODO enable it ?
}


// Get data on GUID
$options = array('guid' => $entity->guid, 'limit' => 0);
$metadata = elgg_get_metadata($options);
$annotations = elgg_get_annotations($options);
$relationships = get_entity_relationships($entity->guid);

$exportable_values = $entity->getExportableValues();
$non_editable_fields = array('guid', 'type', 'subtype', 'tables_split', 'tables_loaded');

echo '<p>';
echo '<a href="' . $entity->getURL() . '" class="elgg-button elgg-button-action">' . elgg_echo('guidtool:regularview') . '</a> ';
echo '<a href="' . $vars['url'] . $entity->getSubtype() . '/edit/' . $entity->guid . '" class="elgg-button elgg-button-action">' . elgg_echo('guidtool:regularedit') . '</a>';
echo '</p>';


// Edit GUID fields form
$guidtool_edit_fields = get_input('guidtool_edit_fields', '');
echo '<p class="margin-none"><label>Edit fields&nbsp;: </label><input type="text" name="guidtool_edit_fields" value="' . $guidtool_edit_fields . '" /><br />By default, no field value will be changed : you need to manually set here which fields will be updated once you save the form. Please separate fields by commas. Extra space are allowed.</p>';
// We need at least the GUID to edit..
echo '<input type="hidden" name="guid" value="' . $entity_guid . '" />';


echo '<div>';
echo '<h2>' . elgg_echo('Entity') . '</h2>';
	foreach ($entity as $k => $v) {
		if ((in_array($k, $exportable_values)) || (elgg_is_admin_logged_in())) {
			if (in_array($k, $non_editable_fields)) {
				// Non-editable yet
				echo '<p class="margin-none"><b>' . $k . '&nbsp;: </b>' . strip_tags($v) . '</p>';
				//echo '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
			} else {
				// Textareas should be used only if we have very much content
				// Text inputs should be sufficient in most cases
				if (strlen($v) > 100) {
					echo '<p class="margin-none"><label>' . $k . '&nbsp;: </label><textarea name="' . $k . '">' . $v . '</textarea></p>';
				} else {
					echo '<p class="margin-none"><label>' . $k . '&nbsp;: </label><input type="text" name="' . $k . '" value="' . $v . '" /></p>';
				}
			}
		}
	}
echo '</div><br />';


if ($metadata) {
	echo '<div id="metadata" class="mtm">';
	echo '<h2>' . elgg_echo('metadata') . '</h2>';
	foreach ($metadata as $m) {
		// @TODO : we can edit metadata only if we merge the "arrays" before
		// but metadata can accept content like commas, so must be very careful with separators
		echo '<p class="margin-none"><b>' . $m->name . '&nbsp;: </b>' .$m->value . '</p>';
	}
	echo '</div><br />';
}

if ($annotations) {
	echo '<div id="annotations" class="mtm">';
	echo '<h2>' . elgg_echo('annotations') . '</h2>';
	foreach ($annotations as $a) {
		echo '<p class="margin-none"><b>' .$a->name . '&nbsp;: </b>' .$a->value . '</p>';
	}
	echo '</div><br />';
}

if ($relationships) {
	echo '<div id="relationship" class="mtm">';
	echo '<h2>' . elgg_echo('relationships') . '</h2>';
	foreach ($relationships as $r) {
		echo '<p class="margin-none"><b>' .$r->relationship . '&nbsp;: </b>' .$r->guid_two . '</p>';
	}
	echo '</div><br />';
}
echo '</div>';


echo '<input type="submit" value="' . elgg_echo('save') . '" />';
echo '</div>';

