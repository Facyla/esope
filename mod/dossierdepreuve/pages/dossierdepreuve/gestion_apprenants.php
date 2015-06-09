<?php
/**
 * Elgg dossierdepreuve browser
 * 
 * @package Elggdossierdepreuve
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009 - 2009
 * @link http://elgg.com/
 */

gatekeeper();
// @TODO : qui peut éditer ?

// Give access to all users, data, etc.
$ignore_access = elgg_get_ignore_access();
elgg_set_ignore_access(true);

global $CONFIG;
$content = '';

// Set the current page's owner to the site
elgg_set_page_owner_guid(0);
elgg_set_context('dossierdepreuve');

// defaults to logged in user anyway..
$user = elgg_get_logged_in_user_entity();
$editor_profile_type = dossierdepreuve_get_user_profile_type($user);
if (elgg_is_admin_logged_in()) { $editor_profile_type = 'admin'; }

// Compose the page
$content .= '<script type="text/javascript">' . elgg_view('dossierdepreuve/js') . '</script>';

// Ajax loader : Please wait while updating animation
$content .= '<div id="loading_overlay" style="display:none;"><div id="loading_fader">' . elgg_echo('dossierdepreuve:ajax:loading') . '</div></div>';

$content .= '<style>
tr { border-top:1px solid #333; }
tr:last-child { border-bottom:2px solid #333; }
th, td { padding:1px 1% 1px 1px; border-left:1px solid #999; }
th:last-child, td:last-child { border-right:1px solid #999; }
th { text-align:center; border-top:1px solid #333; }
td {  }
</style>';
$content .= '<p>' . elgg_echo('dossierdepreuve:gestion:help') . '</p>';


// Infos diverses et mode d'emploi
$info_doc .= elgg_echo('dossierdepreuve:gestion:details') . '<br /><br />';

switch ($editor_profile_type) {
	case 'admin':
		// Tous le monde
		$view_all = true;
		break;
	case 'tutor':
	case 'evaluator':
	case 'organisation':
	case 'other_administrative':
		// Tous les candidats + soi
		$view_learners = true;
		break;
	case 'learner':
	default:
		// Seulement soi-même
}

// Liste des membres : tous ou soi-même...
if ($view_all || $view_learners) {
	$all_members_count = elgg_get_entities(array('types' => 'user', 'count' => true));
	$all_members = elgg_get_entities(array('types' => 'user', 'limit' => $all_members_count));
} else {
	$all_members_count = 1;
	$all_members[] = $user;
}

// Liste des types de profils : on en a besoin pour tous les types de profil connectés
$profile_types_options = array(
		"type" => "object",
		"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
		"limit" => false,
		"owner_guid" => elgg_get_site_entity()->getGUID(),
	);
if ($custom_profile_types = elgg_get_entities($profile_types_options)) {
	$profile_types_options = array();
	$profile_types[''] = elgg_echo("profile_manager:profile:edit:custom_profile_type:default");
	foreach($custom_profile_types as $type) {
		$profile_types[$type->guid] = $type->getTitle();
		$profile_type_names[$type->guid] = $type->metadata_name;
	}
}

// Tous les groupes
$all_groups_count = elgg_get_entities(array('types' => 'group', 'count' => true));
$all_groups = elgg_get_entities(array('types' => 'group', 'count' => false, 'limit' => $all_groups_count));
// Liste du sélecteur des groupes B2i
$b2i_groups = array('' => elgg_echo('dossierdepreuve:learner_group:none'));
foreach ($all_groups as $ent) {
	//$b2i_groups[$ent->guid] = $ent->name . ' (groupe ' . $ent->grouptype . ')';
	$b2i_groups[$ent->guid] = $ent->name;
}


// Tableau : seulement si on a une liste
//if ($all_members_count > 1) {
if ($view_all || $view_learners) {
	$content .= '<table class="dossierdepreuve" style="width:100%;">';
	$content .= '<tr>';
	$content .= '<th scope="col" style="width:20%;">Nom de la personne</th>';
	if ($editor_profile_type == 'admin') {
		$content .= '<th scope="col" style="width:8%;">GUID</th>';
		$content .= '<th scope="col" style="width:20%;">email</th>';
		$content .= '<th scope="col" style="width:12%;">username</th>';
		$content .= '<th scope="col" style="width:15%;">Type de profil</th>';
	}
	$content .= '<th scope="col" style="width:15%;">Groupe de formation</th>';
	$content .= '</tr>';
}

// Listing général...
foreach ($all_members as $ent) {
	$content_line = '';
	//$profile_type = dossierdepreuve_get_user_profile_type($ent);
	$profile_type = $profile_type_names[$ent->custom_profile_type]; // Nettement plus rapide...
	
	// Modification du type de profil : ssi admin
	if ($editor_profile_type == 'admin') {
		$edit_profile_type = elgg_view('input/dropdown', array('value' => $ent->custom_profile_type, 'options_values' => $profile_types, 'js' => 'style="max-width:24ex;" onChange="dossierdepreuve_update_members('.$ent->guid.', \'custom_profile_type\', this.value);"'));
	}
	
	// Groupe de formation actuel - ssi le profil est celui d'un candidat
	if (($profile_type == 'learner') && !empty($ent->learner_group_b2i) && ($learner_group_b2i = get_entity($ent->learner_group_b2i))) {} else { $learner_group_b2i = false; }
	
	// Qui peut modifier le groupe ?
	// L'apprenant soi-même..
	if (($editor_profile_type == 'learner') && ($ent->guid == elgg_get_logged_in_user_guid())) {
		// ..mais uniquement si le groupe n'est pas encore choisi
		if (empty($ent->learner_group_b2i)) {
			$edit_group = elgg_view('input/dropdown', array('value' => $ent->learner_group_b2i, 'options_values' => $b2i_groups, 'js' => 'style="max-width:24ex;" onChange="dossierdepreuve_update_members('.$ent->guid.', \'learner_group_b2i\', this.value);"', 'id' => "own_group_select"));
		} else {
			$edit_group = "<p>Groupe de formation déjà choisi. Pour en changer, veuillez demander à votre formateur (ou à un administrateur du site) de le faire pour vous.</p>";
			// Si choisi mais pas membre, on le précise
			if ($learner_group_b2i || !$learner_group_b2i->isMember($ent)) { $edit_group .= "<p><strong>Attention, vous devez confirmer votre groupe de formation&nbsp;: {$learner_group_b2i->name}.<br />Pour pouvoir commencer à y travailler, veuillez demander à le rejoindre à partir de la <a href=\"" . $learner_group_b2i->getURL() . "\">page d'accueil du groupe</a>.</strong></p>"; }
			else { $edit_group .= '<p>Vous êtes bien membre de votre groupe de formation&nbsp;: ' . $learner_group_b2i->name . '</p>'; }
		}
	
	// Les autres peuvent modifier pour plus de profils de candidats - on filtre après (avant affichage)
	//} else if (in_array($editor_profile_type, array('tutor', 'evaluator', 'organisation', 'other_administrative', 'admin'))) {
	} else if ($view_all || $view_learners) {
		if ($profile_type == 'learner') $edit_group = elgg_view('input/dropdown', array('value' => $ent->learner_group_b2i, 'options_values' => $b2i_groups, 'js' => 'style="max-width:24ex;" onChange="dossierdepreuve_update_members('.$ent->guid.', \'learner_group_b2i\', this.value);"'));
		else $edit_group = $learner_group_b2i->name;
		if ($learner_group_b2i) {
			if ($learner_group_b2i->isMember($ent)) {
				//$edit_group .= ' membre OK';
			} else {
				$edit_group .= ' <strong title="Cette personne n\'est pas membre de son groupe de formation. Veuillez l\'inviter ou lui demander de rejoindre le groupe.">Non membre</strong>';
			}
		}
	
	// Le candidat ne peut modifier que lui-même..
	} else {
		$edit_group = get_entity($ent->learner_group_b2i)->name;
	}
	
	// Composition de la ligne de tableau
	if ($view_all || $view_learners) {
		if ($ent->isBanned()) { $content_line .= '<tr style="text-decoration: line-through;">'; } 
		else { $content_line .= '<tr>'; }
		$content_line .= '<td scope="row">' . $ent->name . $edit_name . '</td>';
		if ($editor_profile_type == 'admin') {
			$content_line .= '<td>' . $ent->guid . '</td>';
			$content_line .= '<td>' . $ent->username . '</td>';
			$content_line .= '<td>' . $ent->email . '</td>';
			$content_line .= '<td>' . $edit_profile_type . '</td>';
		}
		$content_line .= '<td>' . $edit_group . '</td>';
		$content_line .= '</tr>';
	} else {
		// On peut toujours modifier le groupe de rattachement (le sélecteur dépend de ses propres droits)
		$content_line .= $edit_group;
	}
	
	// Ajout aux divers blocs selon qu'il s'agit d'un candidat ou d'un autre type de profil
	switch ($profile_type) {
		case 'learner':
			$content_learners .= $content_line;
			break;
		case 'tutor':
			$content_tutors .= $content_line;
			break;
		case 'evaluator':
			$content_evaluators .= $content_line;
			break;
		case 'organisation':
			$content_organisations .= $content_line;
			break;
		case 'other_administrative':
			$content_other_administratives .= $content_line;
			break;
		default:
			$content_others .= $content_line;
	}
	
}

// Tableau de synthèse par profil - ou seulement soi
//if ($editor_profile_type != 'learner') {
if ($view_all || $view_learners) {
	$content .= '<tr><th colspan="6" scope="colgroup">Profils de type&nbsp;: ' . elgg_echo('dossierdepreuve:profile_type:learner') . '</th></tr>';
	$content .= $content_learners;
	$content .= '<tr><th colspan="6" scope="colgroup">Profils de type&nbsp;: ' . elgg_echo('dossierdepreuve:profile_type:tutor') . '</th></tr>';
	$content .= $content_tutors;
	$content .= '<tr><th colspan="6" scope="colgroup">Profils de type&nbsp;: ' . elgg_echo('dossierdepreuve:profile_type:evaluator') . '</th></tr>';
	$content .= $content_evaluators;
	// Pour les admins seulement..
	if ($view_all) {
		$content .= '<tr><th colspan="6" scope="colgroup">Profils de type&nbsp;: ' . elgg_echo('dossierdepreuve:profile_type:organisation') . '</th></tr>';
		$content .= $content_organisations;
		$content .= '<tr><th colspan="6" scope="colgroup">Profils de type&nbsp;: ' . elgg_echo('dossierdepreuve:profile_type:other_administrative') . '</th></tr>';
		$content .= $content_other_administratives;
		$content .= '<tr><th colspan="6" scope="colgroup">Profils de type&nbsp;: ' . elgg_echo('dossierdepreuve:profile_type:') . '</th></tr>';
		$content .= $content_others;
	}
	$content .= '</tr></table>';
} else {
	$content .= 'Bonjour ' . $user->name . '<br /><br />';
	$content .= '<label for="own_group_select">Veuillez choisir votre groupe de formation&nbsp;: </label>';
	$content .= $content_learners . '<br /><br />';
	$content .= '<em>Votre nom est incomplet, mal écrit ?  Vous pouvez le modifier via le menu en haut de page, ou en cliqueant sur ce lien&nbsp;: <a href="' . $CONFIG->url . 'settings/user/' . $user->username . '">' . elgg_echo('theme_compnum:usersettings') . '</a></em><br /><br />';
}


elgg_set_context('dossierdepreuve');
elgg_push_context('gestion_apprenants');

elgg_set_ignore_access($ignore_access);


// Composition de la page
$nav = elgg_view('dossierdepreuve/nav', array('selected' => 'gestion_apprenants', 'title' => $title));
$body = elgg_view_layout('one_column', array('content' => $nav . $content, 'sidebar' => $area1));

$title = elgg_echo("dossierdepreuve:gestion");

echo elgg_view_page($title, $body); // Finally draw the page

