<?php
/**
* Group profile activity
* 
* @package ElggGroups
*/ 

//$group = elgg_extract('entity', $vars);
$group = elgg_get_page_owner_entity();
if (!$group instanceof ElggGroup) {
	return;
}

if (!$group->isToolEnabled('pages')) {
	return;
}

// need to draw our own content because we only want top pages
$max_top_pages = 6;
$top_pages_params = [
	'type' => 'object',
	'subtype' => 'page',
	'container_guid' => $group->guid,
	'metadata_name_value_pairs' => [
		'parent_guid' => 0,
	],
	'limit' => $max_top_pages,
	'full_view' => false,
	'pagination' => false,
	'no_results' => elgg_echo('pages:none'),
];
$count_top_pages = $top_pages_params + ['count' => true];
$top_pages = elgg_get_entities($top_pages_params);
if (count($top_pages) > 0) {
	foreach($top_pages as $entity) {
		// Navigation du wiki
		//$content .= elgg_view('pages/sidebar/navigation', ['page' => $entity]);
		$content .= elgg_view_menu('pages_nav', [
			'class' => ['pages-nav', 'elgg-menu-page'],
			'entity' => $entity,
		]);
	}
	if ($count_top_pages > $max_top_pages) {
		$remaining = $count_top_pages - $max_top_pages;
		$content .= elgg_view('output/url', ['href' => elgg_get_site_url() . "pages/group/{$group->guid}/all", 'text' => elgg_echo('search:more', [$remaining, ''])]);
	}
} else {
	$content .= elgg_view('output/url', ['href' => elgg_get_site_url() . "pages/add/{$group->guid}", 'text' => elgg_echo('add:object:page')]);
}

//echo '<div class="group-sidebar-pages-nav">' . $content . '</div>';
//echo '<h3>Pages du groupe</h3><div class="group-sidebar-pages-nav">' . $content . '</div>';
echo elgg_view_module('aside', "Pages du groupe", '<div class="group-sidebar-pages-nav">' . $content . '</div>');

