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

// Si offre demandée mais non valide => eject
if (!empty($guid) && !elgg_instanceof($offer, 'object', 'uhb_offer')) {
	register_error(elgg_echo('uhb_annonces:error:noentity'));
	forward('annonces');
}

// Droits d'accès
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }

// Gestion des accès, selon l'état, le type de profil, et avec message d'alerte
if (!uhb_annonces_can_edit_offer($offer, elgg_get_logged_in_user_entity(), true)) { forward('annonces'); }

// Edition / création
$new = true;
$title = elgg_echo('uhb_annonces:form:add');
if (elgg_instanceof($offer, 'object', 'uhb_offer')) {
	$title = elgg_echo('uhb_annonces:form:edit:your');
	if ($admin) { $title = elgg_echo('uhb_annonces:form:edit'); }
	$new = false;
}

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('uhb_annonces'), 'annonces');
elgg_push_breadcrumb($title);

$content = '';
$sidebar = '';



// STEPS MENU (FILTER OVERRIDE)
// JS tabs support
$filter_override = '';
$filter_override .= '<script>
function uhb_annonces_selecttab(tab) {
	$(\'.uhb_annonces-form-step\').hide();
	$(\'.uhb_annonces-form-step\' + tab).show();
	$(\'#uhb_annonces-edit-form-menu li\').removeClass(\'elgg-state-selected\');
	$(\'.uhb_annonces-form-link\' + tab).addClass(\'elgg-state-selected\');
}
</script>';
$filter_override .= '<div id="uhb_annonces-edit-form-menu"><ul class="elgg-menu-filter elgg-menu elgg-menu-hz elgg-menu-filter-default">';
if ($admin) {
	$filter_override .= '<li class="uhb_annonces-form-link0 elgg-state-selected"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(0);">' . elgg_echo('uhb_annonces:form:step0') . '</a></li>';
	$filter_override .= '<li class="uhb_annonces-form-link1"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(1);">' . elgg_echo('uhb_annonces:form:step1') . '</a></li>';
} else {
	$filter_override .= '<li class="uhb_annonces-form-link1 elgg-state-selected"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(1);">' . elgg_echo('uhb_annonces:form:step1') . '</a></li>';
}
$filter_override .= '<li class="uhb_annonces-form-link2"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(2);">' . elgg_echo('uhb_annonces:form:step2') . '</a></li>';
$filter_override .= '<li class="uhb_annonces-form-link3"><a href="javascript:void(0);" onclick="uhb_annonces_selecttab(3);">' . elgg_echo('uhb_annonces:form:step3') . '</a></li>';
$filter_override .= '</ul></div>';



// CONTENT
$content .= elgg_view('forms/uhb_annonces/edit', array('entity' => $offer));


// SIDEBAR
$sidebar .= elgg_view('uhb_annonces/sidebar', array('entity' => $offer));


// Compose page content
$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter_override' => $filter_override));

// Render the page
echo elgg_view_page($title, $body);

