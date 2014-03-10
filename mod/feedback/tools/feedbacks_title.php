<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

$title = "Ajout d'un titre pour les feedbacks";

$content .= "<p>Ce script ajoute un titre aux feedbacks, de sorte qu'ils puissent apparaître correctement dans la river. Il n'est nécessaire de l'utiliser qu'une seule fois, afin de corriger les feedbacks précédents. La correction est effectué en définissant comme titre un extrait composé des 25 premiers caractères du feedback.</p>";

$options = array('types' => 'object', 'subtypes' => 'feedback', 'limit' => false);

$feedbacks = elgg_get_entities($options);
$content .= "Le site comporte actuellement  " . count($feedbacks) . " feedbacks.<br />";
$content .= "Actuellement, le plugin \"feedback\" est ";
if (elgg_is_active_plugin('feedback')) {
	$content .= 'ACTIVE : vous pouvez continuer.<br />';
	if ($feedbacks) {
		$content .= " Vous devriez mettre à jour les feedbacks.<br />";
		$content .= '<br /><a class="elgg-button elgg-button-action" href="' . full_url() . '?action=convert_feedbacks">Convertir les feedbacks !</a><br />';
	} else $content .= " Il n'y a aucun feedback à mettre à jour : inutile de faire quoi que ce soit, les titres sont intégrés désormais.<br />";
} else {
	$content .= 'DESACTIVE : les feedbacks ne sont de toutes façons pas visibles.';
}
$content .= '<br />';


// Traitement de la conversion, si demandé
$do_convert = get_input('action', false);
$content .= '<hr />';
if ($do_convert == 'convert_feedbacks') {
	$content .= "<p>Conversion des feedbacks demandée :</p>";
	if ($feedbacks) {
		foreach ($feedbacks as $ent) {
			if (!empty($ent->title)) { continue; }
			$new_title = '';
			$feedback_txt = $ent->txt;
			$new_title = elgg_get_excerpt($feedback_txt, 25);
			// Update the feedback title
			$ent->title = $new_title;
			$ent->save();
			// Some report info
			$content .= "GUID : {$ent->guid}<br />";
			//$content .= "time : {$ent->time_updated}<br />";
			//$content .= "Accès : {$ent->access_id}<br />";
			//$content .= "Contenu du feedback : $feedback_txt<br />";
			$content .= "Titre généré : $new_title<br />";
			$content .= '<hr />';
			//break; // @debug commenter une fois la transformation validée
		
		}
	} else {
		$content .= '<p>Aucun feedback trouvé</p>';
	}
} else {
	$content .= "<p>Aucune action demandée.</p>";
}


$sidebar .= "...";

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


