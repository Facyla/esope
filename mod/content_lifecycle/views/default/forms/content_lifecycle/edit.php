<?php

$guid = elgg_extract('guid', $vars);
$entity = elgg_extract('entity', $vars);

//if ($entity instanceof ElggShowcase) { echo "ENTITY : " . print_r($entity, 1); }

$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

$metadata_operator_values = ['=', '<>', '>=', '<=', 'IN', 'NOT IN'];


if (!$entity instanceof ElggEntity) {
	$entity = new ElggAccountLifeCycle();
	$new = true;
	
}

if (!$entity instanceof ElggContentLifeCycle) {
	register_error(elgg_echo('content_lifecycle:error:invalidentity'));
	forward(REFERER);
}


/* Création de batches de gestion du cycle de vie = sélection de comptes + règles de gestion<br />
- title : nom batch
- status : activé ou non
- sélection : comptes admin non/oui, série de metadata => comparaison (==, !=, IN, NOT IN, >, <, <=, >=...), valeur<br />
- règles : exiger une nouvelle validation par email / sur le site, archiver, désactiver (ban)<br />
- fréquence : X mois après dernière connexion, tous les X mois<br />
</p>';

*/

$status_opt = [
	'yes' => "Activé",
	'no' => "Désactivé",
];

/*
$mode_opt = [
	'delivery' => "Livraison à domicile",
	'drive' => "Livraison en casier",
	'manual' => "Retrait sur place",
	'none' => "Aucun",
];

$price_opt = [
	'fixed' => "Fixe",
	'computed' => "Calculé selon les caractéristiques du colis",
];
*/



if (isset($entity->guid)) {
	echo elgg_view('input/hidden', ['name' => 'guid', 'value' => $entity->guid]);
}

// Titre
echo '<p><label>' . elgg_echo('content_lifecycle:field:title') . elgg_view('input/text', ['name' => 'title', 'value' => $entity->title]) . '</label></p>';
// Statut : actif/inactif
echo '<p><label>' . elgg_echo('content_lifecycle:field:status') . elgg_view('input/select', ['name' => 'status', 'value' => $entity->status, 'options_values' => $status_opt]) . '</label></p>';

// Critères de sélection des comptes
// Admin
echo '<p><label>' . elgg_echo('content_lifecycle:field:include_admin') . elgg_view('input/select', ['name' => 'include_admin', 'value' => $entity->include_admin, 'options_values' => $no_yes_opt]) . '</label></p>';
// Liste de métadonnées : meta_name, operator, value
echo '<fieldset><legend>' . elgg_echo('content_lifecycle:field:select_criteria') . '</legend>';
// @TODO : plusieurs éléments possibles : tableau sérialisé
echo '<p><label>' . elgg_echo('content_lifecycle:field:metadata_name') . elgg_view('input/text', ['name' => 'metadata_name[]', 'value' => $entity->metadata_name]) . '</label></p>';
echo '<p><label>' . elgg_echo('content_lifecycle:field:metadata_operator') . elgg_view('input/select', ['name' => 'metadata_operator[]', 'value' => $entity->metadata_operator, 'options_values' => $metadata_operator_values]) . '</label></p>';
echo '<p><label>' . elgg_echo('content_lifecycle:field:metadata_value') . elgg_view('input/text', ['name' => 'metadata_value[]', 'value' => $entity->metadata_value]) . '</label></p>';
echo '</fieldset>';


// Date de début (première exécution) - date limite à laquelle l'action prévue sera effectuée
echo '<p><label>' . elgg_echo('content_lifecycle:field:start_date') . elgg_view('input/date', ['name' => 'start_date', 'timestamp' => true, 'value' => $entity->start_date]) . '</label><br /><em>' . elgg_echo('content_lifecycle:field:start_date:details') . '</em></p>';
// Périodicité (intervale en jours)
echo '<p><label>' . elgg_echo('content_lifecycle:field:interval') . elgg_view('input/number', ['name' => 'interval', 'value' => $entity->interval, 'min' => 0, 'style' => 'max-width: 6rem;']) . '</label><br /><em>' . elgg_echo('content_lifecycle:field:interval:details') . '</em></p>';


// Notifications de rappel par email (0-n, eg. 1,3,7,30)
echo '<p><label>' . elgg_echo('content_lifecycle:field:reminders') . elgg_view('input/text', ['name' => 'reminders', 'value' => $entity->reminders]) . '</label><br /><em>' . elgg_echo('content_lifecycle:field:reminders:details') . '</em></p>';


// Règles à appliquer



$footer = elgg_view('input/submit', [
	'value' => elgg_echo('save'),
	'name' => 'save',
]);

elgg_set_form_footer($footer);
