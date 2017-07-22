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
	$content .= "<p>Cette page regroupe des outils utiles lors des mises à jour.</p>";

	$content .= '<h3>Transtypage des sujets de forum en articles de blog</h3>';
	$content .= '<p><blockquote>' . "<strong>Cette opération est très délicate, et irréversible.</strong><br />Les sujets de discussion des forums seront transformés en articles de blog, et les réponses en commentaires. Ce transtypage ne produit pas de perte d'information, mais les forums d'origine seront détruits.<br />Afin de valider le fonctionnement du transtypage, cette opération peut être limitée dans un groupe précis, en indiquant son GUID : dans ce cas un seul sujet (et ses réponses) sera traité à la fois." . '</blockquote></p>';
	
	$remaining_forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'count' => true);
	$remaining_forums = elgg_get_entities($remaining_forums_opt);
	if ($remaining_forums === 0) {
		$content .= '<p>' . "Plus aucun sujet ou réponse de forum : désactivation des forums possible" . '</p>';
	} else  {
		$content .= '<p>' . "Le site comporte " . $remaining_forums . " sujets de discussion et réponses." . '</p>';
	}

	
	
	$content .= '<form method="GET">';
		$content .= elgg_view('input/securitytoken');
		$content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'transtype', 'value' => '', 'options_values' => ['no' => "Non (limité dans un groupe)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
		$content .= '<p><label>GUID du groupe ' . elgg_view('input/text', array('name' => 'group_guid', 'value' => $group_guid)) . '</label></p>';
		$content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer le transtypage")) . '</p>';
	$content .= '</form><br /><br />';


$forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'limit' => 0);
$forums = false;
if ($transtype == 'yes') {
	// Mise en production
	$forums = elgg_get_entities($forums_opt);
} else {
	// Simulation "réelle" limitée à un groupe
	// attention pour les réponses, container = sujet de forum (pas groupe)
	// Note : on ne vérifie pas l'existence du groupe de manière à traiter aussi des contenus dont le groupe n'existerait plus ou serait archivé
	if ($group_guid > 1) {
		$forums_opt['container_guid'] = $group_guid;
		// "Simulation" : on limite les risques (note : fait dans la boucle de transtypage, afin de lister les sujets non convertis)
		//$forums_opt['limit'] = 1;
		$forums = elgg_get_entities($forums_opt);
	} else {
		$content .= '<p>' . "Vous devez définir soit un groupe dans lequel valider le fonctionnement du transtypage, soit ajouter ?transtype=yes à l'URL pour effectuer le transtypage sur l'ensemble des forums du site" . '</p>';
	}
}

/* Modifier : 
- groupforumtopic
	subtype: groupforumtopic => blog
	status: open|closed => comments_on: On|Off
	=> status: published

- discussion_reply
	subtype: discussion_reply => comment
	container_guid: 5161
*/

function theme_inria_update_groupforumtopic_as_blog($ent) {
	if (elgg_instanceof($ent, 'object', 'groupforumtopic')) {
		// Transtyping to blog
		$dbprefix = elgg_get_config('dbprefix');
		$groupforumtopic_subtype_id = get_subtype_id('object', 'groupforumtopic');
		$blog_subtype_id = get_subtype_id('object', 'blog');
		$result = update_data("UPDATE {$dbprefix}entities set subtype='$blog_subtype_id' WHERE guid=$ent->guid");
		if ($result) {
			// Update metadata
			if ($ent->status == 'closed') { $ent->comments_on = 'Off'; } else { $ent->comments_on = 'On'; }
			if ($ent->access_id === 0) { $ent->status = 'draft'; } else { $ent->status = 'published'; }
		}
		
		// Transtype discussion replies
		$replies = elgg_get_entities(array('type' => 'object', 'subtype' => 'discussion_reply', 'container_guid' => $ent->guid, 'limit' => false));
		$replies_text = '';
		foreach($replies as $reply) {
			$replies_text .= theme_inria_update_discussion_reply_as_comment($reply);
		}
		return "groupforumtopic {$ent->guid} updated<br />" . $replies_text;
	}
	return false;
}

function theme_inria_update_discussion_reply_as_comment($ent) {
	if (elgg_instanceof($ent, 'object', 'discussion_reply')) {
		$dbprefix = elgg_get_config('dbprefix');
		$discussion_reply_subtype_id = get_subtype_id('object', 'discussion_reply');
		$comment_subtype_id = get_subtype_id('object', 'comment');
		$result = update_data("UPDATE {$dbprefix}entities set subtype='$comment_subtype_id' WHERE guid=$ent->guid");
		return "discussion_reply {$ent->guid} updated<br />";
	}
	return false;
}


if ($forums) {
	foreach ($forums as $k => $ent) {
		// Transformation des sujets et réponses des forums en articles
		//$content .= elgg_view_entity($ent);
		$content .= '<p>' . "$ent->guid $ent->title $ent->subtype $ent->access_id $ent->status";
		
		// "Simulation" : on limite les risques
		//if (($transtype == 'yes') || ($k < 1)) {
		if (($transtype == 'yes') || ($k < 1)) {
			if (elgg_instanceof($ent, 'object', 'groupforumtopic')) {
				$content .= theme_inria_update_groupforumtopic_as_blog($ent);
			} else if (elgg_instanceof($ent, 'object', 'discussion_reply')) {
				$content .= theme_inria_update_discussion_reply_as_comment($ent);
			}
			$content .= " => Transtypage effectué" . '</p>';
			$ent->save();
		} else {
			$content .= " => Pas d'action effectuée" . '</p>';
		}
	}
} else {
	if ($group_guid > 0) {
		$content .= '<p>' . "Aucun sujet de discussion trouvé dans ce groupe" . '</p>';
	} else {
		$content .= '<p>' . "Aucun sujet de discussion trouvé dans l'ensemble du site" . '</p>';
	}
}


// Désactivation des forums dans les groupes (si plus rien à convertir)
// Ensure we get all topics and replies (no orphans)
$remaining_forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'count' => true);
$remaining_forums = elgg_get_entities($forums_opt);
if ($remaining_forums === 0) {
	$content .= '<h3>' . "Désactivation des forums" . '</h3>';
	if ($transtype == 'yes') {
		$groups = elgg_get_entities(array('type' => 'group', 'limit' => 0));
		foreach($groups as $ent) {
			if ($group->forum_enable != 'no') {
				$group->forum_enable = 'no';
				$content .= "Forum désactivé dans {$group->name}<br />";
			}
		}
		$content .= '<p><strong>' . "Tous les forums ont bien été désactivés. Le transtypage des forums en blogs est terminé !" . '</strong></p>';
	}
}

$content .= '</div>';


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));

// Affichage
echo elgg_view_page($title, $body);

