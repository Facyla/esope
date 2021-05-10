<?php

//$guid = elgg_extract('guid', $vars);
$user = elgg_extract('user', $vars);


// Select options
$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];
$action_mode_opt = content_lifecycle_action_mode_options();
$rule_default_opt = content_lifecycle_rule_options();
$rule_groups_opt = content_lifecycle_rule_options();
$rule_objects_opt = content_lifecycle_rule_options();
$new_owner_opt = [];
$object_subtypes = get_registered_entity_types('object');


// Paramètres
// Mode de fonctionnement
//$default_action_mode = elgg_get_plugin_setting('action_mode', 'content_lifecycle'); // Config plugin (valeur par défaut)
$action_mode = get_input('action_mode');

// User to delete
$guid = get_input('guid');
if (is_array($guid)) { $guid = $guid[0]; }

// Règles : du général ou particulier
$default_rule_default = elgg_get_plugin_setting('rule_default', 'content_lifecycle'); // Config plugin
$default_rule_groups = elgg_get_plugin_setting('rule_groups_default', 'content_lifecycle'); // Config plugin
$rule_default = get_input('rule_default'); // Global - par défaut
if (empty($rule_default)) { $rule_default = $default_rule_default; }
$rule_groups = get_input('rule_groups'); // Pour les groupes
if (empty($rule_groups)) { $rule_groups = $default_rule_groups; }
$rule_objects = get_input('rule_objects'); // Par subtype d'object
// Set defaults for each object subtype
foreach($object_subtypes as $subtype) {
	if (empty($rule_objects[$subtype])) {
		$rule_objects[$subtype] = elgg_get_plugin_setting("rule_objects_default_$subtype", 'content_lifecycle');
	}
}
$rule_entities = get_input('rule_entities'); // entité par entité (GUID uniquement : peut être un groupe comme un objet)

// Nouveau propriétaire : du général ou particulier
$default_new_owner_default = elgg_get_plugin_setting('new_owner_default', 'content_lifecycle'); // Config plugin
$new_owner_default = get_input('new_owner_default'); // Global - par défaut
if (is_array($new_owner_default)) { $new_owner_default = $new_owner_default[0]; } // userpicker always returns an array
if (empty($new_owner_default)) { $new_owner_default = $default_new_owner_default; }
$new_owner_groups_default = elgg_get_plugin_setting('new_owner_groups_default', 'content_lifecycle'); // Config plugin
$new_owner_groups = get_input('new_owner_groups'); // (int) Pour les groupes (GUID)
if (empty($new_owner_groups)) { $new_owner_groups = $new_owner_groups_default; }
$new_owner_objects = get_input('new_owner_objects'); // (array) Par subtype d'object (array of GUID)
$new_owner_entities = get_input('new_owner_entities'); // (array) entité par entité (GUID uniquement : peut être un groupe comme un objet)


// User groups
$user_owned_groups_count = $user->getGroups(['owner_guid' => $user->guid, 'count' => true]);
$user_owned_groups = $user->getGroups(['owner_guid' => $user->guid, 'limit' => false]);



$content .= '<p><label>Mode de fonctionnement<br />' . elgg_view('input/select', ['name' => "action_mode", 'value' => $action_mode, 'options_values' => $action_mode_opt]) . '</label></p>';
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


$footer = elgg_view('input/submit', [
	'value' => elgg_echo('content_lifecycle:proceed'),
]);

elgg_set_form_footer($footer);

echo $content;

