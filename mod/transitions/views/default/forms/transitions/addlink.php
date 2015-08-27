<?php
/**
 * Edit transitions add commented link
 *
 * @package Transitions
 */

$address = elgg_get_sticky_value('transitions-addlink', 'address');
$comment = elgg_get_sticky_value('transitions-addlink', 'comment');


//echo '<h3>' . elgg_echo('transitions:form:addlink') . '</h3>';
echo '<p><em>' . elgg_echo('transitions:addlink:details') . '</em></p>';
echo '<p><label>' . elgg_echo('transitions:addlink:url') . ' ' . elgg_view('input/url', array('name' => 'address', 'value' => $address, 'required' => 'required', 'placeholder' => elgg_echo('transitions:addlink:url:placeholder'), 'style' => "max-width:60%;")) . '</label></p>';
//echo '<label>' . elgg_echo('transitions:guid') . elgg_view('input/text', array('name' => 'guid', 'style' => "max-width:8em;")) . '</label>';
echo '<p><label>' . elgg_echo('transitions:addlink:comment') . ' ' .  elgg_view('input/text', array('name' => 'comment', 'value' => $comment, 'required' => 'required', 'placeholder' => elgg_echo('transitions:addlink:comment:placeholder'), 'style' => "max-width:60%;")) . '</label></p>';

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo('transitions:addlink:submit'))) . '</p>';

