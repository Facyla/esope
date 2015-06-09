<?php
// owner of the widget
$owner = $vars['entity'];
// the number of friends to display
$num = 48;
// get the correct size
$size = $vars['entity']->icon_size;

echo '<a href="' . $vars['url'] . 'dossierdepreuve/inscription?profiletype=evaluator" class="elgg-button elgg-button-action" title="Créer des comptes formateurs ou formateurs-habilitateurs" style="float:right;">Inscrire</a>';

// Titre du bloc
echo "<h3>Mes formateurs</h3>";

/*
<li><a href="' . $url . 'dossierdepreuve/inscription'; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:register'); ?></a></li>
<li><a href="<?php echo $url . 'dossierdepreuve/gestion'; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:gestion'); ?></a></li>
<li><a href="<?php echo $url . 'dossierdepreuve/all'; ?>"><?php echo elgg_echo('theme_compnum:dossierpreuve:all'); ?></a></li>
*/

echo '<a href="' . $vars['url'] . 'members/formateur" class="elgg-button elgg-button-action">Identifier mes formateurs (contacts)</a><br /><br />';
echo '<div class="clearfloat"></div>';



if (elgg_instanceof($owner, 'user')) {
	$params = array('relationship' => 'friend','relationship_guid' => $owner->guid, 'type' => 'user', 'count' => true);
	$count = elgg_get_entities_from_relationship($params);
	$params['count'] = false;
	$contacts = elgg_get_entities_from_relationship($params);
	// Filtrage des comptes formateurs
	if ($contacts) foreach($contacts as $ent) {
		$profiletype = dossierdepreuve_get_user_profile_type($ent);
		if (in_array($profiletype, array('tutor', 'evaluator'))) $tutors[] = $ent;
	}
	$count = count($tutors);
	/*
	foreach($tutors as $ent) {
		echo '<a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconUrl('tiny') . '" style="margin-right:2px;" /></a>';
	}
	*/
	echo elgg_view_entity_list($tutors, array('full_view' => false, 'limit' => $count, 'size' => 'tiny', 'list_type' => 'gallery'));
}


