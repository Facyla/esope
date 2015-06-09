<?php
/**
 * Add a public pad (no group)
 *
 */

$title = elgg_extract('title', $vars, '');

$form_body = '';
$form_body .= '<p><em>' . elgg_echo('elgg_etherpad:forms:createpad:details') . '</em></p>';
$form_body .= '<p><label>' . elgg_echo('elgg_etherpad:title') . ' ' . elgg_view('input/text', array('name' => 'title', 'value' => $title)) . '</label><br /><em></em></p>';
$form_body .= elgg_view('input/hidden', array('name' => 'request', 'value' => 'createpad'));
$form_body .= elgg_view('input/submit', array('value' => elgg_echo("elgg_etherpad:createpad")));

echo elgg_view('input/form', array('action' => $vars['url'] . "action/elgg_etherpad/edit", 'body' => $form_body));

