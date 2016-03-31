<?php
/* ESOPE
 * - Add subtype filtering
 * - Add other search filters
 * - Add rendering options for content embed
 * @TODO : should fully re-implement from plugin original JS + PHP structure
 * Or at least do some alignment with original view, but keep the many improvements and flexibility of this version
 */

// Selectors
// @TODO : use configured allowed subtypes list for best flexibility
// @TODO : default to searcheable subtypes
// For the moment, check that each subtype is enabled
$allowed_subtypes = array(
	'all' => elgg_echo('esope:option:nofilter'),
);
if (elgg_is_active_plugin('blog')) { $allowed_subtypes['blog'] = elgg_echo('blog'); }
if (elgg_is_active_plugin('pages')) {
	$allowed_subtypes['page_top'] = elgg_echo('page_top');
	$allowed_subtypes['page'] = elgg_echo('page');
	$allowed_subtypes['pages'] = elgg_echo('pages') . ' (' . elgg_echo('all') . ')';
}
if (elgg_is_active_plugin('bookmarks')) { $allowed_subtypes['bookmarks'] = elgg_echo('bookmarks'); }
if (elgg_is_active_plugin('groups')) { $allowed_subtypes['groupforumtopic'] = elgg_echo('groups:forum'); }
if (elgg_is_active_plugin('file')) { $allowed_subtypes['file'] = elgg_echo('file'); }
if (elgg_is_active_plugin('event_calendar')) { $allowed_subtypes['event_calendar'] = elgg_echo('event_calendar'); }
if (elgg_is_active_plugin('static')) { $allowed_subtypes['static'] = elgg_echo('static'); }


// Embed templates
// @TODO Move to newsletter/format
/*
$available_templates = array(
	'default' => elgg_echo('newsletter:embed:template:default'),
	'fullcontent' => elgg_echo('newsletter:embed:template:fullcontent'),
	'fullcontentauthor' => elgg_echo('newsletter:embed:template:fullcontentauthor'),
);
*/


// Input data and parameters
$newsletter = elgg_extract('entity', $vars);
$offset = (int) max(get_input('offset', 0), 0);
//$limit = 6;
$limit = (int) max(get_input("limit", 6), 0);
$subtype_filter = get_input('subtypes', 'all');
// Used to select various embed content templates
$template = get_input('template', 'fullcontentauthor');
$display = get_input('display', false);

$query = get_input('q');
$query = sanitise_string($query);

$dbprefix = elgg_get_config('dbprefix');

$show_all = (bool) get_input('show_all', false);

$subtypes = [];
// Subtypes adjustments
if ($subtype_filter == 'all') {
	// List real subtypes (remove the 2 special cases)
	foreach($allowed_subtypes as $allowed_subtype) {
		if (!in_array($allowed_subtype, array('all', 'pages'))) {
			$subtypes[] = $allowed_subtype;
		}
	}
} else if ($subtype_filter == 'pages') {
	$subtypes[] = 'page';
	$subtypes[] = 'page_top';
} else {
	$subtypes = $subtype_filter;
}

/*
if (elgg_is_active_plugin('blog')) {
	$subtypes[] = 'blog';
}
if (elgg_is_active_plugin('static')) {
	$subtypes[] = 'static';
}
*/

if (empty($subtypes)) {
	return;
}

// Build selection query
$options = [
	'type' => 'object',
	'subtypes' => $subtypes,
	'full_view' => false,
	'limit' => $limit,
	'offset' => $offset,
	'count' => true,
	'wheres' => [],
];

$container = $newsletter->getContainerEntity();
if (empty($show_all) && elgg_instanceof($container, 'group')) {
	$container_guid = $newsletter->getContainerGUID();
	
	//if (elgg_is_active_plugin('static')) {
	if (elgg_is_active_plugin('static') && in_array('static', $subtypes)) {
		// static subpages do not have a group container so do an extra check
		$options['wheres'][] = "
			((e.container_guid = {$container_guid}) OR e.guid IN (
				SELECT sub_r.guid_one from {$dbprefix}entity_relationships sub_r
				JOIN {$dbprefix}entities sub_e ON sub_e.guid = sub_r.guid_two
				WHERE sub_e.container_guid = {$container_guid}
				AND sub_r.relationship = 'subpage_of'
			))";
	} else {
		$options['container_guid'] = $container_guid;
	}
}

if (!empty($query)) {
	$options['joins'] = ["JOIN {$dbprefix}objects_entity oe ON e.guid = oe.guid"];
	$options['wheres'][] = "(oe.title LIKE '%{$query}%')";
}

$count = elgg_get_entities($options);
unset($options['count']);

// Search form - always display it as we allow some wider search thah default setting
// Note : any new field/parameter should be added to the js/newsletter/site view
$form_data = '';

// Rendering template selection @TODO this is now handled in newsletter/format and js/newsletter/embed
//$form_data .= '<p><label>' . elgg_echo('newsletter:embed:templates') . ' ' . elgg_view("input/select", array("name" => "template", "value" => $template, 'options_values' => $available_templates)) . '</label></p>';

// search form
// Title search
//$form_data = elgg_view('input/text', ['name' => 'q', 'value' => $query]);
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:search') . ' ' . elgg_view("input/text", array("name" => "q", "value" => $query)) . '</label></p>';

// Subtype filter
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:subtype') . ' ' . elgg_view("input/select", array("name" => "subtypes", "value" => $subtype_filter, 'options_values' => $allowed_subtypes)) . '</label></p>';

// Setting that enables to hide the results at first display (useful to set the wanted rendering type first)
$form_data .= elgg_view("input/hidden", array('name' => "display", 'value' => 'yes'));

// Allow to keep setting from pagination
$form_data .= elgg_view("input/hidden", array('name' => "limit", 'value' => $limit));
$form_data .= elgg_view("input/hidden", array('name' => "offset", 'value' => $offset));

// Submit button
$form_data .= elgg_view('input/submit', ['value' => elgg_echo('search'), 'class' => 'elgg-button-action']);

if (elgg_instanceof($container, 'group')) {
	$show_all_checkbox = elgg_view('input/checkbox', [
		'name' => 'show_all',
		'value' => '1',
		'checked' => $show_all,
		'default' => false,
	]);
	$show_all_checkbox .= elgg_echo('newsletter:embed:show_all');
	$form_data .= elgg_format_element('div', ['class' => 'mts'], $show_all_checkbox);
}

$embed_wrapper = elgg_view('input/form', [
	'action' => 'newsletter/embed/' . $newsletter->getGUID(), 
	'id' => 'newsletter-embed-search',
	'body' => $form_data,
	'disable_security' => true,
]);
//$embed_wrapper .= '<div class="clearfloat"></div>';


// Search results
// Display search results only after we've clicked on Search button
if ($display) {
	
	if ($count > 0) {
		$entities = elgg_get_entities($options);
	
		$embed_list = '';
		// Note : embed views should be defined through newsletter/embed/" . $type . "/" . $subtype (+ template $vars in view)
		foreach ($entities as $entity) {
			//$embed_list .= elgg_format_element('li', ['class' => 'newsletter-embed-item'], newsletter_view_embed_content($entity, ['newsletter' => $newsletter]));
			// Use custom function to generate content (@TODO : use views system instead)
			//$embed_list .= elgg_format_element('li', ['class' => 'newsletter-embed-item ' . $subtype, 'template' => $template], esope_newsletter_view_embed_content($entity, ['newsletter' => $newsletter]));
			$embed_list .= elgg_format_element('li', ['class' => 'newsletter-embed-item ' . $subtype, 'template' => $template], newsletter_view_embed_content($entity, ['newsletter' => $newsletter]));
		}

		$embed_wrapper .= elgg_format_element('ul', ['id' => 'newsletter-embed-list'], $embed_list);

		$show_all_value = $show_all ? 1 : 0;
	
		$embed_wrapper_pagination = elgg_view('navigation/pagination', [
			//'base_url' => elgg_normalize_url("newsletter/embed/{$newsletter->getGUID()}?q={$query}&show_all={$show_all_value}"),
			'base_url' => elgg_normalize_url("newsletter/embed/{$newsletter->getGUID()}?q={$query}&show_all={$show_all_value}&display={$display}&template={$template}&subtypes={$subtype_filter}&offset={$offset}&limit={$limit}"),
			'offset' => $offset,
			'limit' => $limit,
			'count' => $count,
		]);
		$embed_wrapper .= elgg_format_element('div', ['id' => 'newsletter-embed-pagination'], $embed_wrapper_pagination);

	} else {
		$embed_wrapper .= elgg_echo('notfound');
	}

}

echo elgg_format_element('div', ['id' => 'newsletter-embed-wrapper'], $embed_wrapper);
if ($count > 0) {
	echo elgg_view('newsletter/format');
}

