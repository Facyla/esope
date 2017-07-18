<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

admin_gatekeeper();

$content = '';
$sidebar = '';

$group_guid = get_input('group_guid');
$transtype = get_input('transtype', 'no');


// Composition de la page
$content .= '<div id="inria-upgrade" class="">';
	$content .= "Cette page regroupe des outils utiles lors des mises à jour.";

	$content .= '<h3>Transtypage des sujets de forum en articles de blog</h3>';
	$content .= '<p><blockquote>' . "Cette opération est très délicate, et irréversible. Les sujets de discussion des forums seront transformés en articles de blog, et les réponses en commentaires. Ce transtypage ne produit pas de perte d'information, mais les forums d'origine seront détruits.<br />Afin de valider le fonctionnement du transtypage, cette opération peut être simulée dans un groupe précis, en indiquant son GUID : dans ce cas les nouveaux articles de blogs seront créés à partir des sujets de discussion du forum, de manière moins globale (un par un)." . '</blockquote></p>';
	$content .= '<form method="GET">';
	$content .= elgg_view('input/securitytoken');
	$content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'transtype', 'value' => '', 'options_values' => ['no' => "Non (limité dans un groupe)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
	$content .= '<p><label>GUID du groupe ' . elgg_view('input/text', array('name' => 'group_guid', 'value' => $group_guid)) . '</label></p>';
	$content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer le transtypage")) . '</p>';
	$content .= '</form>';


	$forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'limit' => 0);
	//$forums_opt = array('type' => 'object', 'subtype' => 'groupforumtopic', 'limit' => 0);
	//$forums_opt = array('type' => 'object', 'subtype' => 'discussion_reply', 'limit' => 0); // attention, container = sujet de forum
	// Container limit for tests and validation
	if (($transtype == 'yes') || ($group_guid > 1)) {
		if ($transtype != 'yes') {
			$forums_opt['container_guid'] = $group_guid;
		}
		$forums = elgg_get_entities($forums_opt);
	} else {
		$content .= '<p>' . "Vous devez définir soit un groupe dans lequel valider le fonctionnement du transtypage, soit ajouter ?transtype=yes à l'URL pour effectuer le transtypage sur l'ensemble des forums du site" . '</p>';
	}

	// "Simulation" : on limite les risques
	//if ($transtype != 'yes') { $forums = array_slice($forums, 0, 1); }
	
	/* Modifier : 
		- groupforumtopic
			subtype: groupforumtopic => blog
			status: open|closed => comments_on: On|Off
			=> status: published
		
		- discussion_reply
			subtype: discussion_reply => comment
			container_guid: 5161
	*/
	
	
	
	/*
	
	if (elgg_instanceof($ent, 'object', 'groupforumtopic')) {
		$result = update_data("UPDATE {$dbprefix}entities set subtype='$blog_subtype_id' WHERE guid=$ent->guid");
	}
	if (elgg_instanceof($ent, 'object', 'discussion_reply')) {
		$result = update_data("UPDATE {$dbprefix}entities set subtype='$blog_subtype_id' WHERE guid=$ent->guid");
	}
	*/
	
	

	$dbprefix = elgg_get_config('dbprefix');
	$groupforumtopic_subtype_id = get_subtype_id('object', 'groupforumtopic');
	$discussion_reply_subtype_id = get_subtype_id('object', 'discussion_reply');
	$blog_subtype_id = get_subtype_id('object', 'blog');
	$comment_subtype_id = get_subtype_id('object', 'comment');

/* Test discussion (car le container n'a pas de sens : c'est le sujet de forum...)
$disc = get_entity(5167);
$forums = array($disc);
*/

	if ($forums) foreach ($forums as $k => $ent) {
		// Transformation des sujets et réponses des forums en articles
		//$content .= elgg_view_entity($ent);
		$content .= "$ent->guid $ent->title $ent->subtype $ent->access_id $ent->status";
		
		// "Simulation" : on limite les risques
		//if (($transtype == 'yes') || ($k < 1)) {
		if (($transtype == 'yes') || ($k < 10)) {
			if (elgg_instanceof($ent, 'object', 'groupforumtopic')) {
				$result = update_data("UPDATE {$dbprefix}entities set subtype='$blog_subtype_id' WHERE guid=$ent->guid");
				if ($ent->status == 'closed') { $ent->comments_on = 'Off'; } else { $ent->comments_on = 'On'; }
				if ($ent->access_id === 0) { $ent->status = 'draft'; } else { $ent->status = 'published'; }
			} else if (elgg_instanceof($ent, 'object', 'discussion_reply')) {
				$result = update_data("UPDATE {$dbprefix}entities set subtype='$comment_subtype_id' WHERE guid=$ent->guid");
			}
			$content .= '<p>' . "Transtypage effectué" . '</p>';
			$ent->save();
		} else {
			$content .= '<p>' . "Pas d'action effectuée" . '</p>';
		}
		
		$content .= "$ent->guid $ent->title $ent->subtype $ent->access_id $ent->status $ent->comment_on";
		$content .= '<hr />';
	}


$content .= '</div>';


//$sidebar .= "<p>" . '<a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'cmspages">Gérer les pages CMS</a>';




$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

