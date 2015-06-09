<?php
/**
 * Create a new page
 *
 * @package ElggPages
 */


$title = elgg_echo('theme_fing:qntransitions');
$sidebar = '';

elgg_pop_breadcrumb();
elgg_push_breadcrumb($title, 'qntransitions');

$pagetype = elgg_get_friendly_title(get_input('pagetype'));
if (empty($pagetype)) { $pagetype = 'accueil'; }

// Display only existing pages
$pagetype = 'qntransitions-' . $pagetype;
if (!cmspages_exists($pagetype)) { $pagetype = 'qntransitions-accueil'; }

// Get the page
$cmspage = cmspages_get_entity($pagetype);

// Add 2nd level breadcrumb
if ($pagetype != 'qntransitions-accueil') {
	//$title = elgg_echo("theme_fing:qntransitions:$pagetype");
	$title = $cmspage->title;
	elgg_push_breadcrumb($title);
}


//$content .= elgg_view('cmspages/view', array('pagetype' => "qntransitions-$pagetype"));
$content .= elgg_view('cmspages/view', array('entity' => $cmspage));



/* @TODO : use other layouts for inner pages ? (summary?)
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
));

$body = elgg_view_layout('one_column', array(
	'content' => $content,
	//'title' => $title,
	'title' => false,
));


echo elgg_view_page($title, $body);
*/

$headers = '';
echo elgg_render_embed_content($content, $title, 'iframe', $headers);


