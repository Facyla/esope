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

// Select options
$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];
$action_mode_opt = content_lifecycle_action_mode_options();
$rule_default_opt = content_lifecycle_rule_options();
$rule_groups_opt = content_lifecycle_rule_options();
$rule_objects_opt = content_lifecycle_rule_options();
$new_owner_opt = [];
$object_subtypes = get_registered_entity_types('object');


// PARAMETRES */

// Mode de fonctionnement
$default_action_mode = elgg_get_plugin_setting('action_mode', 'content_lifecycle'); // Config plugin (valeur par défaut)
$action_mode = get_input('action_mode');

// User to delete
$guid = get_input('guid');
if (is_array($guid)) { $guid = $guid[0]; }

// Nouveau propriétaire : du général ou particulier
$default_new_owner_default = elgg_get_plugin_setting('new_owner_default', 'content_lifecycle'); // Config plugin
$new_owner_default = get_input('new_owner_default'); // Global - par défaut
if (is_array($new_owner_default)) { $new_owner_default = $new_owner_default[0]; } // userpicker always returns an array
if (empty($new_owner_default)) { $new_owner_default = $default_new_owner_default; }
$new_owner_groups = get_input('new_owner_groups'); // (int) Pour les groupes (GUID)
$new_owner_objects = get_input('new_owner_objects'); // (array) Par subtype d'object (array of GUID)
$new_owner_entities = get_input('new_owner_entities'); // (array) entité par entité (GUID uniquement : peut être un groupe comme un objet)

// Règles : du général ou particulier
$default_rule_default = elgg_get_plugin_setting('rule_default', 'content_lifecycle'); // Config plugin
$rule_default = get_input('rule_default'); // Global - par défaut
if (empty($rule_default)) { $rule_default = $default_rule_default; }
$rule_groups = get_input('rule_groups'); // Pour les groupes
$rule_objects = get_input('rule_objects'); // Par subtype d'object
// Set defaults for each object subtype
foreach($object_subtypes as $subtype) {
	if (empty($rule_objects[$subtype])) {
		$rule_objects[$subtype] = elgg_get_plugin_setting("rule_objects_default_$subtype", 'content_lifecycle');
	}
}
$rule_entities = get_input('rule_entities'); // entité par entité (GUID uniquement : peut être un groupe comme un objet)



// EXECUTION DES ACTIONS
// @TODO en faire des fonctions ou des méthodes
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
			$content .= elgg_echo('admin:user:self:delete:no');
		} else if (!$user) {
				$content .= "Ce GUID n'est pas celui d'un compte utilisateur valide&nbsp;: $guid";
		} else if (!$user->canDelete()) {
				$content .= elgg_echo('admin:user:delete:no');
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
						//$content .= " => <strong>action&nbsp;:</strong> (default {$rule_default}, groups {$rule_groups}, this group {$rule_entities[$group->guid]})"; // debug
						$selected_rule = content_lifecycle_select_rule($default_rule_default, $rule_default, $rule_groups, $rule_entities[$group->guid]);
						$content .= " <strong>$selected_rule</strong> => ";
						
						// new owner
						$content .= " => <strong>nouveau propriétaire&nbsp;:</strong> (default {$new_owner_default}, groups {$new_owner_groups}, this group {$new_owner_entities[$group->guid]})";
						$selected_new_owner = content_lifecycle_select_new_owner($default_new_owner_default, $new_owner_default, $new_owner_groups, $new_owner_entities[$group->guid]);
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
										//$content .= " => <strong>action&nbsp;:</strong> (default {$rule_default}, this subtype {$rule_objects[$subtype]}, this object {$rule_entities[$object->guid]})"; // debug
										$selected_rule = content_lifecycle_select_rule($default_rule_default, $rule_default, $rule_objects[$subtype], $rule_entities[$object->guid]);
										$content .= " <strong>$selected_rule</strong> => "; // action
										
										// new owner
										$content .= " => <strong>nouveau propriétaire&nbsp;:</strong> (default {$new_owner_default}, this subtype {$new_owner_objects[$subtype][0]}, this object {$new_owner_entities[$object->guid]})";
										$selected_new_owner = content_lifecycle_select_new_owner($default_new_owner_default, $new_owner_default, $new_owner_objects[$subtype][0], $new_owner_entities[$object->guid]);
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
	$content .= '</div>';
}



/* FORMULAIRE */
$can_proceed = false;
if ($guid) {
	$content .= '<h2>Gestion des contenus lors de la suppression du compte</h2>';
	//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
	//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
	$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($guid) {
		return get_user($guid);
	});
	if ($guid === elgg_get_logged_in_user_guid()) {
		$content .= elgg_echo('admin:user:self:delete:no');
	} else if (!$user) {
			$content .= "Ce GUID n'est pas celui d'un compte utilisateur valide&nbsp;: $guid";
	} else if (!$user->canDelete()) {
		$content .= elgg_echo('admin:user:delete:no');
	} else {
		$can_proceed = true;
	}
}
if ($can_proceed) {
	// User groups
	$user_owned_groups_count = $user->getGroups(['owner_guid' => $user->guid, 'count' => true]);
	$user_owned_groups = $user->getGroups(['owner_guid' => $user->guid, 'limit' => false]);
	
	$content .= '<div style="display: flex; flex-wrap: wrap;">';
		
		$content .= '<div style="flex: 1 1 30rem; margin: 0 1rem 1rem 1rem;">';
			// Informations générales
			$content .= elgg_view('content_lifecycle/user_delete_notice', ['user' => $user]);
			
			// Formulaire de sélection
			
			$content .= '<form method="GET", action="">';
				
				$content .= '<p><label>Mode de fonctionnement<br />' . elgg_view('input/select', ['name' => "action_mode", 'value' => $action_mode, 'options_values' => $action_mode_opt, 'required' => true]) . '</label></p>';
				$content .= '<br />';
				
				// MODE SIMPLE ET GLOBAL - PARAMETRES PAR DEFAUT
				$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
					$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Mode simple - réglages globaux" . '</legend>';
					$content .= '<p><em>' . "Le mode simple permet d'appliquer les options de transfert prédéfinies. Si vous le souhaitez, vous pouvez utiliser les réglages ci-après pour définir de manière plus fine ce qui doit être transféré ou supprimé, et à qui." . '</em></p>';
					// Origin
					$content .= '<div><label>Utilisateur à supprimer</label>' . elgg_view('input/userpicker', ['name' => "guid", 'value' => $guid, 'limit' => 1, 'required' => true]) . '</div>';
				
					// Default Action
					$content .= '<div><label>Action par défaut<br />' . elgg_view('input/select', ['name' => "rule_default", 'value' => $rule_default, 'options_values' => $rule_default_opt, 'required' => true]) . '</label></div>';
					
				// Default Destination : par défaut, si non overridé dans les réglages suivants
					$content .= '<div><label>Nouveau propriétaire</label>' . elgg_view('input/userpicker', ['name' => "new_owner_default", 'value' => $new_owner_default, 'limit' => 1, 'required' => true]) . '<em>' . "Tous les transferts seront faits vers ce compte utilisateur. Il est possible de définir d'autres comptes utilisateurs pour chacun des types de contenu." . '</em></div>';
					
					$content .= '<p>' . elgg_view('input/submit', ['value' => "MODE SIMPLE - Appliquer ces actions"]) . '</p>';
				$content .= '</fieldset>';
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
				// @TODO : specify 2 rules and targets, as may be contained in groups (options : specific user, group owner, group itself), or outside groups (options : specific user, specific group, site itself?)
				// 1 selector for each subtype, with the desired action and targets (in groups / outside group)
				foreach($object_subtypes as $subtype) {
					//$content .= "$type > $subtype<br />";
					$user_objects_count = $user->getObjects(['type' => 'object', 'subtype' => $subtype, 'count' => true]);
					
					$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0; display: flex; flex-wrap: wrap; justify-content: space-around;">';
						$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . $subtype . '</legend>';
						if (true || $user_objects_count > 0) {
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
				$content .= '<p>' . elgg_view('input/submit', ['value' => elgg_echo('execute')]) . '</p>';
			$content .= '</form>';
			
		$content .= '</div>';
		
		
		// Informations détaillées sur le compte utilisateur
		$content .= '<div style="flex: 1 1 30rem; margin: 0 1rem 1rem 1rem;">';
			$content .= elgg_view('content_lifecycle/user_details', ['user' => $user]);
		$content .= '</div>';
		
	$content .= '</div>';
} else {
	// Formulaire de sélection initial (équivalent de User > Admin > Supprimer)
	$content .= '<p>' . "Pas de compte sélectionné." . '</p>';
	$content .= '<form method="GET", action="">';
		// Origin
		$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
			$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Utilisateur à supprimer" . '</legend>';
			$content .= '<div><label>Utilisateur à supprimer</label>' . elgg_view('input/userpicker', ['name' => "guid", 'value' => '', 'limit' => 1]) . '</div>';
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

