<?php
/**
* Elgg uhb_annonces candidate page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

$guid = get_input('guid');
$offer = get_entity($guid);

if (!elgg_instanceof($offer, 'object', 'uhb_offer')) {
	register_error(elgg_echo('uhb_annonces:error:noentity'));
	forward('annonces');
}


// Accès à l'annonce : public ssi IP université, ou tout membre dont le profil est dans la liste blanche
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }
if (!uhb_annonces_can_view()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorised'));
	//forward('annonces');
	return;
}

// Only some profiles can candidate to offers
if (!uhb_annonces_can_candidate()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorised'));
	return;
}

// Can candidate only to open offers
if ($offer->followstate != 'published') {
	register_error(elgg_echo('uhb_annonces:error:candidatewrongstate'));
	return;
}


// Get saved values in case it failed...
if (elgg_is_sticky_form('uhb_offer')) {
	$fields = uhb_annonces_get_fields('edit');
	extract(elgg_get_sticky_values('uhb_offer'));
	elgg_clear_sticky_form('uhb_offer');
}

$content = '';
$sidebar = '';


$title = '<br /><em>' . $offer->offerposition . '</em>';
switch($offer->typeoffer) {
	case 'stage':
		$title = elgg_echo('uhb_annonces:view:stage', array($title));
		break;
	case 'emploi':
		$title = elgg_echo('uhb_annonces:view:emploi', array(elgg_echo('uhb_annonces:typework:'.$offer->typework), $title));
		break;
	default:
		$title = elgg_echo('uhb_annonces:view', array(elgg_echo('uhb_annonces:typeoffer:'.$offer->typeoffer), $title));
}
//$title = elgg_echo('uhb_annonces:apply', array($title));

// Breacrumbs
elgg_push_breadcrumb(elgg_echo('uhb_annonces'), 'annonces');
elgg_push_breadcrumb($title, 'annonces/view/' . $offer->guid);
elgg_push_breadcrumb(elgg_echo('uhb_annonces:sidebar:offer:candidate'));


// Application form
//$content .= elgg_view_form('uhb_annonces/candidate', array(), array('entity' => $offer));
$content .= elgg_view('forms/uhb_annonces/candidate', array('entity' => $offer));

// Also display offer below for quick reference
$content .= '<div class="clearfloat"></div><br />';
$content .= '<hr />';
$content .= elgg_view_entity($offer, array('full_view' => true));

$sidebar .= elgg_view('uhb_annonces/sidebar', array('entity' => $offer));


// Compose page content
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page(strip_tags($title), $body);

