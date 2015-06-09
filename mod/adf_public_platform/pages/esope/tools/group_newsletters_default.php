<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


admin_gatekeeper();

global $CONFIG;

$title = "Modification du réglage par défaut des newsletters des groupes";
$content = "Par défaut, lorsque aucun réglage n'est défini, les newsletters des groupes sont activées. Si vous souhaitez qu'elles ne soient pas activées, cet outil permet de définir le réglage sur \"no\" (désactivées).<br />Cela n'a aucune incidence sur les futurs groupes, ni sur les groupes pour lesquels le réglage a été enregistré.";
$sidebar = '';

$options = array('types' => 'group', 'limit' => 0);
$all_groups = elgg_get_entities($options);
$content .= "<p>Le site comporte actuellement  " . count($all_groups) . " groupes.</p>";

$content .= '<p><a href="?newsletter_force=disable" class="elgg-button elgg-button-action">Désactiver les newsletters des groupes (si non défini)</a></p>';


$newsletter_force = get_input('newsletter_force');
set_time_limit(0);
foreach ($all_groups as $ent) {
	$content .= '<a href="' . $CONFIG->url . 'groups/edit/' . $ent->guid . '" target="_blank" title="Ouvrir les réglages du groupe dans un nouvel onglet">' . $ent->name . '</a>&nbsp;: ';
	switch($ent->newsletter_enable) {
		case 'yes': $content .= 'activé'; break;
		case 'no': $content .= 'désactivé'; break;
		default: $content .= '(non défini)'; break;
	}
	// Force update only if asked to
	if ($newsletter_force == 'disable') {
		if (empty($ent->newsletter_enable)) {
			$ent->newsletter_enable = 'no';
			$content .= ' => désactivé';
		}
	}
	$content .= '<br />';
}

$content .= '<br />';



$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


