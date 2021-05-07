<?php
/**
 * Main custom delete page : manual transfer of group and content (cherry-pick mode), or use default settings for automated transfer/delete rules
 */

/* Notes sur les != niveaux de traitement global : global config < custom per user < per type < per owned entity
 - les règles par défaut du plugin prédéfinissent les divers réglages
 - réglage global [action, user]: pour tout, groupes et contenus
 - réglage par type de contenu : pour les groupes, et pour chaque subtype
 - gestion manuelle fine : groupe par groupe et contenu par contenu
*/

elgg_admin_gatekeeper();

$url = elgg_get_site_url();

//elgg_register_title_button('content_lifecycle', 'add', 'object', 'content_lifecycle');
elgg_push_breadcrumb(elgg_echo('content_lifecycle:index'), 'content_lifecycle');

$content = '';

$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

$rule_default_opt = ['' => '', 'transfer' => elgg_echo('option:transfer'), 'delete' => elgg_echo('option:delete')];
$rule_groups_opt = ['' => '', 'transfer' => elgg_echo('option:transfer'), 'delete' => elgg_echo('option:delete')];
$rule_objects_opt = ['' => '', 'transfer' => elgg_echo('option:transfer'), 'delete' => elgg_echo('option:delete')];

$action_mode_opt = ['' => 'Ne rien faire (conserve les options choisies)', 'simulate' => "Simulation", 'execute' => "Applique les options et supprime le compte"];

$entity_types = get_registered_entity_types();
$object_subtypes_opt = [];
foreach($entity_types as $type => $entity_subtypes) {
	if ($type == 'object') {
		$object_subtypes = $entity_subtypes;
		break;
	}
}
$new_owner_opt = [];


// PARAMETRES */
// Mode de fonctionnement
$action_mode = get_input('action_mode');

// User to delete
$guid = get_input('guid');
if (is_array($guid)) { $guid = $guid[0]; }

// Nouveau propriétaire : du général ou particulier
$new_owner_default = get_input('new_owner_default'); // Par défaut
if (is_array($new_owner_default)) { $new_owner_default = $new_owner_default[0]; }
$new_owner_groups = get_input('new_owner_groups'); // (int) Pour les groupes (GUID)
$new_owner_objects = get_input('new_owner_objects'); // (array) Par subtype d'object (array of GUID)
$new_owner_entities = get_input('new_owner_entities'); // (array) entité par entité (GUID uniquement : peut être un groupe comme un objet)

// Règles : du général ou particulier
$rule_default = get_input('rule_default'); // Par défaut
$rule_groups = get_input('rule_groups'); // Pour les groupes
$rule_objects = get_input('rule_objects'); // Par subtype d'object
$rule_entities = get_input('rule_entities'); // entité par entité (GUID uniquement : peut être un groupe comme un objet)



// EXECUTION DES ACTIONS
if ($guid && in_array($action_mode, ['simulate', 'execute'])) {
	$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($guid) {
		return get_user($guid);
	});
	$new_owner_default_entity = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($new_owner_default) {
		return get_entity($new_owner_default);
	});
	
	$content .= '<h2>Exécution des actions</h2>';
	$content .= '<div class="elgg-output">';
		//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
		//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
		if ($guid === elgg_get_logged_in_user_guid()) {
			$content .= elgg_error_response(elgg_echo('admin:user:self:delete:no'));
		} else if (!$user || !$user->canDelete()) {
				$content .= elgg_error_response(elgg_echo('admin:user:delete:no'));
		} else if (!in_array($rule_default, ['transfer','delete']) || !($new_owner_default_entity instanceof ElggUser || $new_owner_default_entity instanceof ElggGroup || $new_owner_default_entity instanceof ElggSite)) {
		} else {
			$content .= '<ul>';
				$content .= '<li>' . "GUID : $guid" . '</li>';
				$content .= '<li>Utilisateur valide&nbsp;: ' . $user->username . '</li>';
				$content .= '<li>Action par défaut valide&nbsp;: ' . $rule_default_opt[$rule_default] . '</li>';
				$content .= '<li>Nouveau propriétaire par défaut valide&nbsp;: ' . $new_owner_default_entity->username . '</li>';
			$content .= '</ul>';
			
			// Traitement des groupes
			$content .= '<h3>Groupes</h3>';
			// User groups
			$user_owned_groups_count = $user->getGroups(['owner_guid' => $user->guid, 'count' => true]);
			$user_owned_groups = $user->getGroups(['owner_guid' => $user->guid, 'limit' => false]);
			$content .= '<ul>';
				foreach($user_owned_groups as $group) {
					$content .= '<li>';
						$content .= '<a href="' . $group->getUrl() . '" target="_blank">' . elgg_view_entity_icon($group, 'tiny', ['use_link' => false, 'class' => 'float']) . '&nbsp;' . $group->name . ' <i class="fas fa-external-link-alt"></i></a>';
						
						// action
						$content .= " => <strong>action&nbsp;:</strong> (default {$rule_default}, groups {$rule_groups}, this group {$rule_entities[$group->guid]})";
						if (!empty($rule_entities[$group->guid])) {
							$selected_rule = $rule_entities[$group->guid];
						} else if (!empty($rule_groups)) {
							$selected_rule = $rule_groups;
						} else {
							$selected_rule = $rule_default;
						}
						$content .= " <strong>$selected_rule</strong> => ";
						
						// new owner
						$content .= " => <strong>nouveau propriétaire&nbsp;:</strong> (default {$new_owner_default}, groups {$new_owner_groups}, this group {$new_owner_entities[$group->guid]})";
						if (!empty($new_owner_entities[$group->guid])) {
							$selected_new_owner = $new_owner_entities[$group->guid];
						} else if (!empty($new_owner_groups)) {
							$selected_new_owner = $new_owner_groups;
						} else {
							$selected_new_owner = $new_owner_default;
						}
						$selected_new_owner_entity = get_entity($selected_new_owner);
						if (!($selected_new_owner_entity instanceof ElggUser || $selected_new_owner_entity instanceof ElggGroup || $selected_new_owner_entity instanceof ElggSite)) {
							$content .= " => <strong>nouveau propriétaire&nbsp;: invalide</strong>";
						} else {
							$content .= " => <strong>nouveau propriétaire&nbsp;:</strong> {$selected_new_owner_entity->username} (guid {$selected_new_owner_entity->guid}) => ";
							
							// type d'action
							$content .= " <strong>$action_mode</strong>";
							if ($action_mode == 'execute') {
								if ($selected_new_owner != $user->guid) {
									// Ensure new owner if member of the group
									if (!$group->isMember($selected_new_owner_entity)) {
										$content .= " => Nouveau propriétaire pas encore membre du groupe"; // type d'action
										$group->join($selected_new_owner_entity);
									}
									// verify new owner is member
									if ($group->isMember($selected_new_owner_entity)) {
										$content .= " => Nouveau propriétaire membre du groupe"; // type d'action
										$group->owner_guid = $selected_new_owner;
										if ($group->container_guid == $user->guid) {
											// Even though this action defaults container_guid to the logged in user guid,
											// the group may have initially been created with a custom script that assigned
											// a different container entity. We want to make sure we preserve the original
											// container if it the group is not contained by the original owner.
											$group->container_guid = $selected_new_owner;
										}
										if ($group->save()) {
											$content .= " => <strong>OK !</strong>";
										}
									} else {
										$content .= " => <strong>Impossible de transférer : le nouveau propriétaire n'est pas membre du groupe (et n'a pas pu le rejoindre) !</strong>"; // type d'action
									}
								} else {
									$content .= " => <strong>Impossible de transférer au compte qui va être supprimé !</strong>"; // type d'action
								}
							} else {
								$content .= " => <strong>Aucune action effectuée !</strong>";
							}
						}
					$content .= '</li>';
				}
			$content .= '</ul>';
			
			// Traitement des contenus
			$content .= '<h3>Contenus</h3>';
			$content .= '<ul>';
				foreach($object_subtypes as $subtype) {
					$content .= '<li>' . $subtype . '&nbsp;: ';
						$user_objects = $user->getObjects(['type' => 'object', 'subtype' => $subtype, 'limit' => false]);
						if (count($user_objects) > 0) {
							$content .= '<ul>';
								foreach($user_objects as $object) {
									$content .= '<li>';
										$content .= "<strong>{$object->guid} {$object->title}</strong> ";
										// action
										$content .= " => <strong>action&nbsp;:</strong> (default {$rule_default}, this subtype {$rule_objects[$subtype]}, this object {$rule_entities[$object->guid]})";
										if (!empty($rule_entities[$object->guid])) {
											$selected_rule = $rule_entities[$object->guid];
										} else if (!empty($rule_objects[$subtype])) {
											$selected_rule = $rule_objects[$subtype];
										} else {
											$selected_rule = $rule_default;
										}
										$content .= " <strong>$selected_rule</strong> => "; // action
										
										// new owner
										$content .= " => <strong>nouveau propriétaire&nbsp;:</strong> (default {$new_owner_default}, this subtype {$new_owner_objects[$subtype][0]}, this object {$new_owner_entities[$object->guid]})";
										if (!empty($new_owner_entities[$object->guid])) {
											$selected_new_owner = $new_owner_entities[$object->guid];
										} else if (!empty($new_owner_objects[$subtype][0])) {
											$selected_new_owner = $new_owner_objects[$subtype][0];
										} else {
											$selected_new_owner = $new_owner_default;
										}
										$selected_new_owner_entity = get_entity($selected_new_owner);
										if (!($selected_new_owner_entity instanceof ElggUser || $selected_new_owner_entity instanceof ElggGroup || $selected_new_owner_entity instanceof ElggSite)) {
											$content .= " => <strong>nouveau propriétaire&nbsp;: invalide</strong>"; // new owner
										} else {
											$content .= " => <strong>nouveau propriétaire&nbsp;:</strong> {$selected_new_owner_entity->username} (guid {$selected_new_owner_entity->guid}) => ";
											
											// type d'action
											$content .= " <strong>$action_mode</strong>";
											if ($action_mode == 'execute') {
												$object->owner_guid = $selected_new_owner;
												if ($object->container_guid == $user->guid) {
													$object->container_guid = $selected_new_owner;
												}
												if ($object->save()) {
													$content .= " => <strong>OK !</strong>";
												}
											} else {
												$content .= " => <strong>Aucune action effectuée !</strong>";
											}
										}
									$content .= '</li>';
								}
							$content .= '</ul>';
						} else {
							$content .= "Aucun contenu de ce type";
						}
					$content .= '</li>';
				}
			$content .= '</ul>';
			
			// Suppression du compte
			$content .= '<h3>Suppression du compte</h3>';
			// @TODO : on doit d'abord s'assurer que tout ce qui devait être transféré l'a bien été (soit on note les erreurs, soit on vérifie a posteriori)
			// type d'action
			$content .= " <strong>$action_mode</strong>";
			$user->account_lifecycle = "delete_now"; // Add flag to avoid hook from intercepting delete action
			if ($action_mode == 'execute') {
				$deleted = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($user) {
					return $user->delete();
				});
				if (!$deleted) {
					$content .= elgg_echo('admin:user:delete:no');
				} else {
					$content .= " => <strong>OK !</strong>";
				}
			} else {
				$content .= " => <strong>Aucune action effectuée !</strong>";
			}
			
		}
	$content .= '<div>';
}



/* FORMULAIRE */
if ($guid) {
	$content .= '<h2>Gestion des contenus lors de la suppression du compte</h2>';
	$content .= '<p>' . "GUID : $guid" . '</p>';
	//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
	//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
	if ($guid === elgg_get_logged_in_user_guid()) {
		$content .= elgg_error_response(elgg_echo('admin:user:self:delete:no'));
	} else {
		$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($guid) {
			return get_user($guid);
		});
		if (!$user || !$user->canDelete()) {
			$content .= elgg_error_response(elgg_echo('admin:user:delete:no'));
		} else {
			// User groups
			$user_owned_groups_count = $user->getGroups(['owner_guid' => $user->guid, 'count' => true]);
			$user_owned_groups = $user->getGroups(['owner_guid' => $user->guid, 'limit' => false]);
			
			$content .= '<div style="display: flex; flex-wrap: wrap;">';
				
				$content .= '<div style="flex: 1 1 30rem; margin: 0 1rem 1rem 1rem;">';
					// Informations générales
					$content .= elgg_view('content_lifecycle/user_delete_notice', ['user' => $user]);
					
					// Formulaire de sélection
					
					// MODE SIMPLE ET GLOBAL - PARAMETRES PAR DEFAUT
					$content .= '<form method="GET", action="">';
						
						$content .= '<p><label>Mode de fonctionnement<br />' . elgg_view('input/select', ['name' => "action_mode", 'value' => $action_mode, 'options_values' => $action_mode_opt, 'required' => true]) . '</label></p>';
						$content .= '<br />';
						
						// Origin
						$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
							$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Utilisateur à supprimer" . '</legend>';
							$content .= '<div>' . elgg_view('input/userpicker', ['name' => "guid", 'value' => $guid, 'limit' => 1, 'required' => true]) . '</div>';
						$content .= '</fieldset>';
						
						// Default Action
						$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
							$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Action par défaut" . '</legend>';
							$content .= '<div><label>Action à effectuer par défaut<br />' . elgg_view('input/select', ['name' => "rule_default", 'value' => $rule_default, 'options_values' => $rule_default_opt, 'required' => true]) . '</label></div>';
						$content .= '</fieldset>';
						
						// Default Destination : par défaut, si non overridé dans les réglages suivants
						$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
							$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Nouveau propriétaire par défaut" . '</legend>';
							$content .= '<div>' . elgg_view('input/userpicker', ['name' => "new_owner_default", 'value' => $new_owner_default, 'limit' => 1, 'required' => true]) . '<em>' . "Tous les transferts seront faits vers ce compte utilisateur. Il est possible de définir d'autres comptes utilisateurs pour chacun des types de contenu." . '</em></div>';
						$content .= '</fieldset>';
						
						$content .= '<p>' . elgg_view('input/submit', ['value' => "MODE SIMPLE - Appliquer ces actions"]) . '</p>';
						$content .= '<p><em>' . "Le mode simple permet d'appliquer les options de transfert prédéfinies. Si vous le souhaitez, vous pouvez utiliser les réglages ci-après pour définir de manière plus fine ce qui doit être transféré ou supprimer, et à qui." . '</em></p>';
						$content .= '<br />';
						
						
						// MODE AVANCE - PARAMETRES POUR LES GROUPES ET PAR TYPE DE CONTENU
						// Owned groups
						$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;" class="elgg-output">';
							$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Groupes (propriétaire)" . '</legend>';
							// Action
							$content .= '<p><label>Action à effectuer ' . elgg_view('input/select', ['name' => "rule_groups", 'value' => $rule_groups, 'options_values' => $rule_groups_opt]) . '</label></p>';
							
								// MODE MANUEL - ENTITE PAR ENTITE
							// Liste des groupes
							if ($user_owned_groups_count > 0) {
								if ($user_owned_groups_count > 1) {
									$user_groups_title = '<p>' . $user_owned_groups_count . ' groupes concernés</p>';
								} else {
									$user_groups_title = '<p>' . $user_owned_groups_count . ' groupe concerné</p>';
								}
								$user_groups .= '<p><em>Pour transférer chaque groupe à un compte utilisateur différent, veuillez utiliser les liens ci-dessous pour modifier le propriétaire du groupe.</em></p>';
								$user_groups .= '<ul>';
								foreach($user_owned_groups as $group) {
									//$content .= '<li><a href="' . $group->getUrl() . '" target="_blank">' . elgg_view_entity_icon($group, 'tiny', ['use_link' => false, 'class' => 'float']) . '&nbsp;' . $group->name . ' <i class="fas fa-external-link-alt"></i></a></li>';
									$user_groups .= '<li><a href="' . elgg_get_site_url() . 'groups/edit/' . $group->guid . '" target="_blank">' . elgg_view_entity_icon($group, 'tiny', ['use_link' => false, 'class' => 'float']) . '&nbsp;' . $group->name . ' <i class="fas fa-external-link-alt"></i></a></li>';
								}
								$user_groups .= '</ul>';
								$content .= elgg_view_module('info', $user_groups_title, $user_groups);
							} else {
								$content .= '<p>Aucun groupe&nbsp;: sans objet</p>';
							}
						$content .= '</fieldset>';
						
						// Owned objects
						// 1 selector for each subtype, with the desired action and targets (in groups / outside group)
						foreach($object_subtypes as $subtype) {
							//$content .= "$type > $subtype<br />";
							$object_subtypes_opt[$subtype] = $subtype;
							$user_objects_count = $user->getObjects(['type' => 'object', 'subtype' => $subtype, 'count' => true]);
							
							$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0; display: flex; flex-wrap: wrap; justify-content: space-around;">';
								$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . $subtype . '</legend>';
								if ($user_objects_count > 0) {
									// Stats
									if ($user_objects_count > 1) {
										$user_objects_title = $user_objects_count . ' éléments concernés';
									} else {
										$user_objects_title = $user_objects_count . ' élément concerné';
									}
									
									// Action
									$content .= '<div><label>Action à effectuer<br />' . elgg_view('input/select', ['name' => "rule_objects[{$subtype}]", 'value' => $rule_objects[$subtype], 'options_values' => $rule_objects_opt]) . '</label></div>';
									
									// New owner
									//$content .= '<p><label>Nouveau propriétaire ' . elgg_view('input/select', ['name' => "new_owner[{$subtype}]", 'value' => $new_owner_objects[$subtype], 'options_values' => $new_owner_opt]) . '</label></p>';
									$content .= '<div><label>Nouveau propriétaire</label> ' . elgg_view('input/userpicker', ['name' => "new_owner_objects[{$subtype}]", 'value' => $new_owner_objects[$subtype], 'limit' => 1]) . '</div>';
									
									$content .= '<div style="flex: 1 1 100%;">';
										$user_objects = elgg_list_entities(['type' => 'object', 'subtype' => $subtype, 'owner_guid' => $guid]);
										$content .= elgg_view_module('info', $user_objects_title, $user_objects);
									$content .= '</div>';
								} else {
									$content .= 'Aucun élément&nbsp;: sans objet';
								}
							$content .= '</fieldset>';
						}

						// Owned objects : specify 2 targets, as may be contained in groups (options : specific user, group owner, group itself), or outside groups (options : specific user, specific group, site itself?)
						/*
						$content .= '<p><label>Types de Contenus à transférer (le cas échéant) ' . elgg_view('input/select', ['name' => "object_subtypes", 'value' => $object_subtypes, 'options_values' => $object_subtypes_opt, 'multiple' => true]) . '</label><br /><em>Maintenir la touche Ctrl appuyée pour sélectionner plusieurs types de contenus.</em></p>';
						$content .= '<p><label>Action à effectuer pour les Contenus ' . elgg_view('input/select', ['name' => "rule_objects", 'value' => $rule_objects, 'options_values' => $rule_objects_opt]) . '</label></p>';
						*/
						
						$content .= '<p>' . elgg_view('input/submit', ['value' => elgg_echo('execute')]) . '</p>';
					$content .= '</form>';
					
				$content .= '</div>';
				
				
				// Informations détaillées sur le compte utilisateur
				$content .= '<div style="flex: 1 1 30rem; margin: 0 1rem 1rem 1rem;">';
					$content .= elgg_view('content_lifecycle/user_details', ['user' => $user]);
				$content .= '</div>';
				
			$content .= '</div>';
		}
	}
} else {
	// Formulaire de sélection initial (équivalent de User > Admin > Supprimer)
	$content .= '<p>' . "Pas de compte sélectionné." . '</p>';
	$content .= '<form method="GET", action="">';
		// Origin
		$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
			$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Utilisateur à supprimer" . '</legend>';
			$content .= '<div><label>Utilisateur à supprimer</label>' . elgg_view('input/userpicker', ['name' => "guid", 'value' => $guid, 'limit' => 1]) . '</div>';
		$content .= '</fieldset>';
		$content .= '<p>' . elgg_view('input/submit', ['value' => "Sélectionner ce compte"]) . '</p>';
	$content .= '</form>';
}



// SIDEBAR
//$sidebar .= '<div></div>';


// Sidebar droite
$sidebar_alt .= '';



echo elgg_view_page($title, [
	'title' => elgg_echo('content_lifecycle:index'),
	'content' =>  $content,
	//'sidebar' => $sidebar,
	//'sidebar_alt' => $sidebar_alt,
	'class' => '',
]);

