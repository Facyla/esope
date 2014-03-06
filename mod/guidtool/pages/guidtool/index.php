<?php
/**
 * Elgg GUID Tool
 * 
 * @package ElggGUIDTool
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 * 
 * @updated for Elgg 1.8 Facyla 2013
 */

admin_gatekeeper();
elgg_set_context('admin');

$title = elgg_echo("guidtool");

elgg_push_context('search');

$limit = get_input('limit', 10);
$offset = get_input('offset');

// Get entities
$count = elgg_get_entities(array('limit' => $limit, 'offset' => $offset, 'count' => true));
$entities = elgg_get_entities(array('limit' => $limit, 'offset' => $offset));

$wrapped_entries = array();

if ($entities) foreach ($entities as $e) {
	$tmp = new ElggObject();
	$tmp->subtype = 'guidtoolwrapper';
	$tmp->entity = $e;
	$wrapped_entries[] = $tmp;
}

$body = elgg_view_entity_list($wrapped_entries, array('count' => $count, 'offset' => $offset, 'limit' => $limit, 'full_view' => false, 'list_type_toggle' => false));

elgg_pop_context($context);


// Display main admin menu
$body = elgg_view_layout('admin', array('title' => $title, 'content' => $body));
echo elgg_view_page($title, $body);

