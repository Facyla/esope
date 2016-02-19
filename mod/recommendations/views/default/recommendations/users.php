<?php

elgg_load_library('elgg:recommendations');

$user = $vars['entity'];
$limit = $vars['limit'];
$list_style = $vars['list_style'];

$recommendations = recommendations_get_users($user, 30, $limit);

if (count($recommendations > 0)) {
	foreach ($recommendations as $person) {
		//$mutuals = count($person['mutuals']);
		//$shared_groups = count($person['groups']);
		//$icon = '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('large') . '" /></a>';
		/*
		$info = '<p><strong>' . $person['entity']->name . '</strong>';
		if ($mutuals > 0) $info = ' &nbsp; ' . $mutuals . ' contacts comuns';
		if ($shared_groups > 0) $info .= ' &nbsp; ' . $shared_groups . ' groupes partagés';
		$info .= '</p>';
		*/
		$content .= elgg_view('profile/icon', array('entity' => $person['entity'], 'size' => 'small'));
	}
} else {
	//$content .= '<p>' . "Pas de recommandation de contact pour le moment.</p><p>Commencez par rejoindre des groupes et entrer en contact avec quelques personnes pour avoir des recommandations personnalisées" . '</p>';
}
$content .= '<div class="clearfloat"></div>';

echo $content;

