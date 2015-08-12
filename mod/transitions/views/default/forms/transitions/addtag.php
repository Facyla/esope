<?php
/**
 * Edit transitions add tag
 *
 * @package Transitions
 */

//echo '<h3>' . elgg_echo('transitions:form:addtag') . '</h3>';
echo '<em>' . elgg_echo('transitions:addtag:details') . '<br />' . elgg_view('input/tags', array('name' => 'tags', 'required' => 'required', 'style' => "max-width:12em;")) . '</em>';

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/submit', array('value' => elgg_echo('transitions:addtag:submit')));

