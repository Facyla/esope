<?php
/**
 * Save serialized project data
 *
 * @package ElggPages
 */

project_manager_gatekeeper();
// Seuls les manager peuvent gérer globalement les notes de frais
project_manager_manager_gatekeeper();
action_gatekeeper();

// Give access to all users, data, etc.
$ia = elgg_set_ignore_access(true);

// Données stockées hors de la structure (structure = $project->project_expenses[$member_guid][$id][$data] )
$expenses_vars = array('date', 'objet', 'frais_local', 'devise', 'taux', 'frais', 'deduc_tva', 'status');
// Autres données passées mais non conservées : action, user_guid, project_guid, prev_project_guid
// Get input data : expenses[$id][$data] (y compris $project_guid et $user_guid)
$input_expenses = get_input('expenses', false);
// L'id permet éventuellement de gérer les membres sur chaque saisie, plutôt que globalement pour permettre les éditions globales par les managers
$read_error_count = 0;
$save_error_count = 0;

if ($input_expenses) {
	//error_log("DEBUG expenses : start");
	
	// 1. ON ORGANISE LES DONNÉES DIFFÉREMMENT (PAR PROJET PUIS PAR MEMBRE)
	$projects = array();
	foreach ($input_expenses as $id => $expenses) {
		// id : unique (pour chaque membre) : timestamp + ordre de saisie
		// Projet affecté
		$project_guid = $expenses['project_guid'];
		$prev_project_guid = $expenses['prev_project_guid'];
		// Auteur de la note de frais
		$user_guid = $expenses['user_guid'];
		// Si membre non précisé, on peut le déduire de l'id
		if (empty($user_guid)) {
			$user_guid = explode('_', $id);
			$user_guid = $user_guid[1];
		}
		// Si projet non précisé => non-affecté par défaut (mais membre nécessaire)
		if (empty($project_guid) && !empty($expenses['user_guid']) && !empty($expenses['objet']) && !empty($expenses['frais_local'])) $project_guid = $user_guid;
		
		// Suppression saisies refusées ou à supprimer
		if ($expenses['status'] == 'delete') {
			$remove_data[$prev_project_guid][] = $id;
			//error_log("TO DELETE : $prev_project_guid => $id;");
		}
		
		if (!empty($project_guid) && !empty($user_guid)) {
			// Valeurs numériques : sans virgule ni espace
			$expenses['frais_local'] = str_replace(array(',', ' '), array('.', ''), $expenses['frais_local']);
			$expenses['deduc_tva'] = str_replace(array(',', ' '), array('.', ''), $expenses['deduc_tva']);
			
			// Calcul des frais par rapport à la devise choisie
			if (!empty($expenses['frais_local']) && !empty($expenses['devise']) && ($expenses['devise'] != 'EUR')) {
				// Calcul taux : 1€ = X devise
				$expenses['taux'] = project_manager_convert_toeuro(1, $expenses['devise']);
				// Conversion : inverse taux
				$expenses['frais'] = $expenses['frais_local'] / $expenses['taux'];
			} else $expenses['frais'] = $expenses['frais_local'];
			
			// On conserve les données modifiées qui vont servir à mettre à jour les saisies
			$data[$project_guid][$user_guid][$id] = $expenses;
//error_log("DEBUG expenses : $project_guid - $user_guid - $id");
			
			// Liste des projets / saisies perso à modifier - pour limiter (un peu) les requêtes
			if (!in_array($project_guid, $projects)) $projects[] = $project_guid;
			
			// Liste des saisies à supprimer si changement d'affectation vers un autre projet
			if (!empty($prev_project_guid) && ($project_guid != $prev_project_guid)) {
//error_log("DEBUG expenses : todelete = $prev_project_guid > $project_guid - $user_guid - $id");
				// Note : il suffit de connaître le projet d'origine et l'id de la saisie
				$remove_data[$prev_project_guid][] = $id;
				// Ajout des anciens projets à la liste des projets à mettre à jour
				if (!in_array($prev_project_guid, $projects)) $projects[] = $prev_project_guid;
			}
			
			/*
			// Liste des saisies à supprimer si changement d'affectation vers un autre membre
			if (!empty($prev_user_guid) && ($user_guid != $prev_user_guid)) {
error_log("DEBUG expenses : todelete = $prev_user_guid > $user_guid - $project_guid - $id");
				// Note : il suffit de connaître le projet d'origine et l'id de la saisie
				$remove_data[$prev_project_guid][] = $id;
				// Ajout des anciens projets à la liste des projets à mettre à jour
				if (!in_array($prev_project_guid, $projects)) $projects[] = $prev_project_guid;
			}
			*/
			
		} else $read_error_count++;
	}
	
	
	// 2. POUR CHAQUE PROJET POUR LEQUEL ON A DES DONNÉES + LES MEMBRES (FRAIS NON AFFECTÉS)
	//$projects[] = $user_guid;
	foreach ($projects as $project_guid) {
		$project = get_entity($project_guid);
		
		// DEBUG seulement Supprime *toutes* les données des frais liées à ce projet
		//$project->project_expenses = '';
		
		// a) Récupération ou création des données des frais professionnels du projet
		$project_expenses_data = unserialize($project->project_expenses);
		
		// b) Si changement d'affectation vers un autre projet : suppression des saisies sur l'ancien projet
		if (is_array($remove_data[$project_guid])) foreach ($remove_data[$project_guid] as $id) {
			$member_guid = explode('_', $id); $member_guid = $member_guid[1];
			if (!empty($member_guid)) {
				unset($project_expenses_data[$member_guid][$id]);
//error_log(" - deleted : $prev_project_guid / $member_guid => $id;");
			} else {
				error_log("DEBUG expenses : pb suppression ancienne valeur : id = $id");
				//$save_error_count++;
			/*
				// Si on ne connait pas le $member_guid, on peut toujours chercher l'id
				// @TODO : voir si on le garde vraiment => pas optimisé du tout..
				foreach ($project_expenses_data as $member_guid => $member_expenses) {
					foreach ($member_expenses as $in_id => $expenses) {
						if ($in_id == $id) unset($project_expenses_data[$member_guid][$id]);
					}
				}
			*/
			}
		}
		
		// c) Ajout / mise à jour des saisies pour ce projet
		// Pour chaque membre dont il faut modifier les données
		if (is_array($data[$project_guid])) foreach ($data[$project_guid] as $member_guid => $member_expenses) {
			
			// Pour chaque saisie à modifier de ce membre
			if (is_array($member_expenses)) foreach ($member_expenses as $id => $expenses) {
				
				// Si l'action est l'une de celle demandée => Action = Création / modification / manager
				if (in_array($expenses['action'], array('create', 'update', 'manager'))) {
					// Pour chacun des champs de la note de frais : création ou MAJ des valeurs
					foreach ($expenses_vars as $var) {
						// Exclusion des champs spéciaux et de structure
						if (!in_array($var, array('action', 'prev_project_guid', 'user_guid', 'project_guid'))) 
						$project_expenses_data[$member_guid][$id][$var] = $expenses[$var];
					}
					// Ajout année et mois pour sélections plus faciles ?
					// non: plus simple de couper la date sur un '-'
				// Suppression / Action = delete
				} else if (($expenses['action'] == 'delete')) {
					unset($project_expenses_data[$member_guid][$id]);
				} else $save_error_count++;
				if ($expenses['status'] == 'delete') {
					unset($project_expenses_data[$member_guid][$id]);
					//error_log("DEBUG delete expenses : $member_guid => $id");
				}
				
			}
			// Erreurs : suppression si les membres n'existent pas
			/*
			if ($test = get_entity($member_guid)) {} else {
				unset($project_expenses_data[$member_guid]);
			}
			*/
			
		}
		
		// d) Enregistrement des nouvelles données du projet
		$project_expenses_data = serialize($project_expenses_data);
		$project->project_expenses = $project_expenses_data;
	}
	
	if (empty($read_error_count) && empty($save_error_count)) {
		system_message(elgg_echo('project_manager:saved:ok'));
	} else {
		$msg = elgg_echo('expenses:error:readwrite', array($read_error_count, $save_error_count));
		register_error($msg);
	}
	
	// Return ajax data
	echo json_encode(array(
			"result" => "true", 
		));
	
} else {
	elgg_set_ignore_access($ia);
	register_error(elgg_echo('project_manager:error:nodata'));
	forward(REFERER);
}

elgg_set_ignore_access($ia);
forward(REFERER);

exit();

