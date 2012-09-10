<?php
/**
 * List entities by category
 *
 * @package ElggCategories
 */

global $CONFIG;
$limit = get_input("limit", 10);
$offset = get_input("offset", 0);
$category = get_input("category");
$owner_guid = get_input("owner_guid", ELGG_ENTITIES_ANY_VALUE);
$subtype = get_input("subtype", ELGG_ENTITIES_ANY_VALUE);
$type = get_input("type", 'object');
$site = $CONFIG->site;

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('categories'));
if (empty($category)) {
  $title = elgg_echo('adf_platform:categories:all', array($category));
  elgg_push_breadcrumb(elgg_echo('adf_platform:categories:all'));
} else {
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
$sidebar = '<h2>Thématiques</h2>';
$sidebar .= '<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-categories elgg-menu-owner-block-default">';
if (empty($category)) {
  $sidebar .= '<li class="elgg-state-selected"><a href="' . $url . 'categories">' . elgg_echo('adf_platform:categories:all') . '</a></li>';
} else {
  $sidebar .= '<li><a href="' . $url . 'categories">' . elgg_echo('adf_platform:categories:all') . '</a></li>';
}
foreach ($themes as $theme) {
  //$is_current = str_replace(' ', '+', $theme);
  if ($theme == $category) {
    $sidebar .= '<li class="elgg-state-selected"><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme . '</a></li>';
  } else {
    $sidebar .= '<li><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme . '</a></li>';
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
