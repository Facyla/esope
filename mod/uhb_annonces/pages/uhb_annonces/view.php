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

$guid = get_input('guid');

// Entities are always disabled, so we don't have to worry about people trying to access unwanted metadata...
// See page_handler note for more details
elgg_set_ignore_access(true);
$offer = get_entity($guid);

if (!elgg_instanceof($offer, 'object', 'uhb_offer')) {
	register_error(elgg_echo('uhb_annonces:error:noentity'));
	forward('annonces');
}


// Accès à l'annonce : public ssi IP université, ou tout membre dont le profil est dans la liste blanche
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }
if (!uhb_annonces_can_view_offer($offer)) {
	register_error(elgg_echo('uhb_annonces:error:unauthorised'));
	forward('annonces');
}

$content = '';
$sidebar = '';

// Breacrumbs
elgg_push_breadcrumb(elgg_echo('uhb_annonces'), 'annonces');
elgg_push_breadcrumb(elgg_echo('uhb_annonces:search'), 'annonces/search');


// Accès à cette annonce (selon état)
if (uhb_annonces_has_access_to_offer($offer)) {
	$ownguid = elgg_get_logged_in_user_guid();
	
	$apply = false;
	if (uhb_annonces_can_candidate() && (get_input('apply', false))) { $apply = true; }
	
	$already_applied = false;
	if (!$admin && uhb_annonces_can_candidate()) {
		if (check_entity_relationship($ownguid, 'has_candidated', $offer->guid)) { $already_applied = true; }
	}
	
	// STEPS MENU (FILTER OVERRIDE)
	// JS tabs support
	$filter_override = '';
	
	$filter_override .= '<script>
	function uhb_annonces_selecttab(tab) {
		$(\'.uhb_annonces-view-step\').hide();
		$(\'.uhb_annonces-view-step\' + tab).show();
		$(\'.uhb_annonces-view-menu li\').removeClass(\'elgg-state-selected\');
		$(\'.uhb_annonces-view-link\' + tab).addClass(\'elgg-state-selected\');
	}
	</script>';
	$filter_override .= '<div class="uhb_annonces-view-menu"><ul class="elgg-menu-filter elgg-menu elgg-menu-hz elgg-menu-filter-default">';
	if ($admin) {
		$filter_override .= '<li class="uhb_annonces-view-link1 elgg-state-selected"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(1);">' . elgg_echo('uhb_annonces:view:menu:structure') . '</a></li>';
	$filter_override .= '<li class="uhb_annonces-view-link2"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(2);">' . elgg_echo('uhb_annonces:view:menu:offer') . '</a></li>';
	$filter_override .= '<li class="uhb_annonces-view-link3"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(3);">' . elgg_echo('uhb_annonces:view:menu:contact') . '</a></li>';
		$filter_override .= '<li class="uhb_annonces-view-link4"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(4);">' . elgg_echo('uhb_annonces:view:menu:admin') . '</a></li>';
	} else {
		if ($apply) {
			$filter_override .= '<li class="uhb_annonces-view-link1"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(1);">' . elgg_echo('uhb_annonces:view:menu:structure') . '</a></li>';
		} else {
			$filter_override .= '<li class="uhb_annonces-view-link1 elgg-state-selected"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(1);">' . elgg_echo('uhb_annonces:view:menu:structure') . '</a></li>';
		}
		$filter_override .= '<li class="uhb_annonces-view-link2"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(2);">' . elgg_echo('uhb_annonces:view:menu:offer') . '</a></li>';
		if (uhb_annonces_can_candidate()) {
			$candidate_title = elgg_echo('uhb_annonces:view:menu:candidate');
			if ($already_applied) $candidate_title = elgg_echo('uhb_annonces:view:menu:candidate:done');
			if ($apply) {
				$filter_override .= '<li class="uhb_annonces-view-link3 elgg-state-selected"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(3);">' . $candidate_title . '</a></li>';
			} else {
				$filter_override .= '<li class="uhb_annonces-view-link3"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(3);">' . $candidate_title . '</a></li>';
			}
		}
	}
	$filter_override .= '</ul></div>';
	
	// Title
	$title = '<em>' . $offer->offerposition . '</em>';
	$guid = $offer->guid;
	switch($offer->typeoffer) {
		case 'stage':
			$title = elgg_echo('uhb_annonces:view:stage', array($guid, $title));
			break;
		case 'emploi':
			if (empty($offer->typework)) {
				$title = elgg_echo('uhb_annonces:view:emploi:notype', array($guid, $title));
			} else {
				$title = elgg_echo('uhb_annonces:view:emploi', array($guid, elgg_echo('uhb_annonces:typework:'.$offer->typework), $title));
			}
			break;
		default:
			$title = elgg_echo('uhb_annonces:view', array($guid, elgg_echo('uhb_annonces:typeoffer:'.$offer->typeoffer), $title));
	}
	if (in_array($offer->followstate, array('filled', 'archive'))) { $title = '[' . elgg_echo('uhb_annonces:followstate:'.$offer->followstate) . '] ' . $title; }

	// Breadcrumbs
	elgg_push_breadcrumb($title);

	// CONTENT
	$content .= elgg_view_entity($offer, array('full_view' => true));
	
	// Sidebar
	$sidebar .= elgg_view('uhb_annonces/sidebar', array('entity' => $offer));
	
	
} else {
	// No access : generic explanation on access to offers
	$content .= '<p>' . elgg_echo('uhb_annonces:error:noaccess') . '</p>';
	$sidebar .= elgg_view('uhb_annonces/sidebar');
}


// Compose page content
$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter_override' => $filter_override));

// Render the page
echo elgg_view_page(strip_tags($title), $body);

