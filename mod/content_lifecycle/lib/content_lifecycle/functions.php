<?php


// Event avant la suppression d'un compte
function content_lifecycle_delete_user_event(\Elgg\Event $event) {
	
	return true;
}

// Hook avant action de suppression d'un compte
function content_lifecycle_delete_user_action(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$params = $hook->getParams();
	$entity = $hook->getEntityParam();
	$guid = get_input('guid');
	$user = get_user($guid);
	// Check account_lifecycle delete flag (intercept only if not set to 'delete')
	if ($user->account_lifecycle == "delete_now") {
		return true;
	} else {
		forward('content_lifecycle/?guid=' . $guid);
	}
}

// Hook avant action de suppression de plusieurs comptes
function content_lifecycle_delete_user_bulk_action(\Elgg\Hook $hook) {
	
	return true;
}

// Select and options lists
function content_lifecycle_action_mode_options() {
	return [
		'' => 'Ne rien faire (conserve les options choisies)', 
		'simulate' => "Simulation", 
		'execute' => "Applique les options et supprime le compte",
	];
} 
function content_lifecycle_rule_options() {
	return [
		'' => '', 
		'transfer' => elgg_echo('option:transfer'), 
		'delete' => elgg_echo('option:delete'),
	];
}

// Select config from most generic to particular
// @return (string) valid rule, ie empty, transfer or delete
function content_lifecycle_select_rule($default_rule_default = false, $rule_default = false, $rule_groups = false, $rule_entity = false) {
	if (!empty($rule_entity)) {
		$rule = $rule_entity;
	} else if (!empty($rule_groups)) {
		$rule = $rule_groups;
	} else if (!empty($rule_default)) {
		$rule = $rule_default;
	} else if (!empty($default_rule_default)) {
		$rule = $default_rule_default;
	}
	if (empty($rule) || in_array($rule, ['transfer', 'delete'])) { return $rule; }
	return false;
}
// @return (int) GUID of a valid ElggUser, ElggGroup or ElggSite entity
function content_lifecycle_select_new_owner($default_new_owner_default = false, $new_owner_default = false, $new_owner_type = false, $new_owner_entity = false) {
	if (!empty($new_owner_entity)) {
		$selected_new_owner = $new_owner_entity;
	} else if (!empty($new_owner_type)) {
		$selected_new_owner = $new_owner_type;
	} else if (!empty($new_owner_default)) {
		$selected_new_owner = $new_owner_default;
	} else if (!empty($default_new_owner_default)) {
		$selected_new_owner = $default_new_owner_default;
	}
	// Check select new owner entity validity
	$selected_new_owner_entity = get_entity($selected_new_owner);
	if (!($selected_new_owner_entity instanceof ElggUser || $selected_new_owner_entity instanceof ElggGroup || $selected_new_owner_entity instanceof ElggSite)) {
		return $selected_new_owner; // GUID
	}
	return false;
}

function content_lifecycle_display_entity($guid) {
	if (empty($guid)) { return false; }
	$new_owner_default_entity = get_entity($guid);
	if ($new_owner_default_entity instanceof ElggUser) {
		$new_owner_display = "Compte utilisateur : " . elgg_view_entity_icon($new_owner_default_entity, 'tiny', ['use_link' => false]) . " {$new_owner_default_entity->username} - {$new_owner_default_entity->name} - {$new_owner_default_entity->email}";
	} else if ($new_owner_default_entity instanceof ElggGroup) {
		$new_owner_display = "Groupe : " . elgg_view_entity_icon($new_owner_default_entity, 'tiny', ['use_link' => false]) . " {$new_owner_default_entity->name}";
	} else if ($new_owner_default_entity instanceof ElggSite) {
		$new_owner_display = "Site : " . elgg_view_entity_icon($new_owner_default_entity, 'tiny', ['use_link' => false]);
	} else {
		$new_owner_display = "GUID invalide.";
	}
	$new_owner_display = '<blockquote>' . $new_owner_display . '</blockquote>';
	return $new_owner_display;
}


// @TODO Transfer group ownership to new user

// @TODO Transfer objects to new owner


