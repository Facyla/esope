<?php
/**
 * Elgg dossierdepreuve browser edit
 * 
 * @package Elggdossierdepreuve
 * @author Facyla - Florian DANIEL
 * @copyright Items International 2013
 * @link http://items.fr/
 */

global $CONFIG;

/* Fonctionnement du test d'auto-positionnement :
 * Ce test peut être passé publiquement (sans compte) 
 * ou en tant que membre pour s'auto-évaluer, et mettre à jour l'avancement de son auto-évaluation dans son dossier de preuve.
 * Il n'utilise PAS les données d'un dossier de preuve existant, 
 * mais permet de l'initialiser, et *éventuellement* de le mettre à jour.
 * Le choix de mettre à jour le "vrai" dossier arrive après obtention des résultats (et comparaison éventuelle avec l'évaluation actuelle).
 */

if (elgg_is_logged_in()) {
	elgg_set_page_owner_guid($_SESSION['guid']);
	/*
	// Selon les types de profil
	if (elgg_is_admin_logged_in()) {
		$profile_type = 'admin';
	} else {
		$profile_type = dossierdepreuve_get_rights('edit', elgg_get_logged_in_user_entity());
	}
	*/
} else {
	$public_mode = true;
	elgg_set_page_owner_guid($CONFIG->site->guid);
}
$page_owner = elgg_get_page_owner_entity(); // Get the page owner : logged in user, or site
$content = '';


// Initialisation data : vars
$pagetitle = elgg_echo("dossierdepreuve:auto:new");
$action = "dossierdepreuve/autopositionnement_new";
$owner_guid = $page_owner->guid;
$container_guid = $owner_guid;
$typedossier = 'b2iadultes';

// Other useful vars
$activecolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
$defaultcolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');
$inactivecolor = '#CCC';


// Liste des valeurs des sélecteurs
// Type de questionnaire
$auto_type_opt = array(
	elgg_echo('dossierdepreuve:auto_type:full') => 'full', 
	//elgg_echo('dossierdepreuve:auto_type:random') => 'random', 
	//elgg_echo('dossierdepreuve:auto_type:limited') => 'limited', 
	elgg_echo('dossierdepreuve:auto_type:googleform') => 'googleform', 
	elgg_echo('dossierdepreuve:auto_type:restore_history') => 'restore_history', 
	);
// Valeurs pour l'autopositionnement
$autopositionnement_opt = array(
		'' => elgg_echo ('dossierdepreuve:autopositionnement:'),
		'100' => elgg_echo ('dossierdepreuve:autopositionnement:100'),
		'50' => elgg_echo ('dossierdepreuve:autopositionnement:50'),
		'0' => elgg_echo ('dossierdepreuve:autopositionnement:0'),
	);
$update_dossier_opt = array(
		'yes' => elgg_echo ('dossierdepreuve:update_dossier:yes'),
		'no' => elgg_echo ('dossierdepreuve:update_dossier:no'),
	);
$send_email_opt = array(
		'yes' => elgg_echo ('dossierdepreuve:send_email:yes'),
		'no' => elgg_echo ('dossierdepreuve:send_email:no'),
	);
/*
// Type de dossier
$typedossier_values = array(
	  "" => elgg_echo ('dossierdepreuve:choose'),
		'b2iadultes' => "B2i Adultes",
	);
*/
// Récupération du référentiel
$type_referentiel = elgg_get_plugin_setting('referentiels', 'dossierdepreuve');
$referentiel_setting = elgg_get_plugin_setting('referentiel_' . $type_referentiel, 'dossierdepreuve');
// Seuils pour les indicateurs
$threshold_low = elgg_get_plugin_setting('threshold_low', 'dossierdepreuve');
$threshold_high = elgg_get_plugin_setting('threshold_high', 'dossierdepreuve');
$threshold_validation = elgg_get_plugin_setting('threshold_validation', 'dossierdepreuve');
// Calcul du référentiel sous forme d'array, et du sélecteur de domaines au passage
$referentiel = array(); $selection_opt = array(); $total_competences = 0;
$referentiel_domaines = explode(';', $referentiel_setting);
foreach ($referentiel_domaines as $k => $domaine_competences) {
	$domaine = $k + 1;
	$referentiel_competences = explode(',', $domaine_competences);
	// Pour plus de clarté pour les recherches, on s'arrange pour les index correspondent au référentiel
	foreach ($referentiel_competences as $competence) {
		$referentiel[$domaine][$competence] = $competence;
		$total_competences++; // Comptages
	}
	// Choix des domaines (@TODO : et/ou compétences du questionnaire ?)
	$selection_label = elgg_echo('dossierdepreuve:referentiel:' . $domaine);
	$selection_opt[$selection_label] = $domaine;
}
// echo print_r($referentiel, true); // debug

// Pour la récupération des réponses, on a besoin de lister les questions (au moins leur nombre) avant...
// Parcours du référentiel
/*
foreach ($referentiel as $domaine => $competences) {
	// Correction décalage de 1 pour les domaines)
	$domaine_basename = 'dossierdepreuve:referentiel:' . $domaine;
	foreach ($competences as $competence) {
		$competence_basename = $domaine_basename . ':' . $competence;
		$basename = $type_referentiel . ':' . $domaine . ':' . $competence . ':';
		$property_basename = str_replace(':', '_', $basename);
		// Récupération des questions de positionnement pour chaque compétence ("Je sais...")
		//$elements = elgg_get_plugin_setting($basename . 'elements', 'dossierdepreuve');
		$savoirs = elgg_get_plugin_setting($property_basename . 'savoirs', 'dossierdepreuve');
		//$criteres = elgg_get_plugin_setting($basename . 'criteres', 'dossierdepreuve');
		//$visualhelp = elgg_get_plugin_setting($property_basename . 'visualhelp', 'dossierdepreuve');
		
		// Découpage des données en questions : une question par ligne (multiligne avec des <br />)
		// Important : must explode on "\n", and not '\n' !  It won't work otherwise
		$questions_competence = explode("\n", $savoirs);
		//$visualhelp_competence = explode("\n", $visualhelp);
		
		$i = 1;
		foreach ($questions_competence as $q) {
			// Positionnement = Réponse
			$i++;
		}
	}
}
*/

// Scripts pour les blocs pliant an accordéon
?>
<script type="text/javascript">
$(function() {
	$('#questionnaire-report-accordion').accordion({ header:'h4', autoHeight:false, collapsible:true, active:false });
	$('#questionnaire-restore-data').accordion({ header:'h3', autoHeight:false, collapsible:true, active:false });
});
</script>
<style>
.ui-widget { font-size:1em; }
.ui-state-active .ui-icon, .ui-state-default .ui-icon { float: left; margin-right: 10px; }
</style>

<div class="contentWrapper">
	
	<?php
	// COLLECTE DES DONNEES SAISIES
	// Etape du questionnaire : start => (facultatif) selection => quest => endquest
	$step = get_input('step', 'start');
	//echo "STEP = $step<br />";
	// Réinitialisation des données en session
	if ($step == 'clearall') {
		// Réinitialise toutes les données saisies et permet de commencer un nouveau questionnaire
		//if (elgg_is_logged_in()) $_SESSION['user']->history_data = null; else 
		$_SESSION['dossierdepreuve']->history_data = null;
		set_input('history_data', null);
		$step = 'start'; // Set next step = go to start
	}
	// Restauration d'un positionnement à partir de données sauvegardées (code)
	if ($step == 'session_restore') {
		$restore_history = get_input('restore_history', false);
		$history_data = unserialize($restore_history);
		//if (elgg_is_logged_in()) $_SESSION['user']->history_data = $history_data; else 
		$_SESSION['dossierdepreuve']->history_data = $history_data;
		// Restore all saved data vars
		$step = $history_data['step'];
		$auto_type = $history_data['auto_type'];
		$selection = $history_data['selection'];
		$email = $history_data['email'];
		$send_email = $history_data['send_email'];
		$update_dossier = $history_data['update_dossier'];
		$current_domaine = $history_data['domaine'];
		$current_competence = $history_data['competence'];
		$question = $history_data['question'];
		$answer = $history_data['answer'];
		$current = $history_data['current'];
		$history = $history_data['history'];
	}
	// Type de questionnaire
	$auto_type = get_input('auto_type', '');
	// Sélection limitée de questions (par domaine), seulement si "limited" pour $auto_type
	$selection = get_input('selection', '');
	// EMail pour envoi des données
	//if (elgg_is_logged_in()) $email = get_input('contact_email', $_SESSION['user']->email); else 
	$email = get_input('contact_email', $_SESSION['dossierdepreuve']->history_data['email']);
	$send_email = get_input('send_email', 'yes');
	// MAJ du dossier de suivi ?
	if (elgg_is_logged_in()) $update_dossier = get_input('update_dossier', 'yes');
	// Domaine actuel : initialisé à 0 par défaut (on ajoute 1 par la suite)
	$current_domaine = get_input('domaine', 0);
	// Compétence actuelle : initialisée à 1 par défaut
	//$current_competence = get_input('competence', 0); // Non utilisé
	// Questions posées (précédentes donc) - utile seulement lorsqu'on pose une sélection de questions (limited)
	//$question = get_input('question', ''); // Non utilisé
	// Réponse donnée : array[domaine][competence][num_question] = réponse
	$answer = get_input('answer', '');
	
	
	// RECUPERATION DES DONNÉES STOCKEES EN SESSION
	//if (elgg_is_logged_in()) $history_data = $_SESSION['user']->history_data; else 
	$history_data = $_SESSION['dossierdepreuve']->history_data;
	//echo "DONNEES DE SESSION : " . print_r($history_data, true) . '<hr />'; // debug
	// Historique des Q/R
	$history = $history_data['history'];
	// On ne conserve les nouvelles données Q/R que si elles sont valides = existent dans le référentiel
	if (!empty($current_domaine) && isset($referentiel[$current_domaine])) {
		// Ajout de la dernière série de Q/R - sous la forme ('num_domaine' => answer_array)
		$history[$current_domaine] = $answer[$current_domaine];
		//echo "Données 'history' : " . print_r($history, true) . '<hr />'; // debug
	}
	
	//if (elgg_is_admin_logged_in()) 
	//echo "<hr />auto_type=$auto_type / step=$step / selection=$selection / email=$email / domaine=$current_domaine / compétence=$current_competence / question=$question / answer=$answer/ update_dossier=$update_dossier<hr />"; // debug
	
	
	// CALCULS DIVERS À PARTIR DES VARIABLES
	// Etape suivante, selon la sélection initiale
	if (!in_array($step, array('endofquest', 'final', 'session_restore', 'restore_history'))) {
		if ($auto_type == 'full') { $step = 'quest'; }
		if ($auto_type == 'limited') { $step = 'selection'; }
		if ($auto_type == 'googleform') { $step = 'googleform'; }
		if ($auto_type == 'restore_history') { $step = 'restore_history'; }
	}
	
	//if (elgg_is_admin_logged_in()) 
	//echo "<hr />auto_type=$auto_type / step=$step / selection=$selection / email=$email / domaine=$current_domaine / compétence=$current_competence / question=$question / answer=$answer/ update_dossier=$update_dossier<hr />"; // debug
	
	
	// Avance dans le questionnaire et rapport : ssi le questionnaire est en cours, ou terminé
	if (in_array($step, array('quest', 'final', 'endofquest'))) {
		
		// Ssi le questionnaire en cours : on détermine ce qu'on fait maintenant (étape suivante ou fin)
		if ($step == 'quest') {
			// Domaine actuel => on avance de 1
			$current_domaine++;
			// On réinitialise la compétence (attention, si on avance compétence par compétence il faut commenter cette ligne)
			$current_competence = 1;
			/* Note : dans le cas où on avance compétence par compétence, il faut :
			 *  - 1: décrémenter le domaine (annuler l'incrément initial) et incrémenter la compétence
			 *  - 2: vérifier si la compétence existe, et si non incrémenter le domaine et réinitialiser la compétence à 1
			 */
			/*
			// 1. Compétence actuelle => on annule l'incrément du domaine et on avance de 1
			$current_domaine--; $current_competence++;
			// 2. Si cette compétence n'existe pas => domaine suivant et RAZ compétence
			if (!isset($referentiel[$current_domaine][$new_competence])) { $current_domaine++; $current_competence = 1; }
			*/
			// Si le nouveau domaine n'existe pas => on va à la fin du questionnaire
			if (!isset($referentiel[$current_domaine][$current_competence])) {
				if ($step != 'final') $step = 'endofquest';
				// Et du coup on n'a plus de besoin de domaine ni de compétence
				$current_domaine = ''; $current_competence = '';
			}
		}
		
		// Rapport sur le positionnement par domaine
		// + quelques stats/indicateurs
		$questionnaire_report = '';
		$total_q = 0;
		$answered_q = 0;
		$score_total = 0;
		$validated_total = 0;
		
		// Pour chacun des domaines
		foreach ($history as $j => $domaine) {
			$domaine_report = '';
			$total_q_domaine = 0;
			$answered_q_domaine = 0;
			$score_domaine = 0;
			$validated_domaine = 0;
			$validated_per_domaine = 0;
			$count_q_domaine = count($domaine);
			
			// Pour chacune des compétences
			foreach ($domaine as $k => $competence) {
				$domaine_report .= "<p>" . elgg_echo('dossierdepreuve:referentiel:' . $j . ':' . $k) . '&nbsp;:<br />';
				$score_competence = 0;
				$validated_competence = 0;
				
				// Pour chacune des questions définies/sélectionnées
				foreach ($competence as $i => $q) {
					$total_q_domaine++; // Nb de questions total
					if (strlen($q) > 0) {
						$answered_q_domaine++;
						$domaine_report .= " - Question n°$i&nbsp;: $q%<br />";
						$score_competence += $q;
					} else {
						// Note : pas de positionnement = note de 0 (on ne compte les non-réponses que pour info)
						$domaine_report .= " - Question n°$i&nbsp;: (pas de positionnement)<br />";
					}
				}
				
				// $i étant positionné au dernier numéro de question, on peut faire simple : total/$i = moyenne du score sur la compétence
				$score_competence = round($score_competence/$i);
				$domaine_report .= "Positionnement sur cette compétence : " . $score_competence . ' ';
				$score_domaine += $score_competence;
				// Validation de la compétence : >= 50%
				if ($score_competence >= $threshold_validation) { $validated_competence += 1; }
				// Evaluation sur cette compétence
				if ($score_competence < $threshold_low) {
					$domaine_report .= '<span style="color:darkred;">Non acquis</span>';
				} else  if ($score_competence >= $threshold_high) {
					$domaine_report .= '<span style="font-weight:bold; color:darkgreen;">Acquis</span>';
				} else {
					$domaine_report .= '<span style="color:darkorange;">En cours d\'acquisition</span>';
				}
				$domaine_report .= '</p>';
				$validated_per_domaine += $validated_competence;
			}
			
			// Synthèse par domaine
			// Calcul sur le domaine avec le score par compétence (sinon on sur-représente les compétences avec bcp de questions), 
			// soit moyenne du score sur le domaine = total/nb_competence (arrondi)
			$score_domaine = round($score_domaine/$count_q_domaine);
			// Validation du domaine : "La délivrance du brevet suppose qu’environ 70 % des compétences de chacun des domaines du référentiel soient validées (soit 2 compétences sur 3 ou 3 compétences sur 4 compétences par domaine)"
			// Soit d'un point de vue programmation : competences_validees >= (nb_questions - 1) / nb_questions
			// Seuil = (total_compétences - 1) doivent être validées
			if ($validated_per_domaine >= ($count_q_domaine - 1)) { $validated_domaine = 1; }
			$domaine_report .= '<p>';
			$domaine_report .= "Vous avez répondu à $answered_q_domaine sur les $total_q_domaine questions pour ce domaine (" . round(100*$answered_q_domaine/$total_q_domaine) . "%), soit un score moyen de $score_domaine%.<br />";
			$domaine_report .= "<strong>Vous pouvez valider $validated_per_domaine des $count_q_domaine compétence(s) de ce domaine.</strong>";
			/*
			if ($validated_per_domaine > 1) $domaine_report .= "Vous pouvez potentiellement valider $validated_per_domaine compétence(s) de ce domaine.<br />";
			else if ($validated_per_domaine == 1) $domaine_report .= "Vous pouvez potentiellement valider $validated_per_domaine compétence de ce domaine.<br />";
			else $domaine_report .= "Vous ne semblez pas pouvoir valider actuellement de compétence de ce domaine.<br />";
			*/
			$domaine_report .= '</p>';
			$score_total += $score_domaine;
			$total_q += $total_q_domaine;
			$answered_q += $answered_q_domaine;
			$validated_total += $validated_domaine;
			// Titre réponses domaine
			$questionnaire_report .= "<h4>Positionnement pour le domaine $j&nbsp;: ";
			$questionnaire_report .= "$validated_per_domaine/$count_q_domaine ";
			//if ($validated_domaine > 0) $questionnaire_report .= '<span style="font-weight:bold; color:darkgreen;">validé</span>';
			//else $questionnaire_report .= '<span style="color:darkred;">non validé</span>';
			if ($score_domaine < $threshold_low) {
				$questionnaire_report .= '<span style="color:darkred;">Non acquis</span>';
			} else if ($score_domaine >= $threshold_high) {
				$questionnaire_report .= '<span style="font-weight:bold; color:darkgreen;">Acquis</span>';
			} else {
				$questionnaire_report .= '<span style="color:darkorange;">En cours d\'acquisition</span>';
			}
			$questionnaire_report .= "</h4>";
			$questionnaire_report .= "<div>" . $domaine_report . "</div>";
		}
		
		// Synthèse globale sur le référentiel
		$questionnaire_report .= '<br />';
		$questionnaire_report .= "<p>
			Vous avez répondu à $answered_q des $total_q questions de ce test d'autopositionnement (" . round(100*$answered_q/$total_q) . "%).<br />
			Votre positionnement moyen sur " . count($history) . " domaines est de " . round($score_total/count($history)) . "%<br />
			<strong>D'après ce test, vous pouvez actuellement valider $validated_total des $total_domaines domaines du référentiel.</strong><br />
			</p>";
		$questionnaire_report .= '<br />';
		
	}
	
	
	// STATISTIQUES
	// Nombre total de domaines
	$total_domaines = count($referentiel);
	// Nombre d'étapes = domaines + 1 de fin
	$total_steps = $total_domaines + 1;
	// Nombre de domaines sélectionnés (limited seulement)
	if (!empty($limited)) { $total_domaines_selection = count($selection); }
	// Nombre total de compétences
	//$total_competences = count($referentiel);
	// Nombre total de compétences pour le domaine actuel
	$total_competences_perdomaine = count($referentiel[$current_domaine]);
	// Nombre total de questions
	//$total_questions = count($referentiel);
	// Nombre total de questions pour le domaine actuel
	//$total_questions_percompetence = count($referentiel[$current_domaine][$current_competence]);
	// Nombre total de questions pour la compétence actuelle
	//$total_questions_percompetence = count($referentiel[$current_domaine][$current_competence]);
	
	
	// Restauration de données "sauvegardées"
	/*
	if ($step == 'restore_history') {
		$restore_history = get_input('restore_history', false);
		if (elgg_is_logged_in()) $_SESSION['user']->history_data = $restore_history;
		else $_SESSION['dossierdepreuve']->history_data = $restore_history;
		$step = 'session_restore';
	}
	*/
	
	// Mise à jour des données de session avec toutes les infos de l'état actuel
	$history_data = array(
			'step' => $step,
			'auto_type' => $auto_type,
			'selection' => $selection,
			'email' => $email,
			'send_email' => $send_email,
			'update_dossier' => $update_dossier,
			'domaine' => $current_domaine,
			'competence' => $current_competence,
			'question' => $question, // Ne sert que pour les questions aléatoires
			'answer' => $answer, // Doublé ici pour accès simplifié
			'current' => $current,
			'history' => $history,
		);
	
	//echo "<hr />" . print_r($history, true) . "<hr />"; // debug
	// SAUVEGARDE DES DONNÉES dans l'état actuel
	//if (elgg_is_logged_in()) $_SESSION['user']->history_data = $history_data; else 
	$_SESSION['dossierdepreuve']->history_data = $history_data;
	//echo "TEST : " . print_r($history_data, true); // debug
	
	// Traitement des données précédentes : réponse ou indications, et stockage des données en session pour plus tard
	// Préparation question suivante
	
	// Le formulaire proprement dit
	//echo '<form action="' . $vars['url'] . 'action/' . $action . '" enctype="multipart/form-data" method="post">';
	echo '<form action="" enctype="multipart/form-data" method="post">';
	echo elgg_view('input/securitytoken');
	echo '<h3>' . elgg_echo('dossierdepreuve:auto:title') . '</h3>';
	$questionnaire_info = '';
	$questionnaire_step = '';
	$questionnaire = '';
	$questionnaire_help = '';
	
	
	// Infos toujours affichées (si disponibles)
	if (!empty($auto_type) && ($step != 'googleform')) {
		$questionnaire_info .= "Ce référentiel comporte $total_competences compétences réparties en $total_domaines domaines.<br />";
		$questionnaire_info .= 'Vous avez choisi le questionnaire &laquo;&nbsp;' . elgg_echo('dossierdepreuve:auto_type:'.$auto_type) . '&nbsp;&raquo;.<br />'; // ', qui comporte $total_questions questions.<br />';
		if (!empty($limited)) $questionnaire_info .= "Ce questionnaire porte sur $total_domaines_selection domaines&nbsp;: " . implode(', ', $selection) . ".<br />";
		// Barre d'avancement dans les étapes du test
		if (in_array($step, array('quest', 'endofquest'))) {
			$current_step = $current_domaine;
			if ($step == 'endofquest') $current_step = $total_steps;
			$questionnaire_info .= "Vous en êtes à l'étape $current_step sur $total_steps du questionnaire";
			//$questionnaire_info .= ", soit le domaine n°$current_domaine, ";
			//$questionnaire_info .= "qui comporte $total_competences_perdomaine compétences<br />";
			//$questionnaire_info .= " et $total_questions_perdomaine questions";
			// Etapes : avancement graphique
			//$questionnaire_step .= "Etape $current_step sur $total_steps<br />";
			$questionnaire_step .= '<div style="width:100%; margin:2px auto 0 auto; padding:0; background:' . $inactivecolor . ';">';
			//$step_width = floor((100 - $total_steps) / $total_steps); // Renvoie l'entier inférieur
			$step_width = floor(100 / $total_steps); // Renvoie l'entier inférieur
			$last_step_width = 100 % $total_steps; // Modulo : les % restant de la division entière (pour ajuster dernière colonne)
			for ($k = 1; $k <= $total_steps; $k++) {
				$style = 'float:left; padding:6px 0; text-align:center; font-weight:bold; text-shadow:1px 1px 1px #000; color:#FFF; ';
				if ($k != $total_steps) $style .= 'width:' . $step_width . '%; '; else $style .= 'width:' . ($step_width + $last_step_width) . '%; ';
				if ($k == $current_step) {
					$class = 'active'; $style .= 'background:' . $activecolor . ';';
				} else {
					if ($k < $current_step) {
						$class = 'done';
						$style .= 'background:' . $defaultcolor . ';';
					} else {
						$class = 'todo';
						$style .= 'background:' . $inactivecolor . ';';
					}
				}
				$class = ' class="' . $class . '"';
				$questionnaire_step .= '<div ' . $class . ' style="' . $style . '">';
				if ($k != $total_steps) $questionnaire_step .= elgg_echo('dossierdepreuve:referentiel:' . $k); else $questionnaire_step .= 'Résultats';
				$questionnaire_step .= '</div>';
			}
			$questionnaire_step .= '<div class="clearfloat"></div></div>';
		}
	}
	if (!empty($email)) { $questionnaire_info .= "Email pour l'envoi du questionnaire : $email (<em>vous pourrez choisir de l'envoyer ou non en fin de questionnaire</em>)<br />"; }
	
	
	// ETAPES DU QUESTIONNAIRE
	switch($step) {
		
		// QUESTIONNAIRE DE LA PLATEFORME
		case 'quest':
			// Pour les questions elle-mêmes : autres switchs selon les types de questionnaires ?
			// Note : liste par domaine.. histoire de pas tout avoir d'un coup
			// Parcours du référentiel
			foreach ($referentiel as $domaine => $competences) {
				if ($current_domaine != $domaine) continue;
				// Correction décalage de 1 pour les domaines)
				$domaine_basename = 'dossierdepreuve:referentiel:' . $domaine;
				// Nom du domaine
				$questionnaire .= '<h4>' . elgg_echo($domaine_basename) . '</h4>';
				foreach ($competences as $competence) {
					$competence_basename = $domaine_basename . ':' . $competence;
					$basename = $type_referentiel . ':' . $domaine . ':' . $competence . ':';
					$property_basename = str_replace(':', '_', $basename);
					// Nom et description de la compétence
					$questionnaire .= '<a href="#" title="' . str_replace(array('<br />', '<br>', '\n'), ' &nbsp; ', elgg_echo($competence_basename . ':aide')) . '"><strong>' . elgg_echo($competence_basename) . '&nbsp;:</strong> ';
					$questionnaire .= elgg_echo($competence_basename . ':description') . '</a><br /><br />';
					// Récupération des questions de positionnement pour chaque compétence ("Je sais...")
					//$elements = elgg_get_plugin_setting($basename . 'elements', 'dossierdepreuve');
					$savoirs = elgg_get_plugin_setting($property_basename . 'savoirs', 'dossierdepreuve');
					//$criteres = elgg_get_plugin_setting($basename . 'criteres', 'dossierdepreuve');
					$visualhelp = elgg_get_plugin_setting($property_basename . 'visualhelp', 'dossierdepreuve');
					
					// Découpage des données en questions : une question par ligne (multiligne avec des <br />) + Aide associée
					// Important : must explode on "\n", and not '\n' !  It won't work otherwise
					$questions_competence = explode("\n", $savoirs);
					$visualhelp_competence = explode("\n", $visualhelp);
					
					$i = 1;
					foreach ($questions_competence as $q) {
						// Aide visuelle associée, si définie - Note : l'index commence à 0, mais on initialise $i à 1 pour faciliter la numérotation des questions
						$q_help = '';
						if (isset($visualhelp_competence[($i-1)])) $q_help = $visualhelp_competence[($i-1)];
						// Question (et mise en page spécifique si aide visuelle associée)
						if (!empty($q_help)) { $questionnaire .= '<div style="width:66%; float:left;">'; }
						$questionnaire .= '<strong>Question n°'.$i.'&nbsp;: JE SAIS...</strong> ' . $q . '<br />';
						// Positionnement = Réponse
						$questionnaire .= '<label><strong>=> Mon positionnement :</strong> ' . elgg_view('input/dropdown', array('name' => "answer[$domaine][$competence][$i]", 'options_values' => $autopositionnement_opt)) . '</label>';
						// Ajout de l'aide visuelle, si définie
						if (!empty($q_help)) { $questionnaire .= '</div><div style="width:30%; float:right; border:1px dashed grey; padding:1%;">' . $q_help . '</div>'; }
						$questionnaire .= '<div class="clearfloat"></div><br />';
						$i++;
					}
					$questionnaire .= '<br />';
				}
				$questionnaire .= '<br />';
			}
			// Note : step remain the same until we determine it's done (not here)
			break;
			
		// FIN DE QUESTIONNAIRE : choix envoi email et/ou maj du dossier de preuve ssi connecté
		case 'endofquest':
			// Pour choix de l'envoi de l'email et/ou alimentation du dossier de suivi avec les infos
			$questionnaire .= "<p><strong>Ce questionnaire d'autopositionnement est maintenant terminé.</strong></p>";
			// Les résultats du test d'autopositionnement
			if (in_array($step, array('endofquest', 'final'))) {
				$questionnaire .= '<h3>Résultats du test du positionnement</h3>';
				$questionnaire .= '<div id="questionnaire-report-accordion">' . $questionnaire_report . '</div>';
			}
			$questionnaire .= "<h3>Envoi des résultats par email";
			if (elgg_is_logged_in()) $questionnaire .= " et mise à jour de mon dossier de suivi";
			$questionnaire .= "</h3>";
			$questionnaire .= "<p>Vous pouvez choisir de recevoir ces résultats par email&nbsp;: pour cela merci d'indiquer votre adresse email ci-dessous.</p>";
			// Saisie de l'EMail
			$questionnaire .= '<p><label for="dossierdepreuve_contact_email">' . elgg_echo('dossierdepreuve:auto:contact_email') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:auto:contact_email:help') . elgg_view('input/text', array('name' => 'contact_email', 'id' => 'dossierdepreuve_contact_email', 'value' => $email)) . '</p>';
			// Choix d'envoyer un email
			$questionnaire .= '<p><label for="dossierdepreuve_send_email">' . elgg_echo('dossierdepreuve:auto:send_email') . ' ' . elgg_view('input/dropdown', array('name' => 'send_email', 'options_values' => $send_email_opt, 'id' => 'dossierdepreuve_send_email', 'value' => $send_email)) . '</p>';
			// MAJ de son dossier : ssi connecté
			if (elgg_is_logged_in()) {
				/*
				$questionnaire .= "<p>Vous pouvez utiliser ces données pour mettre à jour votre dossier de suvi (partie autopositionnement).</p>";
				$questionnaire .= '<p><label for="dossierdepreuve_update_dossier">' . elgg_echo('dossierdepreuve:auto:update_dossier') . ' ' . elgg_view('input/dropdown', array('name' => 'update_dossier', 'options_values' => $update_dossier_opt, 'id' => 'dossierdepreuve_update_dossier', 'value' => $update_dossier)) . '</p>';
				*/
				// @TODO : récupérer le dossier en cours.. ou pas car c'est fait dans le formulaire d'édition 
				// (par défaut ou si le guid fourni est invalide on récupère le dossier en cours)1
				$edit_url = $vars['url'] . 'dossierdepreuve/edit/' . $dossierdepreuve->guid;
				$autopositionnement_data = urlencode(serialize($_SESSION['dossierdepreuve']->history_data['history']));
				$questionnaire .= 'Pour mettre à jour votre dossier de suivi, veuillez cliquer sur ce lien : <a target="_blank" class="elgg-button elgg-button-action" href="' . $edit_url . '?update_autopositionnement=true&autopositionnement_data=' . $autopositionnement_data . '">Mettre à jour mon dossier de suivi avec ces informations (nouvelle fenêtre)</a>.';
				
			}
			$step = 'final'; // Set next step = finalise
			break;
			
		// FINAL : ENVOI DES DONNES ET MAJ
		case 'final':
			system_message("Autopositionnement terminé !");
			// Send mail
			if ($email && $send_email) {
				// @TODO : améliorable
				$msg_from = $CONFIG->sitename . ' <' . $CONFIG->email . '>';
				$msg_subject = 'Autopositionnement B2i Adultes';
				$msg_content = '';
				$msg_content .= "<p>Vous venez de terminer votre questionnaire d'autopositionnement de la plateforme des Compétences Numériques.<br />Comme vous l'avez demandé, nous vous faisons parvenir par mail les résultats de votre test. Ceux-ci ne sont pas conservés sur la plateforme et restent anonymes.<br />Si vous le souhiatez, vous pouvez utiliser le code présent dans le mail pour reprendre votre questionnaire dans l'état où vous l'aviez laissé.</p>";
				$msg_content .= $questionnaire_report;
				$msg_content .= "<p>Données à utiliser pour restaurer votre autopositionnement sur le site, ou mettre à jour votre dossier de preuve avec ces informations :<hr />" . serialize($history_data) . '<hr />';
				$msg_content .= "<p>Merci d'avoir utilisé l'outil de positionnement de Compétence Numériques !<br />Vous pouvez le recommander en envoyant ce lien aux personnes que cela pourrait intéresser : " . $CONFIG->url . "</p>";
				$msg_params = null;
				if (elgg_send_email($msg_from, $email, $msg_subject, $msg_content, $msg_params)) {
					system_message("Un mail de synthèse a été envoyé à $email.");
				} else register_error("Adresse email invalide : le rapport n'a pas pu être envoyé !");
			}
			// Update dossierdepreuve
			if ($update_dossier) {
				// @TODO
				//system_message("Dossier de suivi mis à jour !");
				register_error("La mise à jour du dossier de suivi n'est pas encore fonctionnelle !");
				/*
				$dossiers = dossierdepreuve_get_user_dossiers($_SESSION['user']->guid, 'b2iadultes');
				if ($dossiers) {
					foreach ($dossiers as $guid => $ent) {
						$returnvalue[$ent->guid] = $ent;
					}
				}
				*/
				// @TODO : récupérer le dossier en cours.. ou pas car c'est fait dans le formulaire d'édition 
				// (par défaut ou si le guid fourni est invalide on récupère le dossier en cours)
				$edit_url = $vars['url'] . 'dossierdepreuve/edit/' . $dossierdepreuve->guid;
				$autopositionnement_data = urlencode(serialize($_SESSION['dossierdepreuve']->history_data['history']));
				$questionnaire .= 'Pour mettre à jour votre dossier de suivi, veuillez cliquer sur ce lien : <a href="' . $edit_url . '?update_autopositionnement=true&autopositionnement_data=' . $autopositionnement_data . '">Mettre à jour mon dossier de suivi avec ces informations</a>.';
			}
			$step = 'clearall'; // Set next step = erase session data and go to start
			break;
		
		// SELECTION DES DOMAINES A EVALUER
		case 'selection':
			$questionnaire .= "Choix des domaines.";
			/*
			echo '<p><label for="dossierdepreuve_selection">' . elgg_echo('dossierdepreuve:selection') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:selection:help') . elgg_view('input/checkboxes', array('name' => 'selection', 'id' => 'dossierdepreuve_selection', 'options' => $selection_opt)) . '</p>';
			*/
			$step = 'quest'; // Set next step = go to questionnaire
			break;
			
		// RETOUR AU DÉBUT
		case 'clearall';
			// Réinitialise toutes les données saisies et permet de commencer un nouveau questionnaire
			//if (elgg_is_logged_in()) $_SESSION['user']->history_data = null; else 
			$_SESSION['dossierdepreuve']->history_data = null;
			set_input('history_data', null);
			$step = 'start'; // Set next step = go to start
			$questionnaire .= "<p>Données du questionnaire effacées.</p>";
			break;
			
		// FORMULAIRE DE RESTAURATION
		case 'restore_history';
			// Saisie des données pour rétablir un positionnement à partir de données sauvegardées
			$questionnaire .= elgg_echo('dossierdepreuve:auto:restore:instructions') . '<br />' . elgg_view('input/plaintext', array('name' => 'restore_history'));
			$step = 'session_restore';
			break;
			
		// RESTAURER VIA UN CODE
		case 'session_restore';
			// Rétablit un positionnement à partir de données sauvegardées
			$restore_history = get_input('restore_history', false);
			$history_data = unserialize($restore_history);
			//if (elgg_is_logged_in()) $_SESSION['user']->history_data = $history_data; else 
			$_SESSION['dossierdepreuve']->history_data = $history_data;
			// Restore all saved data vars
			$step = $history_data['step'];
			$auto_type = $history_data['auto_type'];
			$selection = $history_data['selection'];
			$email = $history_data['email'];
			$send_email = $history_data['send_email'];
			$update_dossier = $history_data['update_dossier'];
			$current_domaine = $history_data['domaine'];
			$current_competence = $history_data['competence'];
			$question = $history_data['question'];
			$answer = $history_data['answer'];
			$current = $history_data['current'];
			$history = $history_data['history'];
			break;
			
		// FORMULAIRE GOOGLE
		case 'googleform';
			$googleform_url = 'https://docs.google.com/forms/d/1Y28JS9Y5egVxVGN9cQW1bl23mo1KUByXcqlNH8TTkhI/viewform';
			echo '<p><a href="' . $googleform_url . '" target="_new">' . elgg_echo('dossierdepreuve:auto_type:googleform:clickopen') . '</a>.<br />' . elgg_echo('dossierdepreuve:auto_type:googleform:help') . '</p>';
			echo '<iframe src="' . $googleform_url . '?embedded=true" style="width:100%; height:500px;" frameborder="0" marginheight="0" marginwidth="0">Chargement en cours...</iframe>';
			break;
		
		// DEBUT DU FORMULAIRE - Choix du questionnaire
		case 'start':
		default:
			$questionnaire_info .= '<p>' . elgg_echo('dossierdepreuve:auto:description') . '</p>';
			// Global info about questionnaire
			$questionnaire_info .= '<p><strong>' . elgg_echo('dossierdepreuve:auto:public:disclaimer') . '</strong><p>';
			// Public mode : we can't save data nor update dossierdepreuve object
			if (!elgg_is_logged_in()) $questionnaire_info .= '<blockquote>' . elgg_echo('dossierdepreuve:auto:warning') . '</blockquote>';
			// Choix du questionnaire
			$questionnaire .= '<p><label for="dossierdepreuve_auto_type">' . elgg_echo('dossierdepreuve:auto_type') . '</label> &nbsp; ' . elgg_view('input/radio', array('name' => 'auto_type', 'id' => 'dossierdepreuve_auto_type', 'options' => $auto_type_opt, 'value' => $auto_type)) . '</p>';
			$questionnaire_help .= elgg_echo('dossierdepreuve:auto_type:help');
			// Note : step will be determined through this question
			break;
	}
	
	
	// Composition du contenu du questionnaire
	
	// Onglets pour chacun des domaines
	$tabs[] = array(
				'class' => '', 'id' => '1', 'selected' => true,
				'href' => '#1', 'text' => 'Domaine 1',
				'link_class' => '', 'link_id' => '',
			);
	$tabs[] = array(
			'class' => '', 'id' => '2', 'selected' => '',
			'href' => '#2', 'text' => 'Domaine 2',
			'link_class' => '', 'link_id' => '',
		);
	$tabcontent = '';
	$tabcontent .= '<div id="autopositionnement_quest_tab_content_1">Test contenu domaine 1</div>';
	$tabcontent .= '<div id="autopositionnement_quest_tab_content_2">Test contenu domaine 2</div>';
	?>
	
	<div id="autopositionnement_quest_tabs">
		<?php echo elgg_view('navigation/tabs', array('tabs' => $tabs, 'type' => 'vertical', 'class' => '')); ?>
	</div>
	<div id="autopositionnement_quest_tab_content_wrapper">
		<?php echo $tabcontent; ?>
	</div>
	<script>
	// Domaine switcher
	$("#autopositionnement_quest_tabs a").click(function(){
		var id = $(this).attr("href").replace("#", ""); 
		$("#autopositionnement_quest_tabs li").removeClass("elgg-state-selected");
		$(this).parent().addClass("elgg-state-selected");
		$('#autopositionnement_quest_tab_content_wrapper>div').hide();
		$('#autopositionnement_quest_tab_content_' + id).show();
	});
	</script>
	<?php
	
	// Des informations qui sont affichées tout au long du questionnaire
	echo '<div>' . $questionnaire_info . '</div><br />';
	// Affichage de la partie du questionnaire en cours
	if (!empty($questionnaire)) {
		echo $questionnaire_step;
		echo '<div style="border:3px solid ' . $activecolor . '; padding:3px 6px;">';
		if (!empty($questionnaire) && !empty($questionnaire_help)) { echo '<div style="width:66%; float:left; margin-left:">'; }
		// Le contenu du questionnaire (à cette étape)
		echo $questionnaire;
		if (!empty($questionnaire) && !empty($questionnaire_help)) { echo '</div><div style="width:30%; float:right; border:1px dashed grey; padding:1%;">'; }
		// L'aide associée (vidéo, texte, image)
		echo $questionnaire_help;
		if (!empty($questionnaire) && !empty($questionnaire_help)) { echo '</div>'; }
		echo '<div class="clearfloat"></div>';
		echo '</div>';
	}
	
	
	// FORM HIDDEN FIELDS : pass persistent values
	// Hidden fields that we should better pass each time (even if stored into session)
	// Note : we don't need previous nor current question/answer
	if (!empty($step) && ($step != 'clearall')) echo '<input type="hidden" name="step" value="' . $step . '" />';
	if (!empty($auto_type) && !in_array($step, array('start', 'clearfall'))) echo '<input type="hidden" name="auto_type" value="' . $auto_type . '" />';
	if (!empty($selection)) echo '<input type="hidden" name="selection" value="' . $selection . '" />';
	if (!empty($current_domaine)) echo '<input type="hidden" name="domaine" value="' . $current_domaine . '" />';
	if (!empty($current_competence)) echo '<input type="hidden" name="competence" value="' . $current_competence . '" />';
	/*
	if (!empty($history)) echo '<input type="hidden" name="history" value="' . serialize($history) . '" />';
	if (elgg_is_logged_in()) echo '<input type="hidden" name="owner_guid" value="' . $owner_guid . '" />';
	if (elgg_is_logged_in()) echo '<input type="hidden" name="container_guid" value="' . $container_guid . '" />';
	*/
	
	
	
	// FORM SUBMIT BUTTON
	echo '<div class="clearfloat"></div><br />';
	if (empty($step) || in_array($step, array('start', 'selection', 'quest', 'endofquest'))) {
		echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:next"))) . '</p>';
	} else if ($step == 'final') {
		echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:finish"))) . '</p>';
	} else if (in_array($step, array('restore_history', 'session_restore'))) {
		echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:restore"))) . '</p>';
	} else {
		if ($auto_type != 'googleform') echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:save"))) . '</p>';
	}
	?>
	</form>
	
	
	<?php
	// CODE DE RESTAURATION - pas pour les candidats
	if (elgg_is_admin_logged_in()) {
		echo '<br /><div id="questionnaire-restore-data"><h3>' . elgg_echo('dossierdepreuve:auto:restorecode') . '</h3>';
		echo '<div><p>' . elgg_echo('dossierdepreuve:auto:restorecode:help') . '</p><textarea>';
		//if (elgg_is_logged_in()) echo serialize($_SESSION['user']->history_data); else 
		echo serialize($_SESSION['dossierdepreuve']->history_data);
		echo '</textarea></div>';
		echo '</div>';
	}
	
	// FORM DE REINITIALISATION : retour au début
	echo '<br /><form enctype="multipart/form-data" method="post">
		<input type="hidden" name="step" value="clearall" />
		<p>' . elgg_view('input/submit', array('value' => elgg_echo('dossierdepreuve:auto:clearandrestart'), 'class' => 'elgg-button-delete')) . '</a></p>
		</form>';
	/*
	if (elgg_is_admin_logged_in()) {
		//if (elgg_is_logged_in()) $print_data = print_r($_SESSION['user']->history_data, true); else 
		$print_data = print_r($_SESSION['dossierdepreuve']->history_data, true);
		//$print_data = str_replace(array("\n", ' '), array('<br />', '&nbsp;'), $print_data);
		$print_data = str_replace(array(' ', "\n", "\r", '\n', '\r'), array('&nbsp;', '<br/>', '<br/>', '<br/>', '<br/>'), $print_data);
		echo "<hr />(ADMIN / DEBUG) Données stockées en session :<br />" . $print_data;
	}
	*/
	?>
	
</div>

