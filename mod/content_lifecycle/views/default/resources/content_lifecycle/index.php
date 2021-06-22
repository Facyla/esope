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
$rule_default_opt = content_lifecycle_rule_options();
$object_subtypes = get_registered_entity_types('object');


// PARAMETRES */

// Mode de fonctionnement
//$default_action_mode = elgg_get_plugin_setting('action_mode', 'content_lifecycle'); // Config plugin (valeur par défaut)
$action_mode = get_input('action_mode');

// User to delete
$guid = get_input('guid');
if (is_array($guid)) { $guid = $guid[0]; }
$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($guid) {
	return get_user($guid);
});


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
	$new_owner_default_entity = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($new_owner_default) {
		return get_entity($new_owner_default);
	});
	
	$content .= '<h2>' . elgg_echo('account_lifecycle:processing') . '</h2>';
	$content .= '<div class="elgg-output">';
		//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
		//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
		if ($guid === elgg_get_logged_in_user_guid()) {
			$content .= elgg_echo('account_lifecycle:user:noself');
		} else if (!$user) {
				$content .= elgg_echo('account_lifecycle:user:invalid', [$guid]);
		} else if (!$user->canDelete()) {
				$content .= elgg_echo('account_lifecycle:user:cannotdelete');
		} else if (!in_array($rule_default, ['transfer','delete']) || !($new_owner_default_entity instanceof ElggUser || $new_owner_default_entity instanceof ElggGroup || $new_owner_default_entity instanceof ElggSite)) {
		} else {
			$errors = false; // Blocage suppression sur toute erreur de transfert
			$content .= '<ul>';
				$content .= '<li>' . elgg_echo('account_lifecycle:guid', [$guid]) . '</li>';
				$content .= '<li>' . elgg_echo('account_lifecycle:user:valid', [$user->username]) . '</li>';
				$content .= '<li>' . elgg_echo('account_lifecycle:default_rule', [$rule_default_opt[$rule_default]]) . '</li>';
				$content .= '<li>' . elgg_echo('account_lifecycle:default_new_owner', [$new_owner_default_entity->username]) . '</li>';
			$content .= '</ul>';
			
			// Traitement des groupes
			$content .= '<h3>' . elgg_echo('account_lifecycle:groups') . '</h3>';
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
							$errors = true;
							$content .= " => <strong>nouveau propriétaire&nbsp;: invalide</strong>";
						} else {
							$content .= " => <strong>nouveau propriétaire&nbsp;:</strong> {$selected_new_owner_entity->username} (guid {$selected_new_owner_entity->guid}) => ";
							
							// type d'action
							$content .= " <strong>$action_mode</strong>";
							if ($action_mode == 'execute') {
								if ($selected_new_owner != $user->guid) {
									// Ensure new owner if member of the group
									if (!$group->isMember($selected_new_owner_entity)) {
										$content .= elgg_echo('account_lifecycle:group:owner_not_group_member');
										$group->join($selected_new_owner_entity);
									}
									// verify new owner is member
									if ($group->isMember($selected_new_owner_entity)) {
										$content .= elgg_echo('account_lifecycle:group:owner_is_group_member');
										$group->owner_guid = $selected_new_owner;
										if ($group->container_guid == $user->guid) {
											// Even though this action defaults container_guid to the logged in user guid,
											// the group may have initially been created with a custom script that assigned
											// a different container entity. We want to make sure we preserve the original
											// container if it the group is not contained by the original owner.
											$group->container_guid = $selected_new_owner;
										}
										if ($group->save()) {
											$content .= elgg_echo('account_lifecycle:group:transfered');
										} else {
											$errors = true;
											$content .= elgg_echo('account_lifecycle:group:cannotsave');
										}
									} else {
										$errors = true;
										$content .= elgg_echo('account_lifecycle:error:notgroupmember');
									}
								} else {
									$errors = true;
									$content .= elgg_echo('account_lifecycle:error:cannottransferself');
								}
							} else {
								$content .= elgg_echo('account_lifecycle:error:simulating');
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
											$errors = true;
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
													$content .= elgg_echo('account_lifecycle:object:transfered');
												} else {
													$errors = true;
													$content .= elgg_echo('account_lifecycle:object:cannotsave');
												}
											} else {
												$content .= elgg_echo('account_lifecycle:error:simulating');
											}
										}
									$content .= '</li>';
								}
							$content .= '</ul>';
						} else {
							$content .= elgg_echo('account_lifecycle:error:nocontent');
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
				if ($errors) {
						$content .= elgg_echo('admin:user:delete:stoppedonerrors');
				} else {
					$deleted = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($user) {
						return $user->delete();
					});
					if (!$deleted) {
						$content .= elgg_echo('admin:user:delete:no');
					} else {
						$content .= " => <strong>OK !</strong>";
					}
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
	$content .= '<h2>' . elgg_echo('account_lifecycle:user:transfer_options') . '</h2>';
	//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
	//$content .= '<pre>' . print_r($rule_objects, true) . '</pre>'; // debug
	if ($guid === elgg_get_logged_in_user_guid()) {
		$content .= elgg_echo('account_lifecycle:user:noself');
	} else if (!$user) {
			$content .= elgg_echo('account_lifecycle:user:invalid', [$guid]);
	} else if (!$user->canDelete()) {
		$content .= elgg_echo('account_lifecycle:user:cannotdelete');
	} else {
		$can_proceed = true;
	}
}
if (!$can_proceed) {
	// Formulaire de sélection initial (équivalent de User > Admin > Supprimer)
	$content .= elgg_view_form('content_lifecycle/select_user', ['action' => "content_lifecycle/", 'method' => "GET"], []);
} else {
	$content .= '<div style="display: flex; flex-wrap: wrap;">';
		
		// Formulaire
		$content .= '<div style="flex: 1 1 30rem; margin: 0 1rem 1rem 1rem;">';
			// Instructions générales
			$content .= elgg_view('content_lifecycle/user_delete_notice', ['user' => $user]);
			// Formulaire de sélection
			$content .= elgg_view_form('content_lifecycle/delete_user_options', ['action' => "content_lifecycle/$guid", 'method' => "POST"], ['user' => $user]);
		$content .= '</div>';
		
		// Informations détaillées sur le compte utilisateur
		$content .= '<div style="flex: 1 1 30rem; margin: 0 1rem 1rem 1rem;">';
			$content .= elgg_view('content_lifecycle/user_details', ['user' => $user]);
		$content .= '</div>';
		
	$content .= '</div>';
}



echo elgg_view_page($title, [
	'title' => elgg_echo('content_lifecycle:index'),
	'content' =>  $content,
	'sidebar' => false,
	'sidebar_alt' => false,
	'class' => '',
]);

