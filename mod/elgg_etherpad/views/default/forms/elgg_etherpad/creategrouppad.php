<?php
/**
 * Add group pad
 * Note : "group" can be misleading, as Etherpad Lite groups are rather access controls, 
 * so they are mapped to Elgg containers which are in this context : user, group or object
 *
 */

$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array_reverse($yes_no_opt);

$title = elgg_extract('title', $vars, '');
$container_guid = elgg_extract('container_guid', $vars, elgg_get_page_owner_guid());
$public = elgg_extract('public', $vars, 'no');
$password = elgg_extract('password', $vars, array());

$form_body = '';
$form_body .= '<p><em>' . elgg_echo('elgg_etherpad:forms:creategrouppad:details') . '</em></p>';
$form_body .= '<p><label>' . elgg_echo('elgg_etherpad:title') . ' ' . elgg_view('input/text', array('name' => 'title', 'value' => $title)) . '</label><br /><em></em></p>';
$form_body .= '<p><label>' . elgg_echo('elgg_etherpad:public') . ' ' . elgg_view('input/dropdown', array('name' => 'public', 'value' => $public, 'options_values' => $no_yes_opt)) . '</label></p>';
$form_body .= '<p><label>' . elgg_echo('elgg_etherpad:password') . ' ' . elgg_view('input/text', array('name' => 'password', 'value' => $password)) . '</label><br /><em>' . elgg_echo('elgg_etherpad:password:details') . '</em></p>';

//$form_body .= '<p><label>' . elgg_echo('elgg_etherpad:container_guid') . ' ' . elgg_view('input/text', array('name' => 'container_guid', 'value' => $container_guid)) . '</label><br /><em></em></p>';
$form_body .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

$form_body .= elgg_view('input/hidden', array('name' => 'request', 'value' => 'creategrouppad'));

$form_body .= elgg_view('input/submit', array('value' => elgg_echo("elgg_etherpad:creategrouppad")));

echo elgg_view('input/form', array('action' => $vars['url'] . "action/elgg_etherpad/edit", 'body' => $form_body));

