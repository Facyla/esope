<?php
$user_guid = $vars['user_guid'];
if (!$user_guid) $user_guid = elgg_get_logged_in_user_guid();

$dossiers = dossierdepreuve_get_user_dossiers($user_guid, false);
if ($dossiers) {
	foreach ($dossiers as $dossier) {
		//echo elgg_view_entity($dossier) . '<hr />';
		echo '<a href="' . $dossier->getURL() . '" class="elgg-button elgg-button-action">' . $dossier->title . '</a><br /><br />';
		echo '<a href="' . $vars['url'] . 'dossierdepreuve/edit/' . $dossier->guid . '" class="elgg-button elgg-button-action">Mettre à jour mon Dossier </a><br /><br />';
		echo '<a class="elgg-button elgg-button-action" href="' . $vars['url'] . 'dossierdepreuve/autopositionnement">Autopositionnement</a></p>';
	}
} else {
	if (dossierdepreuve_get_user_profile_type() == 'learner') {
		echo "<p>Vous n'avez pas encore de dossier de suivi.</p>" 
			. '<p><a class="elgg-button elgg-button-action" href="' . $vars['url'] . 'dossierdepreuve/new">Créer mon dossier de suivi</a></p>'
			. '<p><a class="elgg-button elgg-button-action" href="' . $vars['url'] . 'dossierdepreuve/autopositionnement">Test d\'autopositionnement</a> (permet de créer le dossier de preuve à partir d\'un positionnement initial)</p>';
	}
}

