<?php
/**
 * Edit transitions add actor to a project
 *
 * @package Transitions
 */


//echo '<h3>' . elgg_echo('transitions:form:addactor') . '</h3>';
echo '<p><label>' . elgg_echo('transitions:form:addactor') . '</label> ';
echo elgg_view('transitions/input/addactor', array('name' => 'actor_guid', 'guid' => $vars['guid'])) . '</p>';

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/submit', array('value' => elgg_echo('transitions:addactor')));

