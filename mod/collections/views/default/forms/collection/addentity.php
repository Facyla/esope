<?php
/**
 * Edit collections add actor to a project
 *
 * @package Collections
 */

$actor_guid = elgg_get_sticky_value('collections-addentity', 'entity_guid');


//echo '<h3>' . elgg_echo('collections:form:addentity') . '</h3>';
echo '<p><em>' . elgg_echo('collections:addentity:details') . '</em></p>';
echo elgg_view('collections/input/addentity', array());

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/submit', array('value' => elgg_echo('collections:addentity:submit'), 'class' => 'elgg-button-submit hidden'));

