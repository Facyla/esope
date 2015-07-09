<?php
/**
 * Edit transitions quick form
 *
 * @package Transitions
 */

$action_buttons = '';


$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('transitions:savedraft'),
	'name' => 'save',
));
$action_buttons = $save_button;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'transitions_title',
));

$category_opt = transitions_get_category_opt($vars['category'], true);
$category_label = elgg_echo('transitions:category');
$category_input = elgg_view('input/select', array(
	'name' => 'category',
	'id' => 'transitions_category',
	'value' => $vars['category'],
	'options_values' => $category_opt, 
));

$actortype_opt = transitions_get_actortype_opt($vars['actortype'], true);
$actortype_label = elgg_echo('transitions:actortype');
$actortype_input = elgg_view('input/select', array(
	'name' => 'actor_type',
	'id' => 'transitions_actortype',
	'options_values' => $actortype_opt,
));

$body_label = elgg_echo('transitions:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'transitions_description',
));

$url_label = elgg_echo('transitions:url');
$url_input = elgg_view('input/url', array(
	'name' => 'url',
	'id' => 'transitions_url',
));

$attachment_label = elgg_echo("transitions:attachment:new");
$attachment_input = elgg_view("input/file", array("name" => "attachment", "id" => "transitions_attachment"));



echo <<<___HTML

<div>
	<label for="transitions_title">$title_label</label>
	$title_input
</div>

<div>
	<label for="transitions_category">$category_label</label>
	$category_input
</div>

<div>
	<label for="transitions_description">$body_label</label>
	$body_input
</div>

<div>
	<label for="transitions_url">$url_label</label>
	$url_input
</div>

<div>
	<label for="transitions_attachment">$attachment_label</label>
	$attachment_input
</div>

	$action_buttons
</div>

___HTML;
