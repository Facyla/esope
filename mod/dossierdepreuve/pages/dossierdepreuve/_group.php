<?php
/**
 * Elgg dossierdepreuve browser
 * 
* @package Elggdossierdepreuve
* @author Facyla
* @copyright Items International 2010-2012
* @link http://items.fr/
 */

//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
global $CONFIG;

$limit = get_input("limit", 30);
$offset = get_input("offset", 0);
$group_guid = get_input("group", false);

if (!$group = get_entity($group_guid)) { forward(REFERER); }

// Affiche tous les dossiers de preuve - filtrage par OF / groupe / formateur de ratachement => à définir

// Get the current page's owner to the group
elgg_set_page_owner_guid($group_guid);

$cloudtags = array();

$content = '';
$dossiersdepreuves = '';
elgg_set_context('search');

/*
// Membres du groupe, et filtrage des apprenants
$group_members_count = $group->getMembers(10, 0, true);
$group_members = $group->getMembers($group_members_count);
foreach ($group_members as $user) {
	$profile_type = dossierdepreuve_get_user_profile_type($user);
	if ($profile_type == 'learner') {
		$group_learners[] = $user;
		$group_learners_guids[] = $user->guid;
		// Les éléments du dossier
		$dossiers = dossierdepreuve_get_user_dossier($user->guid, 'b2iadultes');
		$dossiersdepreuves .= '<hr />';
		$dossiersdepreuves .= '<h3>' . $ent->name . '</h3>';
		$content .= print_r($dossier, true);
		if ($dossiers) {
			foreach ($dossiers as $guid => $ent) {
				$dossiersdepreuves .= '<p>' . elgg_view('object/dossierdepreuve', array('entity' => $ent)) . '</p>';
			}
		} else $dossiersdepreuves .= elgg_echo('dossierdepreuve:nodossier');
		$dossiersdepreuves .= '<h4><a href="' . $vars['url'] . 'blog/owner/' . $user->username . '">' . $user->countObjects('blog') . ' article(s) de blog</a></h4>';
		$dossiersdepreuves .= '<h4><a href="' . $vars['url'] . 'file/owner/' . $user->username . '">' . $user->countObjects('file') . ' image(s) et fichier(s)</a></h4>';
	} else if ($profile_type == 'tutor') {
		$group_tutors[] = $user;
		$group_tutors_guids[] = $user->guid;
	} else if ($profile_type == 'evaluator') {
		// A la fois tuteurs et évaluateurs
		$group_tutors[] = $user;
		$group_tutors_guids[] = $user->guid;
		$group_evaluators[] = $user;
		$group_evaluators_guids[] = $user->guid;
	} else if ($profile_type == 'organisation') {
		$group_organisations[] = $user;
		$group_organisations[] = $user->guid;
	} else if ($profile_type == 'other_administrative') {
		$group_other_administratives[] = $user;
		$group_other_administratives_guids[] = $user->guid;
	} else {
		$group_undefineds[] = $user;
		$group_undefineds_guids[] = $user->guid;
	}
}
$group_learners_count = count($group_learners_guids);
$group_tutors_count = count($group_tutors_guids);
$group_evaluators_count = count($group_evaluators_guids);
$group_organisations_count = count($group_organisations_guids);
$group_other_administratives_count = count($group_other_administratives_guids);
$group_undefineds_count = count($group_undefineds_guids);

$params = array(
    'type_subtype_pairs' => array('object' => 'dossierdepreuve'),
    'order_by' => 'time_updated DESC', 'count' => true,
    'owner_guids' => $group_learners_guids,
  );
$content .= "<h3>$group_members_count membres dans le groupe</h3><ul>";
$content .= "<li>$group_learners_count apprenants</li>";
$content .= "<li>$group_tutors_count formateurs</li>";
$content .= "<li>$group_evaluators_count évaluateurs</li>";
$content .= "<li>$group_organisations_count organisations</li>";
$content .= "<li>$group_other_administratives_count autres et administratifs</li>";
$content .= "<li>$group_undefineds_count sans profil particulier</li>";
$content .= "</ul>";


$content .= "<br /><h3>Les dossiers de preuve et leur suivi</h3>";
$content .= $dossiersdepreuves;
*/

// Tous les dossiers de preuve et de suivi des membres du groupe
/*
$dossiers_count = elgg_get_entities($params);
$params['count'] = false;
$params['limit'] = $dossiers_count;
$dossiers = elgg_get_entities($params);
$content .= "$dossiers_count dossiers de preuve<br />";
foreach ($dossiers as $dossier) {
  $content .= elgg_view('object/dossierdepreuve', array('entity' => $dossier));
}
*/



$learners = dossierdepreuve_get_group_learners($group);
// Les éléments du dossier
foreach ($learners as $user) {
	$dossiers = dossierdepreuve_get_user_dossier($user->guid, 'b2iadultes');
	$content .= '<h3>' . $user->name . '</h3>';
	if ($dossiers) {
		foreach ($dossiers as $guid => $ent) {
			$content .= '<p>' . elgg_view('object/dossierdepreuve', array('entity' => $ent)) . '</p>';
		}
	} else $content .= '<p>' . elgg_echo('dossierdepreuve:nodossier') . '</p>';
	$content .= '<hr />';
}


elgg_push_context('dossierdepreuve');


// Compose page
$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

$title = elgg_echo("dossierdepreuve:all");

echo elgg_view_page($title, $body);

