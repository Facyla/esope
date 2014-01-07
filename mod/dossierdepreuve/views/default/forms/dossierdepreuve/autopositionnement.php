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
	// User connecté = celui dont le dossier est mis à jour
	$owner_guid = elgg_get_logged_in_user_guid();
	$dossierdepreuve = dossierdepreuve_get_user_dossier($owner_guid);
	if ($dossierdepreuve) {
		$typedossier = $dossierdepreuve->typedossier;
		if (empty($typedossier)) $typedossier = 'b2iadultes';
	}
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



// Liste des valeurs des sélecteurs
// Type de questionnaire
$auto_type_opt = array(
	elgg_echo('dossierdepreuve:auto_type:full') => 'full', 
	//elgg_echo('dossierdepreuve:auto_type:limited') => 'limited', 
	//elgg_echo('dossierdepreuve:auto_type:random') => 'random', 
	//elgg_echo('dossierdepreuve:auto_type:googleform') => 'googleform', 
	//elgg_echo('dossierdepreuve:auto_type:restore_history') => 'restore_history', 
	);
// Valeurs pour l'autopositionnement
$autopositionnement_opt = array(
		'' => elgg_echo ('dossierdepreuve:autopositionnement:'),
		'100' => elgg_echo ('dossierdepreuve:autopositionnement:100'),
		//'50' => elgg_echo ('dossierdepreuve:autopositionnement:50'),
		'0' => elgg_echo ('dossierdepreuve:autopositionnement:0'),
	);
/*
.elgg-icon-star-empty
.elgg-icon-star
.elgg-icon-star-alt
.elgg-icon-thumbs-down-alt
.elgg-icon-thumbs-up-alt
//. '<span class="elgg-icon elgg-icon-star-empty"></span>'
//. '<span class="elgg-icon elgg-icon-star"></span>'
//. '<span class="elgg-icon elgg-icon-star-alt"></span>';
*/
$autopositionnement_radio = array(
		elgg_echo ('dossierdepreuve:autopositionnement:100') => '100',
		elgg_echo ('dossierdepreuve:autopositionnement:0') => '0',
		//'<span class="autopositionnement-question-100"></span>' . elgg_echo ('dossierdepreuve:autopositionnement:100') => '100',
		//'<span class="autopositionnement-question-50"></span>' . elgg_echo ('dossierdepreuve:autopositionnement:50') => '50',
		//'<span class="autopositionnement-question-0"></span>' . elgg_echo ('dossierdepreuve:autopositionnement:0') => '0',
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

// Scripts pour les blocs pliant en accordéon
?>
<script type="text/javascript">
$(function() {
	$('#questionnaire-report-accordion').accordion({ header:'h4', autoHeight:false, collapsible:true, active:false });
	$('#questionnaire-restore-data').accordion({ header:'h3', autoHeight:false, collapsible:true, active:false });
});
<?php
/*
if ($referentiel) {
	foreach ($referentiel as $domaine => $competences) {
		"$('#autopositionnement_quest_tab_content_" . $domaine . "').accordion({ header:'h3', autoHeight:false, collapsible:true, active:false });";
	}
}
*/
?>
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
	//$send_email = get_input('send_email', 'yes');
	if (!empty($email)) $send_email = 'yes';
	// MAJ du dossier de suivi ?
	if (elgg_is_logged_in()) $update_dossier = get_input('update_dossier', 'yes');
	// Domaine actuel : initialisé à 0 par défaut (on ajoute 1 par la suite)
	$current_domaine = get_input('domaine', 0);
	// Compétence actuelle : initialisée à 1 par défaut
	//$current_competence = get_input('competence', 0); // Non utilisé
	// Questions posées (précédentes donc) - utile seulement lorsqu'on pose une sélection de questions (limited)
	//$question = get_input('question', ''); // Non utilisé
	// Réponse donnée : array[domaine][competence][num_question] = réponse
	$answer = get_input('answer', false);
	
	
	// RECUPERATION DES DONNÉES STOCKEES EN SESSION
	//if (elgg_is_logged_in()) $history_data = $_SESSION['user']->history_data; else 
	$history_data = $_SESSION['dossierdepreuve']->history_data;
	if (elgg_is_logged_in()) {
		if (!$history_data['history']) {
			//register_error("Pas de données dans l'historique. Récupération à partir du dossier de preuve.");
		} else {
			//system_message("Vos réponses précédentes ont été récupérées. Vous pouvez reprendre vos réponses, et terminer le questionnaire pour les enregistrer.");
		}
		//$history_data = $_SESSION['user']->history_data; else 
	}
	//echo "DONNEES DE SESSION : " . print_r($history_data, true) . '<hr />'; // debug
	// Historique des Q/R
	$history = $history_data['history'];
	// MAJ et conservation des données Q/R ssi elles sont valides = ssi on a de nouvelles données !
	if ($answer) $history = $answer;
	/*
	if (!empty($current_domaine) && isset($referentiel[$current_domaine])) {
		// Ajout de la dernière série de Q/R - sous la forme ('num_domaine' => answer_array)
		//$history[$current_domaine] = $answer[$current_domaine];
		$history = $answer;
		//echo "Données 'history' : " . print_r($history, true) . '<hr />'; // debug
	}
	*/
	
	//if (elgg_is_admin_logged_in()) 
	//echo "<hr />auto_type=$auto_type / step=$step / selection=$selection / email=$email / domaine=$current_domaine / compétence=$current_competence / question=$question / answer=$answer/ update_dossier=$update_dossier<hr />"; // debug
	
	
	// CALCULS DIVERS À PARTIR DES VARIABLES
	// Etape suivante, selon la sélection initiale
	if (!in_array($step, array('quest', 'endofquest', 'final', 'session_restore', 'restore_history'))) {
		if ($auto_type == 'full') { $step = 'quest'; }
		if ($auto_type == 'limited') { $step = 'selection'; }
		if ($auto_type == 'googleform') { $step = 'googleform'; }
		if ($auto_type == 'restore_history') { $step = 'restore_history'; }
	}
	
	//if (elgg_is_admin_logged_in()) 
	//echo "<hr />auto_type=$auto_type / step=$step / selection=$selection / email=$email / domaine=$current_domaine / compétence=$current_competence / question=$question / answer=$answer/ update_dossier=$update_dossier<hr />"; // debug
	
	
	// Avance dans le questionnaire et rapport : ssi le questionnaire est en cours, ou terminé
	if (in_array($step, array('quest', 'endofquest', 'final'))) {
		
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
		//$total_competences_perdomaine = count($referentiel[$current_domaine]);
		// Nombre total de questions
		//$total_questions = count($referentiel);
		// Nombre total de questions pour le domaine actuel
		//$total_questions_percompetence = count($referentiel[$current_domaine][$current_competence]);
		// Nombre total de questions pour la compétence actuelle
		//$total_questions_percompetence = count($referentiel[$current_domaine][$current_competence]);
		
		
		// Ssi le questionnaire en cours : on détermine ce qu'on fait maintenant (étape suivante ou fin)
		if ($step == 'quest') {
			// Domaine actuel => on avance de 1 (ne pas changer : indique le positionnement actuel *après incrément*)
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
				$step = 'endofquest';
				// Et du coup on n'a plus de besoin de domaine ni de compétence
				$current_domaine = ''; $current_competence = '';
			}
		}
		
		// RAPPORT SUR LE POSITIONNEMENT PAR DOMAINE
		// + quelques stats/indicateurs
		$questionnaire_report = '';
		$total_q = 0;
		$answered_q = 0;
		$score_total = 0;
		$validated_competences = 0;
		$validated_total = 0;
		
		// Pour chacun des domaines
		$history_count = count($history);
		//$referentiel[$current_domaine][$current_competence]
		foreach ($referentiel as $j => $ref_domaine) {
			$domaine = $history[$j];
		//foreach ($history as $j => $domaine) {
			$domaine_report = '';
			$total_q_domaine = 0;
			$answered_q_domaine = 0;
			$score_domaine = 0;
			$validated_domaine = 0;
			$validated_per_domaine = 0;
			$count_q_domaine = count($domaine);
			$count_competence_domaine = count($referentiel[$j]);
			
			// Pour chacune des compétences
			foreach ($ref_domaine as $k => $ref_competence) {
				$competence = $history[$j][$k];
			//foreach ($domaine as $k => $competence) {
				$score_competence = 0;
				$validated_competence = 0;
				
				$property_basename = $type_referentiel . '_' . $j . '_' . $k . '_';
				// Récupération des questions pour cette compétence (savoirs => "Je sais...")
				$savoirs = elgg_get_plugin_setting($property_basename . 'savoirs', 'dossierdepreuve');
				// Découpage des données en questions : une question par ligne
				// Important : must explode on "\n", and not '\n' !  It won't work otherwise
				$questions_competence = explode("\n", $savoirs);
				$count_q_per_competence = count($questions_competence);
				$total_q_domaine += $count_q_per_competence; // Nb de questions total (par compétence)
				
				// Les calculs étant faits.. si aucune réponse, on passe à la suivante
				if (!isset($competence)) { continue; }
				$domaine_report .= "<p>" . elgg_echo('dossierdepreuve:referentiel:' . $j . ':' . $k) . '&nbsp;: ' . $count_q_per_competence . ' questions<br />';
				
				// Pour chacune des questions définies/sélectionnées
				foreach ($competence as $i => $q) {
					if (strlen($q) > 0) {
						$answered_q_domaine++; // Nb de questions répondues
						$domaine_report .= elgg_echo('dossierdepreuve:report:questionlabel', array($i, $q));
						$score_competence += $q;
					} else {
						// Note : pas de positionnement = note de 0 (on ne compte les non-réponses que pour info)
						$domaine_report .= elgg_echo('dossierdepreuve:report:noeval', array($i));
					}
				}
				
				// Note : $i est positionné sur n° de la dernière question répondue, pas sur le total
				//$score_competence = round($score_competence/$i);
				$score_competence = round($score_competence/$count_q_per_competence);
				$domaine_report .= elgg_echo('dossierdepreuve:report:compeval', array($score_competence));
				$score_domaine += $score_competence;
				// Validation de la compétence : >= 50%
				if ($score_competence >= $threshold_validation) { $validated_competence += 1; }
				// Evaluation sur cette compétence
				if ($score_competence < $threshold_low) {
					$domaine_report .= elgg_echo('dossierdepreuve:report:comp:nonacquis');
				} else  if ($score_competence >= $threshold_high) {
					$domaine_report .= elgg_echo('dossierdepreuve:report:comp:acquis');
				} else {
					$domaine_report .= elgg_echo('dossierdepreuve:report:comp:encours');
				}
				$domaine_report .= '</p>';
				$validated_per_domaine += $validated_competence;
			}
			
			// Synthèse par domaine
			// Calcul sur le domaine avec le score par compétence (sinon on sur-représente les compétences avec bcp de questions), 
			// soit moyenne du score sur le domaine = total/nb_competence (arrondi)
			$score_domaine = round($score_domaine/$count_competence_domaine);
			// Validation du domaine : "La délivrance du brevet suppose qu’environ 70 % des compétences de chacun des domaines du référentiel soient validées (soit 2 compétences sur 3 ou 3 compétences sur 4 compétences par domaine)"
			// Soit d'un point de vue programmation : competences_validees >= (nb_questions - 1) / nb_questions
			// Seuil = (total_compétences - 1) doivent être validées
			if ($validated_per_domaine >= ($count_competence_domaine - 1)) { $validated_domaine = 1; }
			$domaine_report .= '<p>';
			// @TODO : comptage du total des questions à revoir !!
			//$domaine_report .= "Vous avez répondu à $answered_q_domaine sur les $total_q_domaine questions pour ce domaine (" . round(100*$answered_q_domaine/$total_q_domaine) . "%), soit un score moyen de $score_domaine%.<br />";
			$domaine_report .= elgg_echo('dossierdepreuve:report:answered', array($answered_q_domaine));
			$domaine_report .= elgg_echo('dossierdepreuve:report:domainaverage', array($score_domaine));
			$domaine_report .= '<br />';
			$domaine_report .= elgg_echo('dossierdepreuve:report:domaincompvalidation', array($validated_per_domaine, $count_competence_domaine));
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
			$validated_competences += $validated_per_domaine;
			
			// Tous les calculs étant faits, on n'affiche les résultats que pour les réponses faites 
			// (=> on skippe si pas de réponse)
			if ($answered_q_domaine == 0) { continue; }
			
			// Titre réponses domaine
			$questionnaire_report .= '<h4>' . elgg_echo('dossierdepreuve:report:domainpos', array($j));
			$questionnaire_report .= $validated_per_domaine . '/' . $count_competence_domaine . ' ';
			//if ($validated_domaine > 0) $questionnaire_report .= '<span style="font-weight:bold; color:darkgreen;">validé</span>';
			//else $questionnaire_report .= '<span style="color:darkred;">non validé</span>';
			//if ($score_domaine < $threshold_low) {
			if ($score_domaine == 0) {
				$questionnaire_report .= elgg_echo('dossierdepreuve:report:comp:nonacquis');
			} else if ($score_domaine >= $threshold_high) {
				$questionnaire_report .= elgg_echo('dossierdepreuve:report:comp:acquis');
			} else {
				$questionnaire_report .= elgg_echo('dossierdepreuve:report:comp:encours');
			}
			$questionnaire_report .= "</h4>";
			$questionnaire_report .= "<div>" . $domaine_report . "</div>";
		}
		
		// Synthèse globale sur le référentiel
		$questionnaire_report .= '<br />';
		$questionnaire_report .= "<p>";
		// @TODO : comptage du total des questions à revoir !!
		//$questionnaire_report .= "Vous avez répondu à $answered_q des $total_q questions de ce test d'autopositionnement (" . round(100*$answered_q/$total_q) . "%).<br />";
		$questionnaire_report .= elgg_echo('dossierdepreuve:report:totalanswered', array($answered_q, $total_q));
		if ($history_count > 0) {
			$questionnaire_report .= elgg_echo('dossierdepreuve:report:totalaverage', array($history_count, $total_domaines, round($score_total/$history_count)));
		}
		if ($answered_q == $total_q) {
			$questionnaire_report .= elgg_echo('dossierdepreuve:report:totalvalidation', array($validated_total, $total_domaines, $validated_competences, $total_competences));
		} else if ($answered_q >= (0.7*$total_q)) {
			$questionnaire_report .= elgg_echo('dossierdepreuve:report:totalvalidation:partial', array($validated_total, $total_domaines, $validated_competences, $total_competences));
		} else {
			$questionnaire_report .= elgg_echo('dossierdepreuve:report:totalvalidation:toopartial', array($validated_competences, $total_competences));
		}
		$questionnaire_report .= "</p>";
		$questionnaire_report .= '<br />';
		
	}
	
	
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
	
	
	// QUESTIONNAIRE : Le formulaire proprement dit
	//echo '<form action="' . $vars['url'] . 'action/' . $action . '" enctype="multipart/form-data" method="post">';
	echo '<form action="" enctype="multipart/form-data" method="post">';
	echo elgg_view('input/securitytoken');
	//echo '<h3>' . elgg_echo('dossierdepreuve:auto:title') . '</h3>'; // Titre déjé mis dans la page
	$questionnaire_info = '';
	$questionnaire_step = '';
	$questionnaire = '';
	$questionnaire_help = '';
	
	
	// Infos toujours affichées (si disponibles)
	if (!empty($auto_type) && ($step != 'googleform') && ($step != 'final')) {
		$questionnaire_info .= elgg_echo('dossierdepreuve:referentiel:info', array($total_competences, $total_domaines));
		$questionnaire_info .= elgg_echo('dossierdepreuve:referentiel:infotype', array(elgg_echo('dossierdepreuve:auto_type:'.$auto_type)));
		if (!empty($limited)) $questionnaire_info .= elgg_echo('dossierdepreuve:referentiel:infoselection', array($total_domaines_selection)) . implode(', ', $selection) . ".<br />";
		
		// Barre d'avancement dans les étapes du test
		if (in_array($step, array('quest', 'endofquest'))) {
			$current_step = $current_domaine;
			if ($step == 'endofquest') {
				$current_step = $total_steps;
			} else {
				//$questionnaire_info .= "Vous en êtes à l'étape $current_step sur $total_steps du questionnaire"; // Pas de sens si onglets
				//$questionnaire_info .= ", soit le domaine n°$current_domaine, ";
				//$questionnaire_info .= "qui comporte $total_competences_perdomaine compétences<br />";
				//$questionnaire_info .= " et $total_questions_perdomaine questions";
			}
			
			// Etapes : avancement graphique => devient des onglets
			//$questionnaire_step .= "Etape $current_step sur $total_steps<br />";
			//$step_width = floor((100 - $total_steps) / $total_steps); // Renvoie l'entier inférieur
			$step_width = floor(100 / $total_steps); // Renvoie l'entier inférieur
			$last_step_width = 100 % $total_steps; // Modulo : les % restant de la division entière (pour ajuster dernière colonne)
			for ($k = 1; $k <= $total_steps; $k++) {
				$style = '';
				if ($k != $total_steps) $style .= 'width:' . $step_width . '%; '; else $style .= 'width:' . ($step_width + $last_step_width) . '%; ';
				if ($k == $current_step) {
					$class = 'elgg-state-selected';
				} else {
					if ($k != $total_steps) { $class = '';
					} else {
						$class = 'inactive';
					}
				}
				if (!empty($class)) $class = ' class="' . $class . '"';
				$questionnaire_step .= '<div id="' . $k . '" ' . $class . ' style="' . $style . '">';
				if ($k != $total_steps) {
					// Pas d'onglet si on est sur les résultats
					if ($step == 'endofquest') {
						$questionnaire_step .= elgg_echo('dossierdepreuve:referentiel:' . $k);
					} else {
						$questionnaire_step .= '<a rel="nofollow" href="#' . $k . '"">' . elgg_echo('dossierdepreuve:referentiel:' . $k) . '</a>';
					}
				} else $questionnaire_step .= elgg_echo('dossierdepreuve:results');
				$questionnaire_step .= '</div>';
			}
		}
	}
	if (!empty($email)) { $questionnaire_info .= elgg_echo('dossierdepreuve:report:email', array($email)); }
	
	
	// Define submit button (make it reusable)
	if (empty($step) || in_array($step, array('start', 'selection'))) {
		$submit_button = elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:start")));
	} else if ($step == 'quest') {
		$submit_button = elgg_echo('dossierdepreuve:next:details') . elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:next"), 'class' => 'elgg-button elgg-button-action elgg-requires-confirmation', 'rel' => elgg_echo('dossierdepreuve:report:confirmsend')));
	} else if ($step == 'endofquest') {
		$submit_button = elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:sendonly")));
	} else if ($step == 'final') {
		// Pas de bouton d'envoi (mais celui de réinitialisation est dessous), et uniquement mise à jour
		//$submit_button = elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:finish")));
	} else if (in_array($step, array('restore_history', 'session_restore'))) {
		$submit_button = elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:restore")));
	} else {
		if ($auto_type != 'googleform') $submit_button = elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:save")));
	}
	if (!empty($submit_button)) { $submit_button = '<p class="dossierdepreuve-submit">' . $submit_button . '</p>'; }
	
	
	// ETAPES DU QUESTIONNAIRE
	switch($step) {
		
		// QUESTIONNAIRE DE LA PLATEFORME
		case 'quest':
			// Pour les questions elle-mêmes : autres switchs selon les types de questionnaires ?
			// Note : liste par domaine.. histoire de pas tout avoir d'un coup
			
			$tabcontent .= '<style>
				/* Validation question */
				.dossierdepreuve-question { /* color:green; */ background: url(\'' . $vars['url'] . 'mod/dossierdepreuve/graphics/check-ok16-green.png\') left top no-repeat; padding: 0 0 0 22px; }
				.dossierdepreuve-question.nodata { /* color:red; */ background: url(\'' . $vars['url'] . 'mod/dossierdepreuve/graphics/point-interrogation-16.png\') left top no-repeat; }
				
				/* Validation compétence */
				.dossierdepreuve-competence { /* color:green; */ background: url(\'' . $vars['url'] . 'mod/dossierdepreuve/graphics/check-ok24-green.png\') left top no-repeat; padding: 4px 0 0 28px; }
				.dossierdepreuve-competence.nodata { /* color:red; */ background: url(\'' . $vars['url'] . 'mod/dossierdepreuve/graphics/point-interrogation-24.png\') left top no-repeat; }
				
				/* Validation domaine */
				.dossierdepreuve-domaine { /* color:green; */ background: url(\'' . $vars['url'] . 'mod/dossierdepreuve/graphics/check-ok32-green.png\') left top no-repeat; padding: 0px 0 0 36px; width:32px; }
				.dossierdepreuve-domaine.nodata { /* color:red; */ background: url(\'' . $vars['url'] . 'mod/dossierdepreuve/graphics/point-interrogation-32\') left top no-repeat; }
				</style>';
			$tabcontent .= '<script language="javascript">
				function validate_radio(radio, domaine, competence, question){
					var id = \'#radio-\' + domaine + \'-\' + competence + \'-\' + question;
					// Si un choix fait, on marque comme renseigné, et on vérifie pour la compétence
					if (radio.checked){
						$(id).removeClass("nodata");
						validate_competence(domaine, competence);
					}
				}
				function validate_competence(domaine, competence){
					var id = \'.competence-\' + domaine + \'-\' + competence;
					// Pour chaque question de la compétence D-C, on vérifie la présence de .nodata
					// Si aucun présent, on enlève la classe nodata
					var valid = true;
					$(\'.radio-\' + domaine + \'-\' + competence).each(function() {
						if ($(this).hasClass(\'nodata\')){ valid = false; }
					});
					// Si tout est OK, on marque la compétence comme renseignée, 
					// et on vérifie pour le domaine
					if (valid) {
						$(id).removeClass("nodata");
						validate_domaine(domaine);
					}
				}
				function validate_domaine(domaine){
					var id = \'.domaine-\' + domaine;
					// Pour chaque compétence du domaine D, on vérifie la présence de .nodata
					// Si aucun présent, on enlève la classe nodata
					var valid = true;
					$(\'.radio-\' + domaine).each(function() {
						if ($(this).hasClass(\'nodata\')){ valid = false; }
					});
					// Si tout est OK, on marque le domaine comme renseigné
					if (valid) {
						$(id).removeClass("nodata");
					}
				}
				</script>';
			
			
			// GÉNÉRATION DE LA LISTE DE QUESTIONS
			// Parcours du référentiel : pour chaque domaine
			foreach ($referentiel as $domaine => $competences) {
				//if ($current_domaine != $domaine) continue;
				$selected = false;
				if ($current_domaine == $domaine) $selected = true;
				if ($selected) {
					$tabcontent .= '<div id="autopositionnement_quest_tab_content_' . $domaine . '">';
				} else {
					$tabcontent .= '<div id="autopositionnement_quest_tab_content_' . $domaine . '" style="display:none;">';
				}
				$domaine_basename = 'dossierdepreuve:referentiel:' . $domaine;
				// Nom du domaine
				//$tabcontent .= '<div class="dossierdepreuve-domaine nodata" id="domaine-' . $domaine . '">';
				
				// Flèches de navigation dans les domaines (= changement d'onglet en pratique)
				$domaine_nav = '';
				// Flèche précédente : ssi domaine > 1 et domaine < total
				if ($domaine > 1) {
					$domaine_nav .= '<a rel="nofollow" class="dossierdepreuve-domaine-prev" style="float:left;" href="#' . ($domaine - 1) . '" title="' . elgg_echo('dossierdepreuve:auto:previousdomaintitle') . '"><img src="' . $vars['url'] . 'mod/dossierdepreuve/graphics/fleche-gauche.png" alt="' . elgg_echo('dossierdepreuve:auto:previousdomainnum', array(($domaine - 1))) . '" /> ' . elgg_echo('dossierdepreuve:auto:previousdomain') . '</a>';
				}
				// Flèche suivante : ssi domaine < total
				if ($domaine < $total_domaines) {
					$domaine_nav .= '<a rel="nofollow" class="dossierdepreuve-domaine-next" style="float:right;"  href="#' . ($domaine + 1) . '" title="' . elgg_echo('dossierdepreuve:auto:nextdomaintitle') . '">' . elgg_echo('dossierdepreuve:auto:nextdomain') . ' <img src="' . $vars['url'] . 'mod/dossierdepreuve/graphics/fleche-droite.png" alt="' . elgg_echo('dossierdepreuve:auto:previousdomainnum', array(($domaine + 1))) . '" /></a>';
				} else {
					// Dernier domaine : on ajoute le bouton de fin de questionnaire - rendu moyen avec gros bouton
					//$domaine_nav_end = '<span style="float:right; line-height: 48px;">' . $submit_button . '</span>';
				}
				$completed_domain = '<span class="dossierdepreuve-domaine nodata domaine-' . $domaine . '"></span>';
				$domaine_nav .= '<h4 style="text-align:center; font-size: 28px; line-height: 48px; padding-top:16px;">' . $completed_domain . elgg_echo($domaine_basename) . '</h4>';
				// Ajout navigation par domaine en haut de domaine
				$tabcontent .= '<div id="' . $domaine . '" style="width:100%;">' . $domaine_nav . '<div class="clearfloat"></div></div>';
				
				// Pour chaque compétence
				foreach ($competences as $competence) {
					$competence_basename = $domaine_basename . ':' . $competence;
					$basename = $type_referentiel . ':' . $domaine . ':' . $competence . ':';
					$property_basename = str_replace(':', '_', $basename);
					// Nom et description de la compétence
					$tabcontent .= '<div class="dossierdepreuve-competence nodata ' . "radio-$domaine" . ' competence-' . $domaine . '-' . $competence . '">';
					$tabcontent .= '<a href="#" title="' . str_replace(array('<br />', '<br>', '\n'), ' &nbsp; ', elgg_echo($competence_basename . ':aide')) . '"><strong>' . elgg_echo($competence_basename) . '&nbsp;:</strong> ';
					$tabcontent .= elgg_echo($competence_basename . ':description') . '</a>';
					// Niveau global actuel sur la compétence
					if (elgg_is_logged_in() && $dossierdepreuve) {
						if ($dossierdepreuve_value = $dossierdepreuve->{$typedossier . '_' . $domaine . '_' . $competence . '_' . 'value_learner'}) {
							$tabcontent .=  '<br /><em>' . elgg_echo('dossierdepreuve:currentautopositionnement') . elgg_echo('dossierdepreuve:autopositionnement:' . $dossierdepreuve_value) . '</em>';
						}
					}
					$tabcontent .= '<br /><br />';
					// Récupération des questions de positionnement pour chaque compétence (savoirs => "Je sais...")
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
						if (!empty($q_help)) { $tabcontent .= '<div style="width:66%; float:left;">'; }
						// Affichage titre questions
						$tabcontent .= '<div>';
						// Restauration des données en session si c'est le cas
						if (isset($history[$domaine][$competence][$i])) {
							$history_value = $history[$domaine][$competence][$i];
						} else {
							$history_value = false;
						}
						/* Récupération des données de positionnement
						if (!$history_value) {
							// Attention : pas possible car c'est par compétence et non par question !!!
							if (elgg_is_logged_in() && $dossierdepreuve) {
								$history_value = $dossierdepreuve->{$typedossier . '_' . $domaine . '_' . $competence . '_' . 'value_learner'
							}
						}
						*/
						if ($history_value) {
							$tabcontent .= '<span class="question-title dossierdepreuve-question ' . "radio-$domaine-$competence" . '" id="' . "radio-$domaine-$competence-$i" . '">';
						} else {
							$tabcontent .= '<span class="question-title dossierdepreuve-question nodata ' . "radio-$domaine-$competence" . '" id="' . "radio-$domaine-$competence-$i" . '">';
						}
						$tabcontent .= elgg_echo('dossierdepreuve:auto:questionlabel', array($i, $q)) . '</p>';
						// Positionnement = Réponse
						//$tabcontent .= '<label><strong>=> Mon positionnement :</strong> ' . elgg_view('input/dropdown', array('name' => "answer[$domaine][$competence][$i]", 'options_values' => $autopositionnement_opt)) . '</label>';
						//$tabcontent .= elgg_echo('dossierdepreuve:auto:myowneval');
						$tabcontent .= '</span> ';
						$tabcontent .= elgg_view('input/radio', array('name' => "answer[$domaine][$competence][$i]", 'options' => $autopositionnement_radio, 'align' => 'horizontal', 'js' => ' onClick="validate_radio(this, '.$domaine.', '.$competence.', '.$i.');"', 'value' => $history_value, 'class' => "questio-answer")) . '</p>';
						// Ajout de l'aide visuelle, si définie
						if (!empty($q_help)) { $tabcontent .= '</div><div style="width:30%; float:right; border:1px dashed grey; padding:1%;">' . $q_help . '</div>'; }
						$tabcontent .= '<div class="clearfloat"></div><br />';
						$i++;
					}
					$tabcontent .= '</div>';
					$tabcontent .= '<br />';
				}
				// Ajout navigation par domaine en bas de domaine
				$tabcontent .= '<div id="' . $domaine . '" style="width:100%;">' . $domaine_nav_end . $domaine_nav . '<div class="clearfloat"></div></div>';
				$tabcontent .= '</div>';
				//$tabcontent .= '</div>'; // Fin marqueur validation
				$tabcontent .= '<br />';
			}
			
			/* Mail pour envoi : mieux vaut le mettre à un seul endroit !
			$questionnaire_email .= '<h3>' . elgg_echo('dossierdepreuve:results:sendbymail') . '</h3>';
			$questionnaire_email .= '<p>' . elgg_echo('dossierdepreuve:results:sendbymail:description') . '</p>';
			// Saisie de l'EMail
			$questionnaire_email .= '<p><label for="dossierdepreuve_contact_email">' . elgg_echo('dossierdepreuve:auto:contact_email') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:auto:contact_email:help') . elgg_view('input/text', array('name' => 'contact_email', 'id' => 'dossierdepreuve_contact_email', 'value' => $email)) . '</p>';
			*/
			
			// Note : step remain the same until we determine it's done (not here)
			// Système avec onglets : on va directement à la fin du questionnaire
			$step = 'endofquest';
			break;
			
		// FIN DE QUESTIONNAIRE : choix envoi email et/ou maj du dossier de preuve ssi connecté
		case 'endofquest':
			// Pour choix de l'envoi de l'email et/ou alimentation du dossier de suivi avec les infos
			$questionnaire .= '<p><strong>' . elgg_echo('dossierdepreuve:results:done') . '</strong></p>';
			// Les résultats du test d'autopositionnement
			if (in_array($step, array('endofquest', 'final'))) {
				$questionnaire .= '<h3>' . elgg_echo('dossierdepreuve:results:title') . '</h3>';
				$questionnaire .= '<div id="questionnaire-report-accordion">' . $questionnaire_report . '</div>';
			}
			// MAJ de son dossier : ssi connecté
			if (elgg_is_logged_in()) {
				$questionnaire .= '<h3>' . elgg_echo('dossierdepreuve:results:updatedata') . '</h3>';
				/*
				$questionnaire .= "<p>Vous pouvez utiliser ces données pour mettre à jour votre dossier de suvi (partie autopositionnement).</p>";
				$questionnaire .= '<p><label for="dossierdepreuve_update_dossier">' . elgg_echo('dossierdepreuve:auto:update_dossier') . ' ' . elgg_view('input/dropdown', array('name' => 'update_dossier', 'options_values' => $update_dossier_opt, 'id' => 'dossierdepreuve_update_dossier', 'value' => $update_dossier)) . '</p>';
				*/
				// @TODO : récupérer le dossier en cours.. ou pas car c'est fait dans le formulaire d'édition 
				// (par défaut ou si le guid fourni est invalide on récupère le dossier en cours)1
				$edit_url = $vars['url'] . 'dossierdepreuve/edit/' . $dossierdepreuve->guid;
				$autopositionnement_data = urlencode(serialize($_SESSION['dossierdepreuve']->history_data['history']));
				// Pb du bouton avec confirmation : ça masque les résultats ! (pb de jquery ?)
				// $questionnaire .= elgg_echo('dossierdepreuve:results:updatedatatitle') . '<br /><br /><a target="_blank" class="elgg-button elgg-button-action" onclick="return confirm(\'' . elgg_echo('dossierdepreuve:results:updatedata:confirm') . '\');" href="' . $edit_url . '?update_autopositionnement=true&autopositionnement_data=' . $autopositionnement_data . '">' . elgg_echo('dossierdepreuve:results:updatedatalink:newwindow') . '</a>';
				$questionnaire .= elgg_echo('dossierdepreuve:results:updatedatatitle') . '<br /><br /><a target="_blank" class="elgg-button elgg-button-action" href="' . $edit_url . '?update_autopositionnement=true&autopositionnement_data=' . $autopositionnement_data . '">' . elgg_echo('dossierdepreuve:results:updatedatalink:newwindow') . '</a>';
				$questionnaire .= '<div class="clearfloat"></div><br /><br />';
			}
			$questionnaire .= '<h3>' . elgg_echo('dossierdepreuve:results:sendbymail') . '</h3>';
			$questionnaire .= '<p>' . elgg_echo('dossierdepreuve:results:sendbymail:help') . '</p>';
			// Saisie de l'EMail
			$questionnaire .= '<p><label for="dossierdepreuve_contact_email">' . elgg_echo('dossierdepreuve:auto:contact_email') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:auto:contact_email:help') . elgg_view('input/text', array('name' => 'contact_email', 'id' => 'dossierdepreuve_contact_email', 'value' => $email)) . '</p>';
			//$questionnaire .= elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:sendonly")));
			/*
			// Choix d'envoyer un email
			$questionnaire .= '<p><label for="dossierdepreuve_send_email">' . elgg_echo('dossierdepreuve:auto:send_email') . ' ' . elgg_view('input/dropdown', array('name' => 'send_email', 'options_values' => $send_email_opt, 'id' => 'dossierdepreuve_send_email', 'value' => $send_email)) . '</p>';
			*/
			$step = 'final'; // Set next step = finalise
			break;
			
		// FINAL : ENVOI DES DONNES ET MAJ
		case 'final':
			system_message("Autopositionnement terminé !");
			// Send mail
			if ($email) {
				// @TODO : améliorable
				$msg_from = $CONFIG->sitename . ' <' . $CONFIG->email . '>';
				$msg_subject = elgg_echo('dossierdepreuve:msg:subject');
				$msg_content = '';
				$msg_content .= '<p>' . elgg_echo('dossierdepreuve:msg:message') . '</p>';
				$msg_content .= $questionnaire_report;
				$msg_content .= '<hr /><p>' . elgg_echo('dossierdepreuve:msg:restoredata') . '<hr />' . serialize($history_data) . '<hr />';
				$msg_content .= '<p>' . elgg_echo('dossierdepreuve:msg:thanks') . ' ' . $CONFIG->url . '</p>';
				$msg_params = null;
				$emails = str_replace(' ', '', $email);
				$emails = str_replace(array(',', '|', "\n", "\r"), ';', $emails);
				$emails = explode(';', $emails);
				if (!is_array($emails)) $emails[] = $email;
				error_log(print_r($emails, true));
				foreach ($emails as $mail) {
					$mail = trim($mail);
					if (!empty($mail)) {
						error_log("Mail : $mail");
						if (is_email_address($mail)) {
							if (elgg_send_email($msg_from, $mail, $msg_subject, $msg_content, $msg_params)) {
								system_message(elgg_echo('dossierdepreuve:msg:success', array($mail)));
							} else register_error(elgg_echo('dossierdepreuve:msg:error', array($mail)));
						} else register_error(elgg_echo('dossierdepreuve:msg:invalidmail', array($mail)));
					}
				}
			}
			// Update dossierdepreuve
			if ($update_dossier) {
				// @TODO
				//system_message("Dossier de suivi mis à jour !");
				//register_error("La mise à jour du dossier de suivi n'est pas encore fonctionnelle !");
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
				$questionnaire .= elgg_echo('dossierdepreuve:results:updatedatatitle') . ' <a href="' . $edit_url . '?update_autopositionnement=true&autopositionnement_data=' . $autopositionnement_data . '" class="elgg-button elgg-button-action">' . elgg_echo('dossierdepreuve:results:updatedatalink') . '</a>';
				$questionnaire .= '<div class="clearfloat"></div><br />';
			}
			$step = 'clearall'; // Set next step = erase session data and go to start
			break;
		
		// SELECTION DES DOMAINES A EVALUER
		case 'selection':
			$questionnaire .= elgg_echo('dossierdepreuve:domaineselection');
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
			$questionnaire .= '<p>' . elgg_echo('dossierdepreuve:auto:datacleared') . '</p>';
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
			$questionnaire_info .= '<br /><p>' . elgg_echo('dossierdepreuve:auto:description') . '</p>';
			// Global info about questionnaire
			$questionnaire_info .= '<div class="elgg-module elgg-module-info"><div class="elgg-head"> </div><div class="elgg-body"><p style="padding:0 8px;">' . elgg_echo('dossierdepreuve:auto:public:disclaimer') . '</p></div></div>';
			// Public mode : we can't save data nor update dossierdepreuve object
			if (!elgg_is_logged_in()) {
				$questionnaire_info .= '<blockquote>' . elgg_echo('dossierdepreuve:auto:warning') . '</blockquote>';
				//system_messages(elgg_echo('dossierdepreuve:auto:warning'), 'notice');
			}
			// Choix du questionnaire
			$questionnaire .= '<p>' . elgg_echo('dossierdepreuve:domaineselection:help') . elgg_view('input/hidden', array('name' => 'auto_type', 'id' => 'dossierdepreuve_auto_type', 'value' => 'full')) . '</p>';
			//$questionnaire .= '<p><label for="dossierdepreuve_auto_type">' . elgg_echo('dossierdepreuve:auto_type') . '</label> &nbsp; ' . elgg_view('input/radio', array('name' => 'auto_type', 'id' => 'dossierdepreuve_auto_type', 'options' => $auto_type_opt, 'value' => $auto_type)) . '</p>';
			$questionnaire_help .= elgg_echo('dossierdepreuve:auto_type:help');
			// Note : step will be determined through this question
			break;
	}
	
	
	// COMPOSITION DU CONTENU DU QUESTIONNAIRE
	
	// Des informations qui sont affichées tout au long du questionnaire
	echo '<div>' . $questionnaire_info . '</div><br />';
	
	// Affichage de la partie du questionnaire en cours
	if (!empty($questionnaire) || !empty($tabcontent)) {
		
		echo '<div id="autopositionnement_quest_tabs">' . $questionnaire_step . '<div class="clearfloat"></div></div>';
		
		echo '<div id="autopositionnement_quest_tab_content_wrapper">';
		
		// Contenu du questionnaire
		echo $tabcontent;
		
		// Pour les éléments présents indépendament du contenu du questionnaire
		if (!empty($questionnaire) && !empty($questionnaire_help)) { echo '<div style="width:66%; float:left; margin-left:">'; }
		// Le contenu du questionnaire (à cette étape)
		echo $questionnaire;
		if (!empty($questionnaire) && !empty($questionnaire_help)) { echo '</div><div style="width:30%; float:right; border:1px dashed grey; padding:1%;">'; }
		// L'aide associée (vidéo, texte, image)
		echo $questionnaire_help;
		if (!empty($questionnaire) && !empty($questionnaire_help)) { echo '</div>'; }
		echo '<div class="clearfloat"></div>';
		
		echo '</div><br />';
	}
	
	// Email pour l'envoi des résultats
	if ($questionnaire_email) echo '<div>' . $questionnaire_email . '</div><br />';
	
	
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
	echo $submit_button;
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
	if (empty($step) || ( ($step != 'clearall') && ($step != 'start') ) ) {
		echo '<form enctype="multipart/form-data" method="post" style="float:right;">
			<input type="hidden" name="step" value="clearall" />
			<br />
			<p>' . elgg_view('input/submit', array('value' => elgg_echo('dossierdepreuve:auto:clearandrestart'), 'class' => 'elgg-button-delete elgg-requires-confirmation', 'rel' => elgg_echo('dossierdepreuve:auto:clear:confirm'))) . '</a></p>
			</form>';
	}
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

