<?php
/**
 * Edit transitions form
 *
 * @package Transitions
 */

elgg_load_js('elgg.transitions');

$transitions = get_entity($vars['guid']);
$vars['entity'] = $transitions;

if (elgg_is_active_plugin('theme_transitions2')) {
	$is_admin = theme_transitions2_user_is_content_admin();
} else {
	$is_admin = elgg_is_admin_logged_in();
}

if ($transitions) $edit_details = '<p style="margin:20px 0;"><em>' . elgg_echo('transitions:edit:details') . '</em></p>';

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
$full_lang_opt = transitions_get_lang_opt($vars['lang'], true, true);
$actortype_opt = transitions_get_actortype_opt($vars['actor_ype'], true);
$category_opt = transitions_get_category_opt($vars['category'], true);

// Set some values from URL, if set
if (!$vars['guid']) {
	/*
	$vars['title'] = get_input('title', $vars['title']);
	$vars['url'] = get_input('url', $vars['url']);
	$vars['rss_feed'] = get_input('rss_feed', $vars['rss_feed']);
	$vars['category'] = get_input('category', $vars['category']);
	$vars['lang'] = get_input('lang', $vars['lang']);
	$vars['excerpt'] = get_input('excerpt', $vars['excerpt']);
	$vars['description'] = get_input('description', $vars['description']);
	*/
	$var_names = array('title', 'url', 'rss_feed', 'category', 'lang', 'excerpt', 'description');
	foreach ($var_names as $var_name) {
		// Get var value from direct var passing, with URL override if available
		$vars[$var_name] = get_input($var_name, $vars[$var_name]);
		// URL decoding should work without that, but this ensures that this will work even with browsers encoding twice the URL...
		if (strpos($vars[$var_name], '%')) {
			$vars[$var_name] = urldecode($vars[$var_name]);
			echo "Decode $var_name<br />";
		}
	}
	// Get tags, this is a bit differnt as we need an array
	if (!$vars['tags']) {
		$vars['tags'] = get_input('tags');
		if (strpos($vars['tags'], '%')) {
			$vars['tags'] = urldecode($vars['tags']);
		}
		$vars['tags'] = explode(',', $vars['tags']);
	}
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

// Published transitions do not get the preview button
// Admins also do not have it (as they can change manually the publication status)
if (!$is_admin && (!elgg_instanceof($transitions, 'object') || ($transitions->status != 'published'))) {
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
$action_buttons = '<p>' . $save_button . $preview_button . $delete_link . '</p>';

$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'transitions_title',
	'value' => $vars['title'],
	'placeholder' => elgg_echo('transitions:title'),
));

$char_limit = 140;
$excerpt = _elgg_html_decode($vars['excerpt']);
$char_left = $char_limit - strlen($excerpt);
$excerpt_label = elgg_echo('transitions:excerpt');
$excerpt_input = elgg_view('input/text', array(
	'name' => 'excerpt',
	'id' => 'transitions_excerpt',
	'value' => $excerpt,
	'placeholder' => elgg_echo('transitions:excerpt'),
	'data-max-length' => $char_limit,
	//'rows' => 2,
));
$excerpt_input .= '<span id="transitions-characters-remaining"><span>' . $char_left . '</span> ' . elgg_echo('transitions:charleft') . '<strong class="hidden">' . elgg_echo('transitions:charleft:warning') . '</strong></span>';

$icon_input = "";
$icon_remove_input = "";
if($vars["guid"]){
	$icon_label = elgg_echo("transitions:icon:change");
	if($transitions->icontime){
		$icon_image = '<img src="' . $transitions->getIconURL('listing') . '" style="float:right; margin-left:1em;" />';
		$icon_remove_input .= elgg_view("input/checkbox", array("name" => "remove_icon", "value" => "yes"));
		$icon_remove_input .= elgg_echo("transitions:icon:remove");
		$icon_remove_input .= '<div class="clearfloat"></div>';
	}
} else {
	$icon_label = elgg_echo("transitions:icon:new");
}
$icon_input .= $icon_remove_input;
$icon_input .= '<em>' . elgg_echo('transitions:icon:details') . '</em><br />';
$icon_input .= elgg_view("input/file", array("name" => "icon", "id" => "transitions_icon"));


$attachment_input = "";
$attachment_remove_input = "";
if($vars["guid"]){
	$attachment_label = elgg_echo("transitions:attachment");
	if($transitions->attachment){
		$attachment_link = '<a href="' . $transitions->getAttachmentURL() . '" target="_new" style="float:right; margin-left:1em;" /><i class="fa fa-file"></i> ' . $transitions->getAttachmentName() . '</a>';
		$attachment_remove_input .= elgg_view("input/checkbox", array("name" => "remove_attachment", "value" => "yes"));
		$attachment_remove_input .= elgg_echo("transitions:attachment:remove");
		$attachment_remove_input .= "<br />";
	}
} else {
	$attachment_label = elgg_echo("transitions:attachment:new");
}
$attachment_input .= $attachment_remove_input;
$attachment_input .= '<em>' . elgg_echo('transitions:attachment:details') . '</em><br />';
$attachment_input .= elgg_view("input/file", array("name" => "attachment", "id" => "transitions_attachment"));


$body_label = elgg_echo('transitions:body');
$body_input = elgg_view('input/longtext', array(
	'name' => 'description',
	'id' => 'transitions_description',
	'value' => $vars['description'],
));

$save_status = elgg_echo('transitions:save_status');
if ($vars['guid'] && ($transitions->time_created > 0)) {
	$saved = date('F j, Y @ H:i', $transitions->time_created);
} else {
	$saved = elgg_echo('never');
}

$revisions = elgg_view('transitions/sidebar/revisions', $vars);


// Admin-only fields
if ($is_admin) {
	$status_label = elgg_echo('status');
	$status_value = $vars['status'];
	$status_input = elgg_view('input/select', array(
		'name' => 'status',
		'id' => 'transitions_status',
		'value' => $status_value,
		'options_values' => array(
			'draft' => elgg_echo('status:draft'),
			'published' => elgg_echo('status:published')
		)
	));
	
	$owner_username_label = elgg_echo('transitions:owner_username');
	if (elgg_instanceof($transitions, 'object', 'transitions')) {
		$owner_username = $transitions->getOwnerEntity()->username;
	} else {
		$owner_username = elgg_get_logged_in_user_entity()->username;
	}
	$owner_username_input = elgg_view('input/autocomplete', array(
		'name' => 'owner_username',
		'id' => 'transitions_owner_username',
		'value' => '',
		'match_on' => 'users',
	));
	
	$featured_label = elgg_echo('transitions:featured');
	$featured_value = $vars['featured'];
	$featured_input = elgg_view('input/select', array(
		'name' => 'featured',
		'id' => 'transitions_featured',
		'value' => $transitions->featured,
		'options_values' => array(
			//'no' => elgg_echo('transitions:featured:no'),
			//'yes' => elgg_echo('transitions:featured:yes'),
			'default' => elgg_echo('transitions:featured:default'),
			'featured' => elgg_echo('transitions:featured:featured'),
			'background' => elgg_echo('transitions:featured:background'),
		)
	));
	
	$contributed_tags_label = elgg_echo('transitions:tags_contributed');
	$contributed_tags_input = elgg_view('input/tags', array(
		'name' => 'tags_contributed',
		'id' => 'transitions_tags_contributed',
		'value' => $transitions->tags_contributed,
		'placeholder' => elgg_echo('transitions:tags_contributed'),
	));
	
	$contributed_actors_label = elgg_echo('transitions:actors_contributed');
	$contributed_actors_input = '<div class="transitions-edit-actors">';
	// Note : we need to check only if we have a valid entity for the relation otherwise we would get weird results
	if (elgg_instanceof($transitions, 'object', 'transitions')) {
		$contributed_actors_ent = elgg_get_entities_from_relationship(array(
				'type' => 'object',
				'subtype' => 'transitions',
				'relationship' => 'partner_of',
				'relationship_guid' => $transitions->guid,
				'inverse_relationship' => true,
				'limit' => 0,
			));
		if (!empty($contributed_actors_ent)) foreach($contributed_actors_ent as $ent) {
			$contributed_actors_input .= '<div class="transitions-edit-contributed-actor"><a href="javascript:void(0);" class="transitions-edit-removeactor" title="' . elgg_echo('transitions:addactor:remove') . '" style="float:right; margin-left:2ex;"><i class="fa fa-trash"></i></a>';
			$contributed_actors_input .= elgg_view('transitions/embed/object/default', array('entity' => $ent));
			$contributed_actors_input .= elgg_view('input/hidden', array('name' => 'actor_guid[]', 'value' => $ent->guid));
			$contributed_actors_input .= '</div>';
		}
	}
	$contributed_actors_input .= '</div>';
	$contributed_actors_input .= elgg_view('transitions/input/addactor_edit', array('name' => 'actor_guid[]'));
	//$contributed_actors_input .= '<input type="button" class="transitions-edit-addactor" value="' . elgg_echo('transitions:addactor:add') . '" class="elgg-button elgg-button-action" />';



	/*
	$links_supports_label = elgg_echo('transitions:links_supports');
	$links_supports_input = elgg_view('input/plaintext', array(
		'name' => 'links_supports',
		'id' => 'transitions_links_supports',
		'value' => implode("\n", (array) $transitions->links_supports),
		'placeholder' => elgg_echo('transitions:links_supports'),
	));
	
	$links_invalidates_label = elgg_echo('transitions:links_invalidates');
	$links_invalidates_input = elgg_view('input/plaintext', array(
		'name' => 'links_invalidates',
		'id' => 'transitions_links_invalidates',
		'value' => implode("\n", (array) $transitions->links_invalidates),
		'placeholder' => elgg_echo('transitions:links_invalidates'),
	));
	*/
	
	/*
	$links_label = elgg_echo('transitions:links');
	$links_input = elgg_view('input/plaintext', array(
		'name' => 'links',
		'id' => 'transitions_links',
		'value' => implode("\n", (array) $transitions->links),
		'placeholder' => elgg_echo('transitions:links:placeholder'),
	));
	$links_comment_label = elgg_echo('transitions:links_comment');
	$links_comment_input = elgg_view('input/plaintext', array(
		'name' => 'links_comment',
		'id' => 'transitions_links_comment',
		'value' => implode("\n", (array) $transitions->links_comment),
		'placeholder' => elgg_echo('transitions:links_comment:placeholder'),
	));
	*/
	$links_label = elgg_echo('transitions:links');
	$links = (array) $transitions->links;
	$links_comment = (array) $transitions->links_comment;
	$links_input = '<div class="transitions-edit-links">';
	if ($links) {
		foreach($links as $k => $link) {
			$links_input .= elgg_view('transitions/input/addlink', array('address' => $link, 'comment' => $links_comment[$k]));
		}
	}
	$links_input .= '</div>';
	$links_input .= '<input type="button" class="transitions-edit-addlink" value="' . elgg_echo('transitions:addlink:add') . '" class="elgg-button elgg-button-action" />';
	
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

/*
$rss_feed_label = elgg_echo('transitions:rss_feed');
$rss_feed_input = elgg_view('input/url', array(
	'name' => 'rss_feed',
	'id' => 'transitions_rss_feed',
	'value' => $vars['rss_feed'],
	'placeholder' => elgg_echo('transitions:rss_feed'),
));
$rss_feed_details = elgg_echo('transitions:rss_feed:details');
*/

// @TODO update to allow several elements (+ should be regular inputs)
$collection_label = elgg_echo('transitions:challenge:collection');
// Note : admin can select 
$collection_input = '';
$collections_opt = array();
$collections_opt['none'] = elgg_echo('transitions:challenge:collection:none');
$collections_params = array('types' => 'object', 'subtypes' => 'collection', 'order_by' => 'time_created desc', 'limit' => 0);
$collections = elgg_get_entities($collections_params);
// Tri alphabétique des pages (sur la base du pagetype)
usort($collections, create_function('$a,$b', 'return strcmp($a->title,$b->title);'));
foreach ($collections as $ent) { $collections_opt[$ent->guid] = $ent->title; }
$collection_input .= elgg_view('input/select', array('name' => 'collection', 'options_values' => $collections_opt, 'value'=> $transitions->collection));
$collection_details = elgg_echo('transitions:challenge:collection:details');


$category_label = elgg_echo('transitions:category');
$category_input = elgg_view('input/select', array(
	'name' => 'category',
	'id' => 'transitions_category',
	'value' => $vars['category'],
	'options_values' => $category_opt,
	'onchange' => 'transitions_toggle_fields();',
));

$explanations = '';
foreach ($category_opt as $cat => $cat_lang) {
	if (!empty($cat)) {
		$explanations .= '<blockquote class="transitions-explanations transitions-explanations-' . $cat . '">' . elgg_echo("transitions:category:$cat:details") . '</blockquote>';
	}
}

$lang_label = elgg_echo('transitions:lang');
$lang_input = elgg_view('input/select', array(
	'name' => 'lang',
	'id' => 'transitions_lang',
	'value' => $vars['lang'],
	'options_values' => $lang_opt,
));
$lang_details = elgg_echo('transitions:lang:details');

$resourcelang_label = elgg_echo('transitions:resourcelang');
$resourcelang_input = elgg_view('input/select', array(
	'name' => 'resource_lang',
	'id' => 'transitions_resourcelang',
	'value' => $vars['resource_lang'],
	'options_values' => $full_lang_opt,
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
	'value' => $vars['actor_type'],
	'options_values' => $actortype_opt,
));

// Exact dates and times
$startdate_label = elgg_echo('transitions:startdate');
$startdate_input = elgg_view('input/date', array(
	'name' => 'start_date',
	'id' => 'transitions_startdate',
	'value' => $vars['start_date'],
	'placeholder' => elgg_echo('transitions:startdate'),
	'timestamp' => true,
	'style' => "width:8em;",
));
if (!empty($vars['start_date'])) {
	$starttime_value = date('H', $vars['start_date'])*60 + date('i', $vars['start_date']);
} else { $starttime_value = 0; }
$starttime_input = elgg_view('input/timepicker', array(
	'name' => 'start_time',
	'id' => 'transitions_starttime',
	'value' => $starttime_value,
	'placeholder' => elgg_echo('transitions:starttime'),
)) . $vars['start_date'];

$enddate_label = elgg_echo('transitions:enddate');
$enddate_input = elgg_view('input/date', array(
	'name' => 'end_date',
	'id' => 'transitions_enddate',
	'value' => $vars['end_date'],
	'placeholder' => elgg_echo('transitions:enddate'),
	'timestamp' => true,
	'style' => "width:8em;",
));
if (!empty($vars['end_date'])) {
	$endtime_value = date('H', $vars['end_date'])*60 + date('i', $vars['end_date']);
} else { $endtime_value = 0; }
$endtime_input = elgg_view('input/timepicker', array(
	'name' => 'end_time',
	'id' => 'transitions_endtime',
	'value' => $endtime_value,
	'placeholder' => elgg_echo('transitions:endtime'),
));

// Text dates
$start_label = elgg_echo('transitions:start');
$start_input = elgg_view('input/text', array(
	'name' => 'start',
	'id' => 'transitions_start',
	'value' => $vars['start'],
	'placeholder' => elgg_echo('transitions:start:format'),
	//'style' => "width:7em;",
));
$end_label = elgg_echo('transitions:end');
$end_input = elgg_view('input/text', array(
	'name' => 'end',
	'id' => 'transitions_end',
	'value' => $vars['end'],
	'placeholder' => elgg_echo('transitions:end:format'),
	//'style' => "width:7em;",
));

$tags_label = elgg_echo('transitions:tags');
$tags_input = elgg_view('input/tags', array(
	'name' => 'tags',
	'id' => 'transitions_tags',
	'value' => $vars['tags'],
	'placeholder' => elgg_echo('transitions:tags:placeholder'),
));
$tags_details = elgg_echo('transitions:tags:details');


// Admin only fields : contributed tags + links + status
$admin_fields = '';
if ($is_admin) {
	
	$admin_fields .= '<blockquote>';
	$admin_fields .= '<p class="' . $status_value . '"><label class="" for="transitions_status">' . $status_label . '</label> ' . $status_input . ' &nbsp; ';
	$admin_fields .= '<label for="transitions_featured">' . $featured_label . '</label> ' . $featured_input . '</p>';
	$admin_fields .= '<p><label for="transitions_owner_username">' . $owner_username_label . ' (' . $owner_username . ')</label> ' . $owner_username_input . '<br />' . elgg_echo('transitions:owner_username:details') . '</p>';
	// Contributed tags
	$admin_fields .= '<p><label for="transitions_tags_contributed">' . $contributed_tags_label . '</label>' . $contributed_tags_input . '</p>';
	//$admin_fields .= '<p><label for="transitions_links_supports">' . $links_supports_label . '</label>' . $links_supports_input . '</p>';
	//$admin_fields .= '<p><label for="transitions_links_invalidates">' . $links_invalidates_label . '</label>' . $links_invalidates_input . '</p>';
	// Contributed actors
	$admin_fields .= '<p class="transitions-actors"><label for="transitions_actors_contributed">' . $contributed_actors_label . '</label>' . $contributed_actors_input . '</p>';
	// Contributed links
	$admin_fields .= '<p><label>' . $links_label . '</label>' . $links_input . '</p>';
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
	$(".transitions-start").addClass(\'hidden\');
	$(".transitions-end").addClass(\'hidden\');
	$(".transitions-rss-feed").addClass(\'hidden\');
	$(".transitions-collection").addClass(\'hidden\');
	$(".transitions-actors").addClass(\'hidden\');
	
	$(".transitions-explanations").addClass(\'hidden\');
	if (val) $(".transitions-explanations-"+val).removeClass(\'hidden\');
	
	//Now switch on wanted special fields
	if (val == "actor") {
		$(".transitions-title label").html(\'' . elgg_echo('transitions:title:actor') . '\');
		$(".transitions-actortype").removeClass(\'hidden\');
		$(".transitions-territory").removeClass(\'hidden\');
	} else if (val == "project") {
		$(".transitions-title label").html(\'' . elgg_echo('transitions:title:project') . '\');
		$(".transitions-territory").removeClass(\'hidden\');
		$(".transitions-start").removeClass(\'hidden\');
		$(".transitions-end").removeClass(\'hidden\');
		$(".transitions-actors").removeClass(\'hidden\');
	} else if (val == "event") {
		$(".transitions-title label").html(\'' . elgg_echo('transitions:title:event') . '\');
		$(".transitions-startdate").removeClass(\'hidden\');
		$(".transitions-enddate").removeClass(\'hidden\');
	} else if (val == "challenge") {
		$(".transitions-rss-feed").removeClass(\'hidden\');
		$(".transitions-collection").removeClass(\'hidden\');
	} else {
		$(".transitions-title label").html(\'' . elgg_echo('title') . '\');
	}
	return true;
}
</script>';
// , 'onchange' => 'uhb_annonces_toggle_typework();')


$ressources_legend = elgg_echo('transitions:resources');

// Form composition

$content = <<<___HTML

<div class="flexible-block" style="width:48%; float:left;">
	<label class="" for="transitions_category">$category_label</label><br />
	$category_input
</div>

<div class="flexible-block transitions-actortype" style="width:48%; float:right;">
	<label class="" for="transitions_actortype transitions-actortype">$actortype_label</label><br />
	$actortype_input
</div>
<div class="flexible-block transitions-collection" style="width:48%; float:right;">
	<label class="" for="transitions_collection">$collection_label</label>
	$collection_input<br />
	<em>$collection_details</em>
</div>
<div class="clearfloat"></div>

<p>
	$explanations
</p>

<p class="transitions-title">
	<label class="" for="transitions_title">$title_label</label>
	$title_input
</p>

<p style="margin:20px 0;">
	<label class="" for="transitions_excerpt">$excerpt_label</label>
	$excerpt_input
</p>

<div style="margin:20px 0;">
	<label class="" for="transitions_description">$body_label</label>
	$body_input
</div>

<p style="margin:20px 0;">
	<label class="" for="transitions_lang">$lang_label</label>
	$lang_input<br />
	<em>$lang_details</em>
</p>

<p style="margin:20px 0;">
	<label class="" for="transitions_tags">$tags_label</label>
	$tags_input
	<br /><em>$tags_details</em>
</p>

$categories_input

___HTML;

/*
<div class="transitions-rss-feed">
	<label class="" for="transitions_rss_feed">$rss_feed_label</label>
	$rss_feed_input<br />
	<em>$rss_feed_details</em>
</div>
*/


$sidebar = '';
$sidebar .= <<<___HTML
$edit_details

<div style="margin:20px 0;">
	$icon_image
	<label class="" for="transitions_icon">$icon_label</label><br />
	$icon_input
</div>

<p class="transitions-territory" style="margin:20px 0;">
	<label class="" for="transitions_territory">$territory_label</label>
	$territory_input<br />
	<em>$territory_details</em>
</p>

<div class="transitions-startdate transitions-enddate" style="margin:20px 0;">
	<p class="transitions-startdate">
		<label class="" for="transitions_startdate">$startdate_label</label>
		$startdate_input
		<span class="transitions-starttime">$starttime_input</span>
	</p>

	<p class="transitions-enddate">
		<label class="" for="transitions_enddate">$enddate_label</label>
		$enddate_input
		<span class="transitions-starttime">$endtime_input</span>
	</p>
</div>

<div class="transitions-start transitions-end" style="margin:20px 0;">
	<p class="transitions-start">
		<label class="">$start_label $start_input</label>
	</p>
	<p class="transitions-end">
		<label class="" for="transitions_end">$end_label $end_input</label>
	</p>
</div>

<blockquote style="padding:20px;">
	<h3>$ressources_legend</h3>
	<p style="margin:20px 0;">
		<label class="" for="transitions_url">$url_label</label>
		$url_input<br />
		<em>$url_details</em>
	</p>

	<div style="margin:20px 0;">
		$attachment_link
		<label class="" for="transitions_attachment">$attachment_label</label><br />
		$attachment_input
	</div>
	<div class="clearfloat"></div>

	<p style="margin:20px 0;">
		<label class="" for="transitions_resourcelang">$resourcelang_label</label>
		$resourcelang_input
	</p>
</blockquote>

___HTML;



echo <<<___HTML
$draft_warning

<div class="flexible-block" style="width:56%;">
$content</div>

<div class="flexible-block" style="width:40%; float:right;">
$action_buttons
$sidebar
</div>

<div class="clearfloat"></div>

$admin_fields

<div class="clearfloat"></div>

<div class="elgg-foot">
	<div class="elgg-subtext mbm">
	$save_status <span class="transitions-save-status-time">$saved</span>
	</div>
	
	<div class="elgg-subtext mbm">
	$revisions
	</div>

	$guid_input
	$container_guid_input

</div>

___HTML;

