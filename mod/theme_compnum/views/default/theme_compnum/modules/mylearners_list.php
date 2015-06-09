<?php

$filter_group_guid = $vars['group_guid'];
if ($filter_group_guid && ($filter_group = get_entity($filter_group_guid))) {}

if (!elgg_in_context('widgets')) {
	// Nouveaux comptes
	echo '<a href="' . $vars['url'] . 'dossierdepreuve/inscription?profiletype=learner" class="elgg-button elgg-button-action" style="float:right;" title="Créer de nouveaux comptes pour des candidats">Inscrire</a>';

	// Titre du bloc
	echo "<h3>Mes candidats</h3>";

	// Gestion des groupes des candidats
	echo '<a href="' . $vars['url'] . 'dossierdepreuve/gestion" class="elgg-button elgg-button-action" title="Permet de rattacher à des groupes de formation les candidats qui n\'en ont pas encore.">Gérer les groupes de rattachement</a><br /><br />';
	echo '<div class="clearfloat"></div>';
}

// On liste les groupes dont on est admin
// Listing des groupes dont on est propriétaire (owner) ou responsable (operator)
// Sauf si un groupe précis a été demandé (widget)
if ($filter_group) {
	$myadmin_groups[] = $filter_group;
} else {
	$myadmin_groups = theme_compnum_myadmin_groups($vars['entity']);
}


/* Trop massif...
<script type="text/javascript">
$(function() {
	$('#learners-groups-accordion').accordion({ header: 'h4', autoHeight: false });
});
</script>
	<h3>REFERENTIEL B2i Adultes</h3>
	<div>
	</div>
</div>
*/

$ia = elgg_set_ignore_access(true);

// Pour chacun des groupes dont on est admin...
if ($myadmin_groups) {
	foreach ($myadmin_groups as $ent) {
		$learners = dossierdepreuve_get_group_learners($ent);
		// Les groupes ne sont affichés que s'ils ont des candidats..
		if ($learners) {
			echo '<div style="padding-bottom:6px;">';
			echo '<h4><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconUrl('tiny') . '" style="float:left; margin-right:4px;" />' . $ent->name . '</a></h4>';
			//echo '<strong><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconUrl('tiny') . '" style="float:left; margin-right:4px;" /></a>' . $ent->name . '</strong>';
			echo '<div class="clearfloat"></div>';
			//$dossiers = dossierdepreuve_get_group_dossiers($group);
	
			// Pour chacun des candidats de ce groupe...
			foreach ($learners as $member) {
				echo '<div style="border-bottom:1px dotted #ccc; margin:2px 0 0 24px; padding-bottom:2px;">';
				//echo "Nom : blog, dossier de suivi (évaluations)<br />"; // @TODO pour chaque candidat
				//echo '<a href="' . $member->getURL() . '" title="' . $member->name . '"><img src="' . $member->getIconUrl('tiny') . '" style="margin-right:2px;" /></a>';
				$dossier = dossierdepreuve_get_user_dossier($member->guid);
				if ($dossier) { echo '<a href="' . $dossier->getURL() . '" title="Afficher son Dossier de preuve">'; }
				else { echo '<a href="' . $vars['url'] . 'dossierdepreuve/new?owner_guid=' . $member->guid . '" title="Créer son Dossier de preuve">'; }
				echo '<img src="' . $member->getIconUrl('topbar') . '" style="float:left; margin:0 2px 2px 0;" />' . $member->name;
				echo '</a>';
				if (!$dossier) { echo ' <em>pas de dossier</em>'; }
				echo '<div class="clearfloat"></div>';
				echo '</div>';
			}
			/*
			echo elgg_view_entity_list($learners, array('full_view' => false, 'limit' => count($learners), 'size' => 'tiny', 'list_type' => 'gallery'));
			*/
			echo '<div class="clearfloat"></div>';
			echo '</div>';
		}
	}
} else {
		// SI groupe choisi, on l'affiche quand même, mais sans contenu..
		if ($filter_group) {
			echo '<div style="padding-bottom:6px;">';
			echo '<h4><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconUrl('tiny') . '" style="float:left; margin-right:4px;" />' . $ent->name . '</a></h4>';
			//echo '<strong><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconUrl('tiny') . '" style="float:left; margin-right:4px;" /></a>' . $ent->name . '</strong>';
			echo '<div class="clearfloat"></div>';
			echo '</div>';
		}
}
elgg_set_ignore_access($ia);

echo '<div class="clearfloat"></div><br />';

/*
	$params = array('relationship' => 'friend','relationship_guid' => $owner->guid, 'type' => 'user', 'count' => true);
	$count = elgg_get_entities_from_relationship($params);
	$params['count'] = false;
	$contacts = elgg_get_entities_from_relationship($params);
	
	// Filtrage des comptes formateurs
	foreach($contacts as $ent) {
		$profiletype = dossierdepreuve_get_user_profile_type($ent);
		if (in_array($profiletype, array('tutor', 'evaluator'))) $tutors[] = $ent;
	}
	$count = count($tutors);
	foreach($tutors as $ent) {
		echo '<a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconUrl('tiny') . '" style="margin-right:2px;" /></a>';
	}
*/


