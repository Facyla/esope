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
if (!$format) $format = 'json';

$entity_guid = get_input('entity_guid');

if ($entity = get_entity($entity_guid)) {
	
	// Export URL
	$export_url = $CONFIG->url . "export/$format/$entity_guid/";
	
	// Download button
	echo '<p><a class="elgg-button elgg-button-action" href="' . $export_url . '" target="_new">Download GUID ' . $entity_guid . ' as ' . $format . ' file</a></p>';
	
	// Display export content
	/*
	elgg_set_viewtype($format);
	echo '<textarea style="height:50ex;">';
	
	// Doesn't work because not loggedin
	echo htmlentities(file_get_contents($export_url));
	
	// Exporting that way is broken in 1.8.19 (returns "Fix...")
	//echo elgg_view('export/entity', array('entity' => $entity, false, false, $format));
	echo '</textarea>';
	elgg_set_viewtype('default');
	*/

} else { register_error('Invalid entity'); }

