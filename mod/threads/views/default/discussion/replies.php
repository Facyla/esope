<?php
/**
 * List replies
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['id']
 */

$id = $vars['id'] ? " id=\"{$vars['id']}\"" : "";
echo '<div'. $id .' class="mtl replies">';

$options = array(
	'relationship_guid' => $vars['entity']->getGUID(),
	'relationship' => 'parent',
	'inverse_relationship' => true,
	'order_by' => 'e.time_created asc'
);

echo elgg_list_entities_from_relationship($options);

echo '</div>';
