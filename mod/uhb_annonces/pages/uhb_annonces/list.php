<?php
/**
* Elgg output page content
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

$default_filter = 'mine';
// Profile type
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') {
	$admin = true;
	$default_filter = 'all';
}
$filter = get_input('filter', $default_filter);

// Accès aux listings : public ssi IP université, ou tout membre dont le profil est dans la liste blanche
// Exception : les pro peuvent consulter leurs propres offres
if (!uhb_annonces_can_view() && ($filter != 'mine')) {
	register_error(elgg_echo('uhb_annonces:error:unauthorised'));
	forward('annonces');
}

// Filter validation and defaults
if ($admin) {
	// Admin : default to 'all' if invalid
	$allowed_filters = array('all', 'new', 'confirmed', 'published', 'filled', 'archive', 'reported', 'memorised', 'candidated', 'mine', 'anonymous');
	if (!in_array($filter, $allowed_filters)) { $filter = 'all'; }
} else {
	// Non admins : allow only memorised, candidated and mine for regular users
	$allowed_filters = array('memorised', 'candidated', 'mine');
	if (!in_array($filter, $allowed_filters)) { $filter = 'mine'; }
}

if ($admin) {
	$title = elgg_echo("uhb_annonces:list:$filter");
} else {
	$title = elgg_echo("uhb_annonces:list:mine:$filter");
}

// Breacrumbs
elgg_push_breadcrumb(elgg_echo('uhb_annonces'), 'annonces');
//if ($admin) elgg_push_breadcrumb(elgg_echo('uhb_annonces:list'), "annonces/list");
elgg_push_breadcrumb($title);

$content = '';
// SIDEBAR
$sidebar = '';
$sidebar .= elgg_view('uhb_annonces/sidebar');

// Build filters menu
foreach ($allowed_filters as $name) {
	$tab = array(
		'name' => $name,
		'text' => elgg_echo('uhb_annonces:tab:' . $name),
		'href' => 'annonces/list/' . $name,
		'selected' => ($filter == $name),
	);
	elgg_register_menu_item('filter', $tab);
}
$filter_override = elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));



// Recherche multicritère : 
// Admins ont accès à tout
// Autres = accès seulement dans l'état 'published' + leurs offres mémorisées et celles auxquelles ils ont candidaté
// + offres publiées pour les auteurs
// Filtres personnels à part sur "Mes offres retenues" et "Mes candidatures"

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$addparams = array('limit' => $limit, 'offset' => $offset);

switch ($filter) {
	case 'new':
		$count = uhb_annonces_get_from_state('new', true);
		$offers = uhb_annonces_get_from_state('new', false, $addparams);
		break;
	case 'confirmed':
		// annonces à valider pour publication
		$count = uhb_annonces_get_from_state('confirmed', true);
		$offers = uhb_annonces_get_from_state('confirmed', false, $addparams);
		break;
	case 'published':
		if (!$admin) $params['owner_guid'] = elgg_get_logged_in_user_guid();
		$count = uhb_annonces_get_from_state('published', true, $addparams);
		$offers = uhb_annonces_get_from_state('published', false, $addparams);
		break;
	case 'filled':
		$count = uhb_annonces_get_from_state('filled', true);
		$offers = uhb_annonces_get_from_state('filled', false, $addparams);
		break;
	case 'archive':
		$count = uhb_annonces_get_from_state('archive', true);
		$offers = uhb_annonces_get_from_state('archive', false, $addparams);
		break;
	case 'all':
		$count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'uhb_offer', 'count' => true));
		$offers = elgg_get_entities(array('types' => 'object', 'subtypes' => 'uhb_offer', 'limit' => $limit, 'offset' => $offset));
		break;
	case 'anonymous':
		$count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'uhb_offer', 'owner_guid' => $CONFIG->site->guid, 'count' => true));
		$offers = elgg_get_entities(array('types' => 'object', 'subtypes' => 'uhb_offer', 'owner_guid' => $CONFIG->site->guid, 'limit' => $limit, 'offset' => $offset));
		break;
	
	case 'reported':
		//$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'reported', 'metadata_names' => 'followstate', 'metadata_values' => array('published', 'archive', 'filled'), 'count' => true, 'limit' => $limit, 'offset' => $offset);
		$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'reported', 'count' => true, 'limit' => $limit, 'offset' => $offset);
		if (!$admin) $params['relationship_guid'] = elgg_get_logged_in_user_guid();
		$count = elgg_get_entities_from_relationship($params);
		$params['count'] = false;
		$offers = elgg_get_entities_from_relationship($params);
		break;
	
	case 'memorised':
		//$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'memorised', 'metadata_names' => 'followstate', 'metadata_values' => array('published', 'archive', 'filled'), 'count' => true, 'limit' => $limit, 'offset' => $offset);
		$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'memorised', 'count' => true, 'limit' => $limit, 'offset' => $offset);
		if (!$admin) $params['relationship_guid'] = elgg_get_logged_in_user_guid();
		$count = elgg_get_entities_from_relationship($params);
		$params['count'] = false;
		$offers = elgg_get_entities_from_relationship($params);
		break;
	case 'candidated':
		//$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'has_candidated', 'metadata_names' => 'followstate', 'metadata_values' => array('published', 'archive', 'filled'), 'count' => true, 'limit' => $limit, 'offset' => $offset);
		$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'has_candidated', 'count' => true, 'limit' => $limit, 'offset' => $offset);
		if (!$admin) $params['relationship_guid'] = elgg_get_logged_in_user_guid();
		$count = elgg_get_entities_from_relationship($params);
		$params['count'] = false;
		$offers = elgg_get_entities_from_relationship($params);
		break;
	
	default:
	case 'mine':
		$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'count' => true, 'limit' => $limit, 'offset' => $offset, 'owner_guid' => elgg_get_logged_in_user_guid());
		$count = elgg_get_entities($params);
		$params['count'] = false;
		$offers = elgg_get_entities($params);
		break;
}

// Add count to title
$title .= " ($count)";
//$content .= elgg_echo('uhb_annonces:count', array($count));

$content .= elgg_view_entity_list($offers, array('count' => $count, 'full_view' => false, 'pagination' => true, 'limit' => $limit, 'offset' => $offset));



// Compose page content
if ($admin) {
	$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter_context' => $filter, 'filter' => $filter_override));
} else {
	$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
}

// Render the page
echo elgg_view_page($title, $body);

