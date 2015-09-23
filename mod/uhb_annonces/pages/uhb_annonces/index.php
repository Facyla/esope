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

$title = elgg_echo('uhb_annonces:title');

// Breacrumbs
elgg_push_breadcrumb(elgg_echo('uhb_annonces'));
//elgg_push_breadcrumb(elgg_echo('uhb_annonces:home'));


$content = '';
$sidebar = '';

$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }

// Set warning delay
$confirmed_warning_ts = time()-3600*24*2;
$confirmed_warning_ts = mktime(date("H", $confirmed_warning_ts), date("i", $confirmed_warning_ts), date("s", $confirmed_warning_ts), date("n", $confirmed_warning_ts), date("j", $confirmed_warning_ts), date("Y", $confirmed_warning_ts));
// Note : the search uses a 1 day padding to be able to get data that corresponds to a specific day, 
// so we need to use this padding here as well if we want to get consistent results
// That's also why we're checking results using full days timestamp and not exact timestamp diff
$confirmed_warning_ts_search = $confirmed_warning_ts - 3600*24;



// BUILD STATS

// Everyone stats
// postes d'emploi ou de stage en cours de recrutement
$offres_open = uhb_annonces_get_from_state('published', true);
// annonces pourvues ou archivées
$offres_archive = uhb_annonces_get_from_state('archive', true);
$offres_filled = uhb_annonces_get_from_state('filled', true);
$offres_closed = $offres_archive + $offres_filled;

// Additional admin stats
if ($admin) {
	// Annonces dans l'état initial (non confirmée par email)
	$offres_new = uhb_annonces_get_from_state('new', true);
	// Annonces confirmées = annonces à valider pour publication
	$offres_confirmed = uhb_annonces_get_from_state('confirmed', true);
	// @TODO : confirmées mais date > 2 jours après dernière modification (time_updated)
	$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'metadata_name_value_pairs' => array('name' => 'followstate', 'value' => 'confirmed'), 'count' => true, 'created_time_upper' => ($confirmed_warning_ts));
	$offres_confirmed_warning = elgg_get_entities_from_metadata($params);
	if (!$offres_confirmed_warning) $offres_confirmed_warning = "0";
	// Annonces obsolètes = publiées mais dont la date de fin de publication est dans moins de 7 jours
	// Note : ces annonces font l'objet d'une relance auto à J-7
	$offres_obsolete = elgg_get_entities_from_metadata(array(
			'types' => 'object', 'subtypes' => 'uhb_offer', 
			'metadata_name_value_pairs' => array(
				array('name' => 'followend', 'value' => time() + 7*24*3600, 'operand' => '<'), 
				array('name' => 'followstate', 'value' => 'published')
			), 
			'count' => true
		));
	if (!$offres_obsolete) $offres_obsolete = "0";
	
	// Signalées comme étant pourvues (= plus de 1 signalement effectué)
	$offres_reportfilled = elgg_get_entities_from_metadata(array('types' => 'object', 'subtypes' => 'uhb_offer', 'metadata_name_value_pairs' => array('name' => 'followreport', 'value' => 0, 'operand' => '>'), 'count' => true));
	if (!$offres_reportfilled) $offres_reportfilled = "0";
	
	$memorised = uhb_annonces_get_from_relationship('memorised', false, false, true);
	$candidated = uhb_annonces_get_from_relationship('has_candidated', false, false, true);
	$reported = uhb_annonces_get_from_relationship('reported', false, false, true);
}


// SIDEBAR
$sidebar .= elgg_view('uhb_annonces/sidebar');


// CONTENT
// Accès à l'accueil : tout public, mais contenu varie selon profils
$content .= '<p>' . elgg_echo('uhb_annonces:basicstat', array($offres_open, $offres_closed)) . '</p>';


if ($admin) {
	$content .= '<h3>' . elgg_echo('uhb_annonces:admin:title') . '</h3>';
	$content .= '<p>' . elgg_echo('uhb_annonces:role:admin');
	$publish_link = '<a href="' . $CONFIG->url . 'annonces/search?action=search&followstate=confirmed">' . elgg_echo('uhb_annonces:unpublished:link', array($offres_confirmed)) . '</a>';
	$content .= '<p>' . elgg_echo('uhb_annonces:unpublished', array($publish_link)) . '</p>';
	// @TODO Ajouter annonces non validées, mais créées depuis plus de 2 jours
	$publish_warning_link = '<a href="' . $CONFIG->url . 'annonces/search?action=search&followstate=confirmed&followcreation_max=' . $confirmed_warning_ts_search . '">' . elgg_echo('uhb_annonces:unpublished:warning:link', array($offres_confirmed_warning)) . '</a>';
	$content .= '<p class="unpublished-warning">' . elgg_echo('uhb_annonces:unpublished:warning', array($publish_warning_link)) . '</p>';
	$offres_total = elgg_get_entities(array('types' => 'object', 'subtypes' => 'uhb_offer', 'count' => true));
	if (!$offres_total) $offres_total = "0";
	$content .= '<p>' . elgg_echo('uhb_annonces:stats:title', array($offres_total)) . '</p>';
	$content .= '<ul>';
	$content .= '<li><a href="' . $CONFIG->url . 'annonces/search?action=search&followstate=new">' . elgg_echo('uhb_annonces:stats:initial', array($offres_new)) . '</li>';
	// Annonces à date de fin - 7 jours
	$content .= '<li><a href="' . $CONFIG->url . 'annonces/search?action=search&followstate=published&followend_max=' . (time() + 7*24*3600). '">' . elgg_echo('uhb_annonces:stats:obsolete', array($offres_obsolete)) . '</a></li>';
	$content .= '<li><a href="' . $CONFIG->url . 'annonces/search?action=search&followreported_min=1">' . elgg_echo('uhb_annonces:stats:reportfilled', array($offres_reportfilled)) . '</a></li>';
	$content .= '<li><a href="' . $CONFIG->url . 'annonces/search?action=search&followstate=filled">' . elgg_echo('uhb_annonces:stats:filled', array($offres_filled)) . '</a></li>';
	$content .= '<li><a href="' . $CONFIG->url . 'annonces/search?action=search&followstate=archive">' . elgg_echo('uhb_annonces:stats:archive', array($offres_archive)) . '</a></li>';
	
	$content .= '</ul>';
	
} else {
	
	// Search and reply
	if (uhb_annonces_can_view()) {
		$searchorreply_link = '<a href="' . $CONFIG->url . 'annonces/search">' . elgg_echo('uhb_annonces:offre:searchorreply:link') . '</a>';
		$content .= '<p>' . elgg_echo('uhb_annonces:offre:searchorreply', array($searchorreply_link)) . '</p>';
	}
	//if (uhb_annonces_can_candidate()) {}

	// Add offer link
	$create_link = '<a href="' . $CONFIG->url . 'annonces/add">' . elgg_echo('uhb_annonces:offre:create:link') . '</a>';
	$content .= '<p>' . elgg_echo('uhb_annonces:offre:create', array($create_link)) . '</p>';
	
}

// Add disclaimer for non-authorized public
if (!uhb_annonces_public_gatekeeper()) { $content .= '<p>' . elgg_echo('uhb_annonces:disclaimer') . '</p>'; }


// Wraps content so lists are displayed correctly...
$content = elgg_view('output/longtext', array('value' => $content));



// DEV : Pour tester rapidement diverses vues...
/*
$content .= elgg_view('uhb_annonces/my_offers');
$content .= elgg_view('uhb_annonces/my_candidated');
$content .= elgg_view('uhb_annonces/my_memorised');
$content .= elgg_view('uhb_annonces/reported');
$content .= elgg_view('uhb_annonces/reported_by');
*/


// Compose page content
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

