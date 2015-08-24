<?php
/**
 * Edit transitions quick form
 *
 * @package Transitions
 */

$action_buttons = '';


$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('transitions:saveandedit'),
	'name' => 'save',
));
$action_buttons = $save_button;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'transitions_title',
	'required' => 'required',
	'placeholder' => elgg_echo('transitions:title'),
));

$category_opt = transitions_get_category_opt($vars['category'], true);
$category_label = elgg_echo('transitions:category');
$category_input = elgg_view('input/select', array(
	'name' => 'category',
	'id' => 'transitions_category',
	'value' => $vars['category'],
	'options_values' => $category_opt, 
	'required' => 'required',
));

$actortype_opt = transitions_get_actortype_opt($vars['actortype'], true);
$actortype_label = elgg_echo('transitions:actortype');
$actortype_input = elgg_view('input/select', array(
	'name' => 'actor_type',
	'id' => 'transitions_actortype',
	'options_values' => $actortype_opt,
));

$body_label = elgg_echo('transitions:body');
//$body_input = elgg_view('input/longtext', array(
$body_input = elgg_view('input/plaintext', array(
	'name' => 'description',
	'id' => 'transitions_description',
	'required' => 'required',
));

$url_label = elgg_echo('transitions:url');
$url_input = elgg_view('input/url', array(
	'name' => 'url',
	'id' => 'transitions_url',
	'placeholder' => elgg_echo('transitions:url'),
));

//$attachment_label = elgg_echo("transitions:attachment:new");
//$attachment_input = elgg_view("input/file", array("name" => "attachment", "id" => "transitions_attachment"));

$status_input = '';
$status_input .= '<p>' . elgg_echo('transitions:quickform:details') . '</p>';
//$status_input .= elgg_view('input/hidden', array('name' => 'status', 'value' => 'published'));


echo <<<___HTML

<div>
	<label for="transitions_title" class="">$title_label</label>
	$title_input
</div>

<div>
	<label for="transitions_category" class="">$category_label</label>
	$category_input
</div>

<div>
	<label for="transitions_description" class="">$body_label</label>
	$body_input
</div>

<div>
	<label for="transitions_url" class="">$url_label</label>
	$url_input
</div>

	$status_input
	$action_buttons
</div>

___HTML;
