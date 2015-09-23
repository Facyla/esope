<?php
// Pour masquer le champ, utiliser config avancée d'Esope
$group = elgg_get_page_owner_entity();
// if (theme_afparh_is_pole($group)) return;

// Display the group Pôle(s)
$poles = $vars['value'];;
if (!is_array($poles)) $poles = array($poles);

$content = '';
foreach ($poles as $name) {
	$pole_guid = elgg_get_plugin_setting("{$name}group_guid", 'theme_afparh');
	if ($pole_group = get_entity($pole_guid)) {
		if (!empty($content)) $content .= '&nbsp; ';
		$content .= '<a href="' . $pole_group->getURL() . '">';
		$content .= elgg_echo("theme_afparh:pole:$name");
		$content .= '</a>';
	}
}


$pole = theme_afparh_is_pole($group);
if ($pole) {
	$content .= ' (' . elgg_echo('theme_afparh:group:is_pole') . ')';
} else {
	$departement = theme_afparh_is_departement($group);
	if ($departement) {
		$content .= ' (' . elgg_echo('theme_afparh:group:is_departement') . ')';
	}
}

echo $content;

