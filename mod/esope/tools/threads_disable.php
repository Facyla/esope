<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

$title = "Rétablissement du fonctionnement sans threads";

$content .= "<p>Ce script va convertir tous vos sujets de type 'thread' (commentaires arborescents, ajoutés par le plugin 'threads') en commentaires 'normaux'. Si vous arrêtez d'utiliser le plugin 'threads', cela vous permet de convertir et récupérer les commentaires qui autrement deviendraient invisibles.</p><p>ATTENTION : cette action est sans danger, mais irréversible ! assurez-vous bien que vous ne souhaitez plus utiliser les commentaires arborescents avant de l'utiliser, et veuillez bien noter que l'arborescence des commentaires existant sera définitivement perdue !</p>";

$options = array('types' => 'object', 'subtypes' => 'topicreply', 'limit' => false);

$threads_replies = elgg_get_entities($options);
$content .= "Le site comporte actuellement  " . count($threads_replies) . " commentaire(s) de type \"threads\".<br />";
$content .= "Actuellement, le plugin \"threads\" est ";
if (elgg_is_active_plugin('threads')) {
	$content .= 'ACTIVE : tous les commentaires sont visibles. Vous ne pouvez pas convertir les commentaires "threads". Si vous souhaitez tout de même les convertir en commentaires normaux, veuillez commencer par désactiver le plugin \"threads\" puis revenez sur cette page.<br />';
} else {
	$content .= 'DESACTIVE : les commentaires "threads" ne sont pas visibles.';
	if ($threads_replies) {
		$content .= " Si vous ne comptez pas activer le plugin, vous devriez convertir les commentaires.<br />";
	} else $content .= " Il n'y a aucun commentaire à convertir : inutile de changer quoi que ce soit.<br />";
	$content .= '<br /><a class="elgg-button elgg-button-action" href="' . full_url() . '?action=convert_threads">Convertir les commentaires !</a><br />';
}
$content .= '<br />';


// Traitement de la conversion, si demandé
$do_convert = get_input('action', false);
$content .= '<hr />';
if ($do_convert == 'convert_threads') {
	$content .= "<p>Conversion des commentaires demandée :</p>";
	if ($threads_replies) {
		// name : 4272 = l'id de la metastring pour group_topic_post
		$name_id = get_metastring_id('group_topic_post');
		// Type de valeur
		$value_type = "text";
	
		foreach ($threads_replies as $ent) {
			$relationships = get_entity_relationships($ent->guid);
			//$content .= print_r($ent, true);
			$content .= "GUID : {$ent->guid}<br />";
			$content .= "owner_guid : {$ent->owner_guid} " . get_entity($ent->owner_guid)->name . "<br />";
			$content .= "time : {$ent->time_updated}<br />";
			$content .= "Accès : {$ent->access_id}<br />";
			foreach ($relationships as $relation) {
				if ($relation->relationship == 'top') {
					$top = $relation->guid_two;
					$content .= "Top : $top " . get_entity($top)->title;
				}
				/*
				else if ($relation->relationship == 'parent') {
					$parent = $relation->guid_two;
					$content .= "Parent : $parent " . get_entity($parent)->title;
				}
				*/
			}
			$content .= "Contenu du commentaire : {$ent->description}<br />";
		
			// entity_guid : celle qui a été commentée (relation "top")
			$entity_guid = $top;
			// value : l'id de la valeur du contenu
			$value_id = add_metastring($ent->description);
			// owner_guid : auteur du commentaire
			$owner_guid = $ent->owner_guid;
			// time : celui de dernière mise à jour
			$time_created = $ent->time_updated;
			// access : idem à l'original
			$access_id = $ent->access_id;
			$result = insert_data("INSERT into {$CONFIG->dbprefix}annotations (entity_guid, name_id, value_id, value_type, owner_guid, time_created, access_id) VALUES ($entity_guid,'$name_id',$value_id,'$value_type', $owner_guid, $time_created, $access_id)");
			if ($result !== false) {
				$content .= 'Commentaire créé sous forme d\'annotation<br />';
				// Commentaire OK ? => Suppression de l'ancien objet
				if ($ent->delete()) $content .= 'Ancien commentaire "objet" supprimé<br />';
				else $content .= 'Echec de la suppression de l\'Ancien commentaire "objet"<br />';
			} else {
				$content .= 'Commentaire déjà créé ou échec de la création de l\'annotation<br />';
			}
			$content .= '<hr />';
			//break; // @debug commenter une fois la transformation validée
		
		}
	} else {
		$content .= '<p>Aucun commentaire issu de "threads"</p>';
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


