<?php
/* ESOPE
 * - Add some filters for easier content search
 * - Add rendering options for content embed
 * @TODO : should fully re-implement from plugin original JS + PHP structure
 * Or at least do some alignment with original view, but keep the many improvements and flexibility of this version
 */

// Selectors
// @TODO : use real subtypes list or configured, instead of hard-coded list
$allowed_subtypes = array(
	'all' => elgg_echo('theme_inria:option:nofilter'),
	'blog' => elgg_echo('blog'),
	'page_top' => elgg_echo('page_top'),
	'page' => elgg_echo('page'),
	'pages' => elgg_echo('pages') . ' (' . elgg_echo('all') . ')',
	'bookmarks' => elgg_echo('bookmarks'),
	'groupforumtopic' => elgg_echo('groups:forum'),
	'file' => elgg_echo('file'), 
	'event_calendar' => elgg_echo('event_calendar'),
);

// Embed templates
$available_templates = array(
	'default' => elgg_echo('newsletter:embed:template:default'),
	'fullcontent' => elgg_echo('newsletter:embed:template:fullcontent'),
	'fullcontentauthor' => elgg_echo('newsletter:embed:template:fullcontentauthor'),
);


// Input data and parameters
$newsletter = elgg_extract('entity', $vars);
$offset = (int) max(get_input("offset", 0), 0);
$limit = (int) max(get_input("limit", 6), 0);
$subtypes = get_input('subtypes', 'all');
// Subtypes adjustments
// Save input subtype for the form value
$input_subtypes = $subtypes;
if ($subtypes == 'all') {
	$subtypes = array('blog', 'bookmarks', 'event_calendar', 'file', 'groupforumtopic', 'page', 'page_top');
} else if ($subtypes == 'pages') {
	$subtypes = array('page', 'page_top');
}
// Used to select various embed content templates
$template = get_input('template', 'fullcontentauthor');
$display = get_input('display', false);
// Search query
$query = get_input('q');
$query = sanitise_string($query);

$dbprefix = elgg_get_config('dbprefix');

$show_all = (bool) get_input('show_all', false);

// Build selection query
$options = array(
		"type" => "object",
		"subtype" => $subtypes,
		"full_view" => false,
		"limit" => $limit,
		"offset" => $offset,
		"count" => true,
	);

if ($newsletter->getContainerEntity() instanceof ElggGroup) {
	$options["container_guid"] = $newsletter->getContainerGUID();
}

if (!empty($query)) {
	$options["joins"] = array("JOIN " . $dbprefix . "objects_entity oe ON e.guid = oe.guid");
	$options["wheres"] = array("(oe.title LIKE '%" . $query . "%')");
}

$count = elgg_get_entities($options);
unset($options['count']);

// Search form - always display it as we allow some wider search thah default setting
// Note : any new field/parameter should be added to the js/newsletter/site view
$form_data = '';
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:templates') . ' ' . elgg_view("input/select", array("name" => "template", "value" => $template, 'options_values' => $available_templates)) . '</label></p>';
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:search') . ' ' . elgg_view("input/text", array("name" => "q", "value" => $query)) . '</label></p>';
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:subtype') . ' ' . elgg_view("input/select", array("name" => "subtypes", "value" => $input_subtypes, 'options_values' => $allowed_subtypes)) . '</label></p>';
$form_data .= elgg_view("input/hidden", array('name' => "display", 'value' => 'yes'));
$form_data .= elgg_view("input/submit", array("value" => elgg_echo("search"), "class" => "elgg-button-action"));

echo elgg_view('input/form', [
	'action' => 'newsletter/embed/' . $newsletter->getGUID(), 
	'id' => 'newsletter-embed-search',
	'body' => $form_data,
	'disable_security' => true,
]);
echo '<div class="clearfloat"></div>';


// Search results
// Display search results only after we've clicked on Search button
if ($display) {
	$count = elgg_get_entities($options);
	unset($options["count"]);
	
	if ($count > 0) {
		$entities = elgg_get_entities($options);
	
		// Build selection list
		$embed_list = '';
		foreach ($entities as $entity) {
			// Note : embed views should be defined through newsletter/embed/" . $type . "/" . $subtype (+ template $vars in view)
			$embed_content = esope_newsletter_view_embed_content($entity, array('template' => $template));
			
			// Build list item
			$embed_list .= elgg_format_element('li', ['class' => 'newsletter-embed-item ' . $subtype], $embed_content);
		}

		$embed_wrapper .= elgg_format_element('ul', ['id' => 'newsletter-embed-list'], $embed_list);

		$show_all_value = $show_all ? 1 : 0;
	
		$embed_wrapper_pagination = elgg_view('navigation/pagination', [
			'base_url' => elgg_normalize_url("newsletter/embed/{$newsletter->getGUID()}?q={$query}&show_all={$show_all_value}"),
			'offset' => $offset,
			'limit' => $limit,
			'count' => $count,
		]);
		$embed_wrapper .= elgg_format_element('div', ['id' => 'newsletter-embed-pagination'], $embed_wrapper_pagination);

	} else {
		$embed_wrapper .= elgg_echo('notfound');
	}

	echo elgg_format_element('div', ['id' => 'newsletter-embed-wrapper'], $embed_wrapper);
	if ($count > 0) {
		echo elgg_view('newsletter/format');
	}

}

