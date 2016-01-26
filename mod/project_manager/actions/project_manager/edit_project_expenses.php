<?php
/**
 * Save serialized project data
 *
 * @package ElggPages
 */

project_manager_gatekeeper();
action_gatekeeper();

// @TODO : bloquer toute modification de la part des consultants sur les saisies déjà validées // exception si manager ou admin
$is_manager = project_manager_manager_gatekeeper(false, true, false);


// Give access to all users, data, etc.
$ia = elgg_set_ignore_access(true);


// @TODO ??? : modifier structure de données pour avoir, pour chaque projet : [$year][$month][$member_guid] ???

$expenses_vars = array('action', 'date', 'objet', 'frais_local', 'devise', 'taux', 'frais', 'deduc_tva', 'status', 'user_guid');
// $input_expenses['id'][$var] = $value;
$input_expenses = get_input('expenses', false);
// @TODO : gérer les membres sur chaque saisie, via l'id, plutôt que globalement pour permettre les éditions globales par les managers
$own = $_SESSION['user'];
$ownguid = $own->guid;

// On modifie si le membre en a le droit (soi-même ou admin)
//if ($input_expenses && ($user->canEdit() || $is_manager)) {
if ($input_expenses) {
	
	// 1. ON ORGANISE LES DONNÉES DIFFÉREMMENT (PAR PROJET)
	$projects = array();
	foreach ($input_expenses as $id => $expenses) {
		$user_guid = $expenses['user_guid'];
		error_log("Nouvelle saisie expenses project action : $user_guid");
		//if ($input_expenses && ($user->canEdit() || $is_manager)) {}

		// id : unique (pour chaque membre) : timestamp + ordre de saisie
		$project_guid = $expenses['project_guid'];
		// Si projet non précisé => non-affecté par défaut
		if (empty($project_guid) && !empty($expenses['objet']) && !empty($expenses['frais_local'])) $project_guid = $user_guid;
		if (!empty($project_guid)) {
			
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
			
			// On conserve les données modifiées qui vont servir à mettre à jour els saisies
			$data[$project_guid][$id] = $expenses;
			
			// Liste des projets / saisies perso à modifier
			if (!in_array($project_guid, $projects)) $projects[] = $project_guid;
			
			// Liste des saisies à supprimer si changement d'affectation vers un autre projet
			if (isset($expenses['prev_project_guid'])) $prev_project_guid = $expenses['prev_project_guid'];
			if (!empty($prev_project_guid)) {
				// Ajout des anciens projets à la liste
				if (!in_array($prev_project_guid, $projects)) $projects[] = $prev_project_guid;
				//if ($prev_project_guid != $project_guid) 
				$remove_data[$prev_project_guid][] = $id;
			}
			
		}
	}
	
	
	// 2. POUR CHAQUE PROJET POUR LEQUEL ON A DES DONNÉES + LE MEMBRE (FRAIS NON AFFECTÉS)
	//$projects[] = $user_guid;
	foreach ($projects as $project_guid) {
		$project = get_entity($project_guid);
		
		// DEBUG seulement Supprime *toutes* les données des frais liées à ce projet
		//$project->project_expenses = '';
		
		// a) Récupération ou création des données des frais professionnels du projet
		$project_expenses = unserialize($project->project_expenses);
		if (isset($project_expenses[$user_guid])) $user_expenses = $project_expenses[$user_guid];
		else $user_expenses = array();
		
		// b) Suppression des anciennes saisies si changement d'affectation vers un autre projet
		if (is_array($remove_data[$project_guid])) foreach ($remove_data[$project_guid] as $id) {
			$id_parts = explode('_', $id); $member_guid = $id_parts[1];
			// Suppression seulement si non validé, ou si manager
			if ($is_manager || ($project_expenses[$member_guid][$id]['status'] != 'validated')) unset($project_expenses[$member_guid][$id]);
		}
		
		// c) Ajout / mise à jour des saisies pour ce projet
		if (is_array($data[$project_guid])) foreach ($data[$project_guid] as $id => $expenses) {
			$id_parts = explode('_', $id); $member_guid = $id_parts[1];
			$user_guid = $expenses['user_guid'];
			if (!empty($user_guid)) {
				$member_guid = $user_guid;
				$id_parts[1] = $user_guid;
				$id = implode('_', $id_parts);
			}
			// Edition seulement si non validé, ou si manager
			if ($is_manager || ($project_expenses[$member_guid][$id]['status'] != 'validated')) {
				// Action = Création / modification / manager
				if (in_array($expenses['action'], array('create', 'update', 'manager')) && (!is_array($project_expenses[$member_guid]) || !in_array($id, $project_expenses[$member_guid]))) {
					// Pour chacun des champs d'une note de frais
					foreach ($expenses_vars as $var) {
						if (!in_array($var, array('action', 'prev_project_guid'))) 
						$project_expenses[$member_guid][$id][$var] = $expenses[$var];
					}
					/* @TODO ?
					// Ajout année et mois pour sélections plus faciles (mieux que le timestamp ?)
					$project_expenses[$member_guid][$id]['year'] = date('Y', $expenses['date']);
					$project_expenses[$member_guid][$id]['month'] = date('Y', $expenses['month']);
					*/
					
				// Suppression / Action = delete
				} else if (($expenses['action'] == 'delete')) {
					unset($project_expenses[$member_guid][$id]);
				}
			}
		}
		
		// d) Enregistrement des nouvelles données du projet
		$project_expenses = serialize($project_expenses);
		$project->project_expenses = $project_expenses;
	}
	
	system_message(elgg_echo('project_manager:saved:ok'));
	
	// Return ajax data
	echo json_encode(array(
			"result" => "true", 
		));
} else {
	elgg_set_ignore_access($ia);
	register_error(elgg_echo('project_manager:error:invaliduser'));
	forward(REFERER);
}

elgg_set_ignore_access($ia);
forward(REFERER);

exit();

