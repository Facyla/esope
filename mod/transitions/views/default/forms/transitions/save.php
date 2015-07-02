<?php
/**
 * Edit transitions form
 *
 * @package Transitions
 */

$transitions = get_entity($vars['guid']);
$vars['entity'] = $transitions;

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="mbm elgg-text-help">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/transitions/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => true,
	));
}

// published transitionss do not get the preview button
if (!$vars['guid'] || ($transitions && $transitions->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'elgg-button-submit mls',
	));
}

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
	'name' => 'save',
));
$action_buttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'transitions_title',
	'value' => $vars['title']
));

$excerpt_label = elgg_echo('transitions:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'transitions_excerpt',
	'value' => _elgg_html_decode($vars['excerpt'])
));

$icon_input = "";
$icon_remove_input = "";
if($vars["guid"]){
	$icon_label = elgg_echo("transitions:label:icon:exists");
	
	if($transitions->icontime){
		$icon_remove_input = "<br /><img src='" . $transitions->getIconURL() . "' />";
		$icon_remove_input .= "<br />";
		$icon_remove_input .= elgg_view("input/checkbox", array(
			"name" => "remove_icon",
			"value" => "yes"
		));
		$icon_remove_input .= elgg_echo("transitions:label:icon:remove");
	}
} else {
	$icon_label = elgg_echo("blog_tools:label:icon:new");
}
$icon_input .= elgg_view("input/file", array("name" => "icon", "id" => "transitions_icon"));
$icon_input .= $icon_remove_input;


$body_label = elgg_echo('transitions:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'transitions_description',
	'value' => $vars['description']
));

$save_status = elgg_echo('transitions:save_status');
if ($vars['guid']) {
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('never');
}

$status_label = elgg_echo('status');
$status_input = elgg_view('input/select', array(
	'name' => 'status',
	'id' => 'transitions_status',
	'value' => $vars['status'],
	'options_values' => array(
		'draft' => elgg_echo('status:draft'),
		'published' => elgg_echo('status:published')
	)
));

$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/select', array(
	'name' => 'comments_on',
	'id' => 'transitions_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));

$url_label = elgg_echo('url');
$url_input = elgg_view('input/url', array(
	'name' => 'url',
	'id' => 'transitions_url',
	'value' => $vars['url']
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'transitions_tags',
	'value' => $vars['tags']
));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'transitions_access_id',
	'value' => $vars['access_id'],
	'entity' => $vars['entity'],
	'entity_type' => 'object',
	'entity_subtype' => 'transitions',
));

$categories_input = elgg_view('input/categories', $vars);

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));


echo <<<___HTML

$draft_warning

<div>
	<label for="transitions_title">$title_label</label>
	$title_input
</div>

<div>
	<label for="transitions_excerpt">$excerpt_label</label>
	$excerpt_input
</div>

<div>
	<label for="transitions_icon">$icon_label</label>
	$icon_input
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
	<label for="transitions_tags">$tags_label</label>
	$tags_input
</div>

$categories_input

<div>
	<label for="transitions_comments_on">$comments_label</label>
	$comments_input
</div>

<div>
	<label for="transitions_access_id">$access_label</label>
	$access_input
</div>

<div>
	<label for="transitions_status">$status_label</label>
	$status_input
</div>

<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="transitions-save-status-time">$saved</span>
	</div>

	$guid_input
	$container_guid_input

	$action_buttons
</div>

___HTML;
