<?php
$user = $vars['entity'];
$profiletype = dossierdepreuve_get_user_profile_type($user);

// Boutons différents selon les profils
if (($profiletype == 'organisation') || elgg_is_admin_logged_in()) {
	echo '<a href="' . $vars['url'] . 'groups/add/' . $user->guid . '" class="elgg-button elgg-button-action" title="Créer un nouveau groupe de formation" style="float:right;">Créer</a>';
}

// Titre du bloc
echo "<h3>Groupes de formation</h3>";

//echo '<a href="' . $vars['url'] . 'dossierdepreuve/inscription?profiletype=evaluator" class="elgg-button elgg-button-action">Inviter des formateurs</a><br /><br />';

if (in_array($profiletype, array('tutor', 'evaluator')) || elgg_is_admin_logged_in()) {
	echo '<a href="' . $vars['url'] . 'groups/all" class="elgg-button elgg-button-action">Rejoindre un groupe de formation</a><br />';
}


echo "<p>Cliquez sur les groupes pour les gérer (inviter et gérer formateurs et candidats).</p>";
// Listing des groupes dont on est propriétaire (owner) ou responsable (operator)
$myadmin_groups = theme_compnum_myadmin_groups($user);
//echo elgg_view_entity_list($myadmin_groups, array('full_view' => false, 'limit' => count($myadmin_groups), 'size' => 'tiny', 'list_type' => 'gallery'));
if ($myadmin_groups) foreach ($myadmin_groups as $ent) {
	echo '<a href="' . $ent->getURL() . '" title="' . $ent->name . '" class="elgg-popup"><img src="' . $ent->getIconUrl('small') . '" style="margin-right:2px;" /></a>';
}

echo '<div class="clearfloat"></div><br />';

