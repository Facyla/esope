<?php
/**
 * List entities by category
 *
 * @package ElggCategories
 */

$limit = get_input("limit", 10);
$offset = get_input("offset", 0);
$category = get_input("category");
$owner_guid = get_input("owner_guid", ELGG_ENTITIES_ANY_VALUE);
$subtype = get_input("subtype", ELGG_ENTITIES_ANY_VALUE);
$type = get_input("type", 'object');
$site = elgg_get_site_entity();

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('categories'));
if (empty($category)) {
	$title = elgg_echo('esope:categories:all', array($category));
	elgg_push_breadcrumb(elgg_echo('esope:categories:all'));
} else {
	elgg_push_breadcrumb(elgg_echo('esope:categories:all'));
	elgg_push_breadcrumb(elgg_echo($category));
	$title = elgg_echo('categories:results', array($category));
}


$params = array(
	'metadata_name' => 'universal_categories',
	'metadata_value' => $category,
	'types' => $type,
	'subtypes' => $subtype,
	'owner_guid' => $owner_guid,
	'limit' => $limit,
	'full_view' => FALSE,
	'metadata_case_sensitive' => FALSE,
);
$objects = elgg_list_entities_from_metadata($params);


$content = elgg_view_title($title);
$content .= $objects;

// Liste des catégories (thématiques du site)
$themes = $site->categories;
sort($themes);

// We need category => category to implement label (can be different from full category name)
$themes = array_flip($themes);
array_walk($themes, create_function('&$v, $k', '$v = $k;'));

// Add tree categories support
foreach ($themes as $k => $theme) {
	if (strpos($theme, '/') !== false) {
		$theme_a = explode('/', $theme);
		$theme_label = '';
		for ($i = 1; $i < count($theme_a); $i++) { $theme_label .= "-"; }
		$theme_label .= ' ' . end($theme_a);
		$themes[$k] = $theme_label;
	}
}

$sidebar = '<h2>' . elgg_echo('esope:categories') . '</h2>';
$sidebar .= '<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-categories elgg-menu-owner-block-default">';
if (empty($category)) {
	$sidebar .= '<li class="elgg-state-selected"><a href="' . $url . 'categories">' . elgg_echo('esope:categories:all') . '</a></li>';
} else {
	$sidebar .= '<li><a href="' . $url . 'categories">' . elgg_echo('esope:categories:all') . '</a></li>';
}
foreach ($themes as $theme => $theme_label) {
	//$is_current = str_replace(' ', '+', $theme);
	if ($theme == $category) {
		$sidebar .= '<li class="elgg-state-selected"><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme_label . '</a></li>';
	} else {
		$sidebar .= '<li><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme_label . '</a></li>';
	}
}
$sidebar .= '</ul>';

$sidebar = '<div id="site-categories">' . $sidebar . '</div>';


$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => $sidebar,
	'header' => '',
));

echo elgg_view_page($title, $body);

