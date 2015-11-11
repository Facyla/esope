<?php
/**
 * Edit directory add actor to a project
 *
 * @package directory
 */

$actor_guid = elgg_get_sticky_value('directory-addentity', 'entity_guid');


//echo '<h3>' . elgg_echo('directory:form:addentity') . '</h3>';
echo '<p><em>' . elgg_echo('directory:addentity:details') . '</em></p>';
echo elgg_view('directory/input/addentity', array());

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/submit', array('value' => elgg_echo('directory:addentity:submit')));

