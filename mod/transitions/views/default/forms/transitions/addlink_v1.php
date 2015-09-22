<?php
/**
 * Edit transitions add relation to other entity
 *
 * @package Transitions
 */

$link_relation_opt = array('supports' => elgg_echo('transitions:relation:supports'), 'invalidates' => elgg_echo('transitions:relation:invalidates'));

//echo '<h3>' . elgg_echo('transitions:form:addlink') . '</h3>';
echo '<em>' . elgg_echo('transitions:addlink:details') . '<br />' . elgg_view('input/url', array('name' => 'url', 'style' => "max-width:20em;")) . '</em>';
//echo '<label>' . elgg_echo('transitions:guid') . elgg_view('input/text', array('name' => 'guid', 'style' => "max-width:8em;")) . '</label>';
echo elgg_view('input/select', array('name' => 'relation', 'options_values' => $link_relation_opt));

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/submit', array('value' => elgg_echo('transitions:addlink:submit')));

