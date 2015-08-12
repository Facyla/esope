<?php
/**
 * Edit transitions form
 *
 * @package Transitions
 */

$transitions = get_entity($vars['guid']);
$vars['entity'] = $transitions;

$edit_details = '<p><em>' . elgg_echo('transitions:edit:details') . '</em></p>';

$draft_warning = $vars['draft_warning'];
if ($draft_warning) {
	$draft_warning = '<span class="mbm elgg-text-help">' . $draft_warning . '</span>';
}

$action_buttons = '';
$delete_link = '';
$preview_button = '';

// Set some default values
if (empty($vars['lang'])) { $vars['lang'] = get_language(); }
if (empty($vars['resource_lang'])) { $vars['resource_lang'] = get_language(); }

// Get select options
$lang_opt = transitions_get_lang_opt($vars['lang'], true);
$actortype_opt = transitions_get_actortype_opt($vars['actortype'], true);
$category_opt = transitions_get_category_opt($vars['category'], true);

// Set some values from URL, if set
if (!$vars['guid']) {
	$vars['title'] = get_input('title', $vars['title']);
	$vars['url'] = get_input('url', $vars['url']);
	$vars['rss_feed'] = get_input('rss_feed', $vars['rss_feed']);
	$vars['category'] = get_input('category', $vars['category']);
	$vars['lang'] = get_input('lang', $vars['lang']);
	$vars['excerpt'] = get_input('excerpt', $vars['excerpt']);
	$vars['description'] = get_input('description', $vars['description']);
	if (!$vars['tags']) $vars['tags'] = explode(',', get_input('tags'));
}


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

// published transitions do not get the preview button
if (!$vars['guid'] || ($transitions && $transitions->status != 'published')) {
	$preview_button = elgg_view('input/submit', array(
		'value' => elgg_echo('transitions:preview'),
		'name' => 'preview',
		'class' => 'elgg-button-submit mls',
	));
}

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('transitions:save'),
	'name' => 'save',
));
$action_buttons = $save_button . $preview_button . $delete_link;

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'transitions_title',
	'value' => $vars['title'],
	'placeholder' => elgg_echo('transitions:title'),
));

$excerpt_label = elgg_echo('transitions:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'transitions_excerpt',
	'value' => _elgg_html_decode($vars['excerpt']),
	'placeholder' => elgg_echo('transitions:excerpt'),
));

$icon_input = "";
$icon_remove_input = "";
if($vars["guid"]){
	$icon_label = elgg_echo("transitions:icon");
	if($transitions->icontime){
		$icon_remove_input = "<br /><img src='" . $transitions->getIconURL('listing') . "' />";
		$icon_remove_input .= "<br />";
		$icon_remove_input .= elgg_view("input/checkbox", array(
			"name" => "remove_icon",
			"value" => "yes"
		));
		$icon_remove_input .= elgg_echo("transitions:icon:remove");
	}
} else {
	$icon_label = elgg_echo("transitions:icon:new");
}
$icon_input .= elgg_view("input/file", array("name" => "icon", "id" => "transitions_icon"));
$icon_input .= $icon_remove_input;
$icon_details = elgg_echo('transitions:icon:details');

$attachment_input = "";
$attachment_remove_input = "";
if($vars["guid"]){
	$attachment_label = elgg_echo("transitions:attachment");
	if($transitions->attachment){
		$attachment_remove_input = '<br /><a href="' . $transitions->getAttachmentURL() . '" target="_new" />' . $transitions->getAttachmentName() . '</a>';
		$attachment_remove_input .= "<br />";
		$attachment_remove_input .= elgg_view("input/checkbox", array("name" => "remove_attachment", "value" => "yes"));
		$attachment_remove_input .= elgg_echo("transitions:attachment:remove");
	}
} else {
	$attachment_label = elgg_echo("transitions:attachment:new");
}
$attachment_input .= elgg_view("input/file", array("name" => "attachment", "id" => "transitions_attachment"));
$attachment_input .= $attachment_remove_input;
$attachment_details = elgg_echo('transitions:attachment:details');


$body_label = elgg_echo('transitions:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'transitions_description',
	'value' => $vars['description'],
));

$save_status = elgg_echo('transitions:save_status');
if ($vars['guid'] && ($entity->time_created > 0)) {
	$saved = date('F j, Y @ H:i', $entity->time_created);
} else {
	$saved = elgg_echo('never');
}

if (elgg_is_admin_logged_in()) {
	$status_label = elgg_echo('status');
	$status_value = $vars['status'];
	$status_input = elgg_view('input/select', array(
		'name' => 'status',
		'id' => 'transitions_status',
		'value' => $vars['status'],
		'options_values' => array(
			'draft' => elgg_echo('status:draft'),
			'published' => elgg_echo('status:published')
		)
	));
	
	$incremental_label = elgg_echo('transitions:incremental');
	$incremental_value = $vars['is_incremental'];
	$incremental_input = elgg_view('input/select', array(
		'name' => 'is_incremental',
		'id' => 'transitions_incremental',
		'value' => $vars['is_incremental'],
		'options_values' => array(
			'no' => elgg_echo('transitions:incremental:no'),
			'yes' => elgg_echo('transitions:incremental:yes'),
		)
	));
} else {
	$status_input = elgg_view('input/hidden', array('name' => 'status', 'value' => 'published'));
}

/*
$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/select', array(
	'name' => 'comments_on',
	'id' => 'transitions_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));
*/

$url_label = elgg_echo('transitions:url');
$url_input = elgg_view('input/url', array(
	'name' => 'url',
	'id' => 'transitions_url',
	'value' => $vars['url'],
	'placeholder' => elgg_echo('transitions:url'),
));
$url_details = elgg_echo('transitions:url:details');

$rss_feed_label = elgg_echo('transitions:rss_feed');
$rss_feed_input = elgg_view('input/url', array(
	'name' => 'rss_feed',
	'id' => 'transitions_rss_feed',
	'value' => $vars['rss_feed'],
	'placeholder' => elgg_echo('transitions:rss_feed'),
));
$rss_feed_details = elgg_echo('transitions:rss_feed:details');

// @TODO update to allow several elements (+ should be regular inputs)
$challenge_elements_label = elgg_echo('transitions:challenge_element');
$challenge_elements_input = elgg_view_form('transitions/addrelation', array(), array('guid' => $transitions->guid));
$challenge_elements_input .= '<div class="clearfloat"></div><br />';
$challenge_elements_details = elgg_echo('transitions:challenge_elements:details');


$category_label = elgg_echo('transitions:category');
$category_input = elgg_view('input/select', array(
	'name' => 'category',
	'id' => 'transitions_category',
	'value' => $vars['category'],
	'options_values' => $category_opt,
	'onchange' => 'transitions_toggle_fields();',
));

$lang_label = elgg_echo('transitions:lang');
$lang_input = elgg_view('input/select', array(
	'name' => 'lang',
	'id' => 'transitions_lang',
	'value' => $vars['lang'],
	'options_values' => $lang_opt,
));

$resourcelang_label = elgg_echo('transitions:resourcelang');
$resourcelang_input = elgg_view('input/select', array(
	'name' => 'resource_lang',
	'id' => 'transitions_resourcelang',
	'value' => $vars['resource_lang'],
	'options_values' => $lang_opt,
));
$resourcelang_details = elgg_echo('transitions:resourcelang:details');

$territory_label = elgg_echo('transitions:territory');
$territory_input = elgg_view('input/text', array(
	'name' => 'territory',
	'id' => 'transitions_territory',
	'value' => $vars['territory'], 
	'placeholder' => elgg_echo('transitions:territory'),
));
$territory_details = elgg_echo('transitions:territory:details');

$actortype_label = elgg_echo('transitions:actortype');
$actortype_input = elgg_view('input/select', array(
	'name' => 'actor_type',
	'id' => 'transitions_actortype',
	'value' => $vars['actortype'],
	'options_values' => $actortype_opt,
));

$startdate_label = elgg_echo('transitions:startdate');
$startdate_input = elgg_view('input/date', array(
	'name' => 'start_date',
	'id' => 'transitions_startdate',
	'value' => $vars['start_date'],
	'placeholder' => elgg_echo('transitions:startdate'),
	'timestamp' => true,
));

$enddate_label = elgg_echo('transitions:enddate');
$enddate_input = elgg_view('input/date', array(
	'name' => 'end_date',
	'id' => 'transitions_enddate',
	'value' => $vars['end_date'],
	'placeholder' => elgg_echo('transitions:enddate'),
	'timestamp' => true,
));

$tags_label = elgg_echo('tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'transitions_tags',
	'value' => $vars['tags'],
	'placeholder' => elgg_echo('transitions:tags'),
));


// @TODO Admin only : contributed tags + links + status
$admin_fields = '';
if (elgg_is_admin_logged_in()) {
	$contributed_tags_label = elgg_echo('transitions:tags_contributed');
	$contributed_tags_input = elgg_view('input/tags', array(
		'name' => 'tags_contributed',
		'id' => 'transitions_tags_contributed',
		'value' => $transitions->tags_contributed,
		'placeholder' => elgg_echo('transitions:tags_contributed'),
	));

	$links_invalidates_label = elgg_echo('transitions:links_invalidates');
	$links_invalidates_input = elgg_view('input/tags', array(
		'name' => 'links_invalidates',
		'id' => 'transitions_links_invalidates',
		'value' => $transitions->links_invalidates,
		'placeholder' => elgg_echo('transitions:links_invalidates'),
	));

	$links_supports_label = elgg_echo('transitions:links_supports');
	$links_supports_input = elgg_view('input/tags', array(
		'name' => 'links_supports',
		'id' => 'transitions_links_supports',
		'value' => $transitions->links_supports,
		'placeholder' => elgg_echo('transitions:links_supports'),
	));
	
	$admin_fields .= '<blockquote>';
	$admin_fields .= '<p class="' . $status_value . '"><label class="" for="transitions_status">' . $status_label . '</label> ' . $status_input . '</p>';
	$admin_fields .= '<p class="' . $incremental_value . '"><label class="" for="transitions_incremental">' . $incremental_label . '</label> ' . $incremental_input . '</p>';
	$admin_fields .= '<p><label class="hidden" for="transitions_tags_contributed">' . $contributed_tags_label . '</label>' . $contributed_tags_input . '</p>';
	$admin_fields .= '<p><label class="hidden" for="transitions_links_supports">' . $links_supports_label . '</label>' . $links_supports_input . '</p>';
	$admin_fields .= '<p><label class="hidden" for="transitions_links_invalidates">' . $links_invalidates_label . '</label>' . $links_invalidates_input . '</p>';
	$admin_fields .= '</blockquote>';
	
} else {
	$admin_fields .= $status_input;
}



/* Access is always public (admin can unpublish by other means : draft + disable)
$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'transitions_access_id',
	'value' => $vars['access_id'],
	'entity' => $vars['entity'],
	'entity_type' => 'object',
	'entity_subtype' => 'transitions',
));
*/

$categories_input = elgg_view('input/categories', $vars);

// hidden inputs
$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));


// Toggle disabled field control
echo '<script>

// Execute once on document ready
$(document).ready( function() {
	transitions_toggle_fields();
	$("option[value=\'\']").attr("disabled", "disabled");
});

function transitions_toggle_fields() {
	var val = $("select[name=\'category\']").val();
	// Reinit special fields
	$(".transitions-actortype").addClass(\'hidden\');
	$(".transitions-territory").addClass(\'hidden\');
	$(".transitions-startdate").addClass(\'hidden\');
	$(".transitions-enddate").addClass(\'hidden\');
	$(".transitions-rss-feed").addClass(\'hidden\');
	
	//Now switch on wanted special fields
	if (val == "actor") {
		$(".transitions-actortype").removeClass(\'hidden\');
		$(".transitions-territory").removeClass(\'hidden\');
	} else if (val == "project") {
		$(".transitions-territory").removeClass(\'hidden\');
		$(".transitions-startdate").removeClass(\'hidden\');
		$(".transitions-enddate").removeClass(\'hidden\');
	} else if (val == "event") {
		$(".transitions-startdate").removeClass(\'hidden\');
		$(".transitions-enddate").removeClass(\'hidden\');
	} else if (val == "challenge") {
		$(".transitions-rss-feed").removeClass(\'hidden\');
	}
	return true;
}
</script>';
// , 'onchange' => 'uhb_annonces_toggle_typework();')

echo <<<___HTML

$edit_details

$draft_warning

<div>
	<label class="" for="transitions_icon">$icon_label</label><br />
	$icon_input<br />
	<em>$icon_details</em>
</div>

<div>
	<label class="hidden" for="transitions_excerpt">$excerpt_label</label>
	$excerpt_input
</div>

<div>
	<label class="hidden" for="transitions_tags">$tags_label</label>
	$tags_input
</div>

<div>
	<label class="hidden" for="transitions_title">$title_label</label>
	$title_input
</div>

<div class="flexible-block" style="width:48%; float:left;">
	<label class="" for="transitions_category">$category_label</label><br />
	$category_input
</div>

<div class="flexible-block transitions-actortype" style="width:48%; float:right;">
	<label class="" for="transitions_actortype transitions-actortype">$actortype_label</label><br />
	$actortype_input
</div>
<div class="clearfloat"></div>

<div>
	<label class="" for="transitions_description">$body_label</label>
	$body_input
</div>

<div>
	<label class="hidden" for="transitions_url">$url_label</label>
	$url_input<br />
	<em>$url_details</em>
</div>

<div class="transitions-rss-feed">
	<label class="hidden" for="transitions_rss_feed">$rss_feed_label</label>
	$rss_feed_input<br />
	<em>$rss_feed_details</em>
</div>

<div>
	<label class="" for="transitions_attachment">$attachment_label</label><br />
	$attachment_input<br />
	<em>$attachment_details</em>
</div>
<div class="clearfloat"></div>

<div class="transitions-territory">
	<label class="hidden" for="transitions_territory">$territory_label</label>
	$territory_input<br />
	<em>$territory_details</em>
</div>

<div class="flexible-block transitions-startdate" style="width:48%; float:left;">
	<label class="" for="transitions_startdate">$startdate_label</label>
	$startdate_input
</div>

<div class="flexible-block transitions-enddate" style="width:48%; float:right;">
	<label class="" for="transitions_enddate">$enddate_label</label>
	$enddate_input
</div>
<div class="clearfloat"></div>

$categories_input

<div class="flexible-block" style="width:48%; float:left;">
	<label class="" for="transitions_lang">$lang_label</label>
	$lang_input
</div>

<div class="flexible-block transitions-resourcelang" style="width:48%; float:right;">
	<label class="" for="transitions_resourcelang">$resourcelang_label</label>
	$resourcelang_input<br />
	<em>$resourcelang_details</em>
</div>
<div class="clearfloat"></div>

$admin_fields

<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="transitions-save-status-time">$saved</span>
	</div>

	$guid_input
	$container_guid_input

	$action_buttons
</div>

___HTML;
