<?php
/**
 * List most recent dossierdepreuve on group profile page
 *
 * @package dossierdepreuve
 */

$group = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_entity();
$user_guid = $user->guid;
$profile_type = dossierdepreuve_get_user_profile_type($user);

// Outil non activé dans le groupe
if ($group->dossierdepreuve_enable != "yes") { return true; }

$content = '';
$all_link = elgg_view('output/url', array('href' => "dossierdepreuve/group/$group->guid", 'text' => elgg_echo('link:view:all'), 'is_trusted' => true) );
if ($profile_type == 'learner') {
	$dossier = dossierdepreuve_get_user_dossier($member->guid);
	if ($dossier) 	$new_link = elgg_view('output/url', array('href' => $dossier->getURL(), 'text' => elgg_echo('edit') . ' ' . substr($dossier->title, 0, 24), 'is_trusted' => true) );
	else $new_link = elgg_view('output/url', array('href' => "dossierdepreuve/add/" . $user_guid, 'text' => elgg_echo('dossierdepreuve:add'), 'is_trusted' => true) );
} else {
	$new_link = elgg_view('output/url', array('href' => "dossierdepreuve/group/$group->guid", 'text' => "Voir tous les dossiers de preuve", 'is_trusted' => true) );
}

elgg_push_context('widgets');


elgg_set_context('search');
$ia = elgg_set_ignore_access(true);

// Liste des formateurs
$tutors = dossierdepreuve_get_group_tutors($group);
// Seuls certains membres peuvent créer des formateurs : habilitateurs/organisation responsables du groupe ou admin
if ($group->canEdit() || elgg_is_admin_logged_in()) {
	if (in_array($profile_type, array('evaluator', 'organisation'))) {
		$content .= '<a href=""' . $vars['url'] . 'dossierdepreuve/inscription?profiletype=evaluator" class="elgg-button elgg-button-action" title="Créer des comptes formateurs" style="float:right; margin-right:2px;">Créer</a>';
	} 
}
$content .= '<h4>Liste des Formateurs (' . sizeof($tutors) . ')</h4>';
$content .= elgg_view_entity_list($tutors, array('full_view' => false, 'limit' => sizeof($tutors), 'size' => 'tiny', 'list_type' => 'gallery'));
$content .= '<div class="clearfloat"></div><br />';


// Liste des candidats et de leur dossier de suivi
$learners = dossierdepreuve_get_group_learners($group);
// Seuls certains membres peuvent créer des candidats : responsables du groupe ou admin
if (($group->canEdit() && in_array($profile_type, array('tutor', 'evaluator', 'organisation'))) || elgg_is_admin_logged_in()) {
	$content .= '<a href=""' . $vars['url'] . 'dossierdepreuve/inscription?profiletype=learner" class="elgg-button elgg-button-action" title="Créer des comptes candidats" style="float:right; margin-right:2px;">Créer</a>';
}
$content .= '<h4>Liste des candidats (' . sizeof($learners) . ')</h4>';
//$content .= elgg_view_entity_list($learners, array('full_view' => false, 'limit' => sizeof($learners), 'size' => 'tiny', 'list_type' => 'gallery'));
foreach ($learners as $member) {
	if ($user_guid == $member->guid) $content .= '<div style="background:#DDFFDD; font-weight:bold; border-top:1px dotted #ccc; margin-top:2px; padding:2px 0 0 0;">';
	else $content .= '<div style="border-top:1px dotted #ccc; margin-top:2px; padding:2px 0 0 0;">';
	$content .= '<img src="' . $member->getIconUrl('tiny') . '" style="float:left; margin:0 2px 2px 0;" />' . $member->name;
	$dossier = dossierdepreuve_get_user_dossier($member->guid);
	if ($dossier) {
		$picto = elgg_view('dossierdepreuve/picto', array('entity' => $dossier));
		$content .= '<span style="float:right; margin:0 0 2px 4px;">' . $picto . '</span>';
		$content .= ' <a href="' . $dossier->getURL() . '">' . $dossier->title . '</a>';
	} else {
		if (dossierdepreuve_can_create_for_user($member->guid)) {
			$content .= '<a href="' . $vars['url'] . 'dossierdepreuve/new?owner_guid=' . $member->guid . '" title="Créer son Dossier de preuve" style="font-size:small; float:right; font-weight:bold;">Créer son dossier</a>';
		} else { $content .= '<span style="float:right; margin:0 0 2px 4px;">(pas de dossier)</span>'; }
	}
	$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
}
/*
$content .= '<ul>';
foreach ($learners as $ent) {
	$content .= '<li><a href="' . $ent->getURL() . '">' . $ent->name . '</a></li>';
}
$content .= '</ul><br />';
*/
$content .= '<div class="clearfloat"></div><br />';


// Liste des dossiers de suivi
/*
$dossiers = dossierdepreuve_get_group_dossiers($group);
$content .= '<h4>Liste des dossiers</h4><ul>';
foreach ($dossiers as $ent) {
	$picto = elgg_view('dossierdepreuve/picto', array('entity' => $ent));
	$picto = '<span style="float:right; margin:0 0 2px 4px;">' . $picto . '</span>';
	$content .= '<li>' . $picto . $ent->getOwnerEntity()->name . '&nbsp;: <a href="' . $ent->getURL() . '">' . $ent->title . '</a></li>';
}
$content .= '</ul><br />';
*/

elgg_set_ignore_access($ia);

elgg_pop_context();

if (!$content) { $content = '<p>' . elgg_echo('dossierdepreuve:none') . '</p>'; }


// Render group module
echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('dossierdepreuve:group'),
	'content' => '<div style="padding:0 2px;">' . $content . '</div>',
	'all_link' => $all_link,
	'add_link' => $new_link,
));

