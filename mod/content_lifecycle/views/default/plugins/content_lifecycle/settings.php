<?php
$plugin = elgg_extract('entity', $vars);

// Select values
$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

/* Interception de la suppression d'un compte utilisateur afin de transférer les contenus non-personnels
 *  - mode automatique : {groupes et types d'objets} => {transfert | suppression} => {entité cible (groupe ou membre)}
 *  - mode manuel : choix des groupes et contenus , et de l'entité cible (soit globalement, soit entité par entité)
 */

$rule_opt = content_lifecycle_rule_options();
$action_mode_opt = content_lifecycle_action_mode_options();

echo '<div class="elgg-output"><em>' . "Principe de fonctionnement : ce plugin intercepte la suppression d'un compte utilisateur et offre à un compte administrateur la possibilité de choisir de transférer certains types de contenus vers d'autres comptes avant supression&nbsp;:
	<ul>
		<li>un administrateur décide de supprimer un compte utilisateur</li>
		<li>une page intercalaire permet de choisir quelles options appliquer : transfert ou supression définitive, et destinataire du transfert</li>
		<li>des options avancées permettent de définir plus finement quels types de contenus transférer et à qui : groupes, types de contenus</li>
		<li>des listes des contenus concernés permettent enfin de choisir l'action à effectuer contenu par contenu</li>
	</ul>
	Cette page de configuration définit les choix qui sont présélectionnés par défaut." . '</em></div>';

echo '<p class="float-alt">' . elgg_view('output/url', ['text' => "Page de contrôle et d'exécution", 'href' => elgg_get_site_url() . "content_lifecycle/", 'class' => "elgg-button elgg-button-action", 'target' => "_blank"]) . '</p>';


// Default Action mode
echo '<p><label>Mode de fonctionnement<br />' . elgg_view('input/select', ['name' => "params[action_mode]", 'value' => $plugin->action_mode, 'options_values' => $action_mode_opt]) . '</label></p>';
echo '<br />';

// Mode simple : configuration globale par défaut
echo '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0; display: flex; justify-content: space-between; flex-wrap: wrap;">';
	echo '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Configuration par défaut" . '</legend>';
	// Default Rule
	echo '<div style="flex: 0 0 auto; margin-right: 2rem;"><label><label>Action par défaut<br />' . elgg_view('input/select', ['name' => "params[rule_default]", 'value' => $plugin->rule_default, 'options_values' => $rule_opt]) . '</label></div>';
	
	// Default Destination
	echo '<div style="flex: 0 1 20rem; margin-right: 2rem;"><label>' . "Nouveau propriétaire par défaut";
		// Note : le userpicker génère un tableau, non supporté par les paramètres des plugins : on va préférer une autre méthode, type GUID dans champ texte pour éviter ce type de soucis
	//echo '<div>' . elgg_view('input/userpicker', ['name' => "params[new_owner_default]", 'value' => $plugin->new_owner_default, 'limit' => 1]) . '<em>' . "Tous les transferts seront faits vers ce compte utilisateur. Il est possible de définir d'autres comptes utilisateurs pour chacun des types de contenu." . '</em></div>';
	echo elgg_view('input/text', ['name' => "params[new_owner_default]", 'value' => $plugin->new_owner_default, 'limit' => 1]) . '</label><em>' . "Tous les transferts seront faits vers ce compte utilisateur. Il est possible de définir d'autres comptes utilisateurs pour chacun des types de contenu." . '</em>' . '</div>';
	echo '<div style="flex: 1 1 20rem;">' . content_lifecycle_display_entity($plugin->new_owner_default) . '</div>';
echo '</fieldset>';
echo '<br />';


// ADVANCED SETTINGS : override global setting on a more detailed basis
// Advanced settings (overrides global setting)

// Configuration pour les Groupes
echo '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0; display: flex; justify-content: space-between; flex-wrap: wrap;">';
	echo '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Configuration pour les Groupes" . '</legend>';
	// Group default action
	echo '<div style="flex: 0 0 auto; margin-right: 2rem;"><label>Action par défaut pour les Groupes<br />' . elgg_view('input/select', ['name' => "params[rule_groups_default]", 'value' => $plugin->rule_groups_default, 'options_values' => $rule_opt]) . '</label></div>';
	
	// Group default new owner
	echo '<div style="flex: 0 1 20rem; margin-right: 2rem;"><label>Nouveau propriétaire pour les groupes';
	echo elgg_view('input/text', ['name' => "params[new_owner_groups_default]", 'value' => $plugin->new_owner_groups_default, 'limit' => 1]) . '</label>' . '</div>';
	echo '<div style="flex: 1 1 20rem;">' . content_lifecycle_display_entity($plugin->new_owner_groups_default) . '</div>';
echo '</fieldset>';
echo '<br />';


// Configuration pour les types de Contenus
// @TODO : specify 2 rules and targets, as may be contained in groups (options : specific user, group owner, group itself), or outside groups (options : specific user, specific group, site itself?)
$object_subtypes = get_registered_entity_types('object');
echo '<div class="" style="display: grid; grid-template-columns: repeat(auto-fit,minmax(16rem,1fr)); grid-gap: 1rem 1rem;">';
	foreach($object_subtypes as $subtype) {
		echo '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
			echo '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . "Configuration avancée&nbsp;: <strong>$subtype</strong>" . '</legend>';
			// Object subtype default action
			echo '<div><label>Action par défaut pour les Contenus<br />' . elgg_view('input/select', ['name' => "params[rule_objects_default_$subtype]", 'value' => $plugin->{"rule_objects_default_$subtype"}, 'options_values' => $rule_opt]) . '</label></div>';
			
			// Object subtype default new owner
			echo '<div><label>Nouveau propriétaire';
			$new_owner_objects_display = content_lifecycle_display_entity($plugin->{"new_owner_objects_default_$subtype"});
			echo elgg_view('input/text', ['name' => "params[new_owner_objects_default]", 'value' => $plugin->{"new_owner_objects_default_$subtype"}, 'limit' => 1]) . '</label>' . $new_owner_objects_display . '</div>';
		echo '</fieldset>';
	}
echo '</div>';


