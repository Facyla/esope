<?php
/**
 * Create a new page
 *
 * @package ElggPages
 */

$rubrique = strtolower(get_input('rubrique'));

$title = elgg_echo('theme_fing:qntransitions');
$sidebar = '';

elgg_pop_breadcrumb();
elgg_push_breadcrumb($title, 'qntransitions');
if (!empty($rubrique)) {
	if (in_array($rubrique, array('jeu', 'cahier'))) {
		$title = elgg_echo("theme_fing:qntransitions:$rubrique");
		elgg_push_breadcrumb($title);
	} else {
		$rubrique = false;
	}
}

switch($rubrique) {
	case 'jeu':
		$content .= elgg_view('cmspages/view', array('pagetype' => "qntransitions-jeu"));
		break;
	
	case 'cahier':
		$content .= elgg_view('cmspages/view', array('pagetype' => "qntransitions-cahier"));
		break;
	
	default:
		$content .= elgg_view('cmspages/view', array('pagetype' => "qntransitions-accueil"));
}


/* @TODO : use other layouts for inner pages ? (summary?)
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
));
*/

$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
));


echo elgg_view_page($title, $body);

