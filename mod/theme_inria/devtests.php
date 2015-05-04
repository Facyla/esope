<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

// Limited to admin !
admin_gatekeeper();

$guid = get_input('guid', false);
$enabled = get_input('enabled', 'yes');
if (!in_array($enabled, array('yes', 'no'))) { $enabled = 'yes'; }

header('Content-type: text/html; charset=utf-8');

echo '<form method="POST">';
echo esope_make_search_field_from_profile_field(array('metadata' => 'inria_location', 'name' => "Localisation"));
echo esope_make_search_field_from_profile_field(array('metadata' => 'inria_location_main', 'name' => "Centre de rattachement"));
echo esope_make_search_field_from_profile_field(array('metadata' => 'epi_ou_service', 'name' => "EPI ou service"));
echo '<input type="submit" value="Envoyer"></form>';


/* TESTS DE DESACTIVATION D'UN GROUPE ET DE SES CONTENUS
echo '<form method="POST">
	<input type="text" name="guid" placeholder="GUID" value="' . $guid . '">
	<input type="text" name="enabled" placeholder="yes / no" value="' . $enabled . '">
	<input type="submit" value="Procéder à l\'activation / désactivation">
	</form>';

if ($guid) {
	access_show_hidden_entities(true);
	
	echo "GUID : " . $guid . '<br />';
	$group = get_entity($guid);
	echo "Group actif ? " . $group->isEnabled() . '<br />';
	
	if ($enabled == 'no') {
		$group->disable();
	} else if ($enabled == 'yes') {
		$group->enable();
	}
	
	
	if (elgg_instanceof($group, 'group')) {
		echo "Groupe : " . $group->name . '<br />';
		$objects = $group->getObjects('', 0);
		foreach ($objects as $ent) {
			echo "Contenu : " . $ent->guid . ' (' . $ent->getSubtype() . ') : ' . $ent->title . $ent->name . ' => ' . $ent->enabled . '<br />';
		}
		
	}
}
*/



