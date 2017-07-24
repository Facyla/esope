<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

admin_gatekeeper();



/* Transtypage des forums en articles de blog
Modifier : 
- groupforumtopic
	subtype: groupforumtopic => blog
	status: open|closed => comments_on: On|Off
	=> status: published

- discussion_reply
	subtype: discussion_reply => comment
	container_guid: 5161

Désactivation des forums dans les groupes (si plus rien à convertir)
*/

function theme_inria_update_groupforumtopic_as_blog($transtype_ent) {
	if (elgg_instanceof($transtype_ent, 'object', 'groupforumtopic')) {
		// Transtyping to blog
		$transtype_dbprefix = elgg_get_config('dbprefix');
		$transtype_groupforumtopic_subtype_id = get_subtype_id('object', 'groupforumtopic');
		$transtype_blog_subtype_id = get_subtype_id('object', 'blog');
		$transtype_result = update_data("UPDATE {$transtype_dbprefix}entities set subtype='$transtype_blog_subtype_id' WHERE guid=$transtype_ent->guid");
		if ($transtype_result) {
			// Update metadata
			if ($transtype_ent->status == 'closed') { $transtype_ent->comments_on = 'Off'; } else { $transtype_ent->comments_on = 'On'; }
			if ($transtype_ent->access_id === 0) { $transtype_ent->status = 'draft'; } else { $transtype_ent->status = 'published'; }
		}
		
		// Transtype discussion replies
		$transtype_replies = elgg_get_entities(array('type' => 'object', 'subtype' => 'discussion_reply', 'container_guid' => $transtype_ent->guid, 'limit' => false));
		$transtype_replies_text = '';
		foreach($transtype_replies as $transtype_reply) {
			$transtype_replies_text .= theme_inria_update_discussion_reply_as_comment($transtype_reply);
		}
		return "groupforumtopic {$transtype_ent->guid} updated<br />" . $transtype_replies_text;
	}
	return false;
}

function theme_inria_update_discussion_reply_as_comment($transtype_ent) {
	if (elgg_instanceof($transtype_ent, 'object', 'discussion_reply')) {
		$transtype_dbprefix = elgg_get_config('dbprefix');
		$transtype_discussion_reply_subtype_id = get_subtype_id('object', 'discussion_reply');
		$transtype_comment_subtype_id = get_subtype_id('object', 'comment');
		$transtype_result = update_data("UPDATE {$transtype_dbprefix}entities set subtype='$transtype_comment_subtype_id' WHERE guid=$transtype_ent->guid");
		return "discussion_reply {$transtype_ent->guid} updated<br />";
	}
	return false;
}

$transtype_content = '';
$sidebar = '';

$transtype_group_guid = get_input('group_guid');
$transtype_transtype = get_input('transtype', 'no');


$transtype_content .= '<div id="inria-upgrade" class="">';
	$transtype_content .= "<p>Cette page regroupe des outils utiles lors des mises à jour.</p>";

	$transtype_content .= '<h3>Transtypage des sujets de forum en articles de blog</h3>';
	$transtype_content .= '<p><blockquote>' . "<strong>Cette opération est très délicate, et irréversible.</strong><br />Les sujets de discussion des forums seront transformés en articles de blog, et les réponses en commentaires. Ce transtypage ne produit pas de perte d'information, mais les forums d'origine seront détruits.<br />Afin de valider le fonctionnement du transtypage, cette opération peut être limitée dans un groupe précis, en indiquant son GUID : dans ce cas un seul sujet (et ses réponses) sera traité à la fois." . '</blockquote></p>';
	
	$transtype_remaining_forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'count' => true);
	$transtype_remaining_forums = elgg_get_entities($transtype_remaining_forums_opt);
	if ($transtype_remaining_forums === 0) {
		$transtype_content .= '<p>' . "Plus aucun sujet ou réponse de forum : désactivation des forums possible" . '</p>';
	} else  {
		$transtype_content .= '<p>' . "Le site comporte " . $transtype_remaining_forums . " sujets de discussion et réponses." . '</p>';
	}
	
	/// Transtype form
	$transtype_content .= '<form method="POST">';
		$transtype_content .= elgg_view('input/securitytoken');
		$transtype_content .= elgg_view('input/hidden', array('name' => 'upgrade_transtype', 'value' => 'yes'));
		$transtype_content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'transtype', 'value' => '', 'options_values' => ['no' => "Non (limité dans un groupe)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
		$transtype_content .= '<p><label>GUID du groupe ' . elgg_view('input/text', array('name' => 'group_guid', 'value' => $transtype_group_guid)) . '</label></p>';
		$transtype_content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer le transtypage")) . '</p>';
	$transtype_content .= '</form><br /><br />';


$upgrade_transtype = get_input('upgrade_transtype', false);
if ($upgrade_transtype == 'yes') {
	$transtype_forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'limit' => 0);
	$transtype_forums = false;
	if ($transtype_transtype == 'yes') {
		// Mise en production
		$transtype_forums = elgg_get_entities($transtype_forums_opt);
	} else {
		// Simulation "réelle" limitée à un groupe
		// attention pour les réponses, container = sujet de forum (pas groupe)
		// Note : on ne vérifie pas l'existence du groupe de manière à traiter aussi des contenus dont le groupe n'existerait plus ou serait archivé
		if ($transtype_group_guid > 1) {
			$transtype_forums_opt['container_guid'] = $transtype_group_guid;
			// "Simulation" : on limite les risques (note : fait dans la boucle de transtypage, afin de lister les sujets non convertis)
			//$transtype_forums_opt['limit'] = 1;
			$transtype_forums = elgg_get_entities($transtype_forums_opt);
		} else {
			$transtype_content .= '<p>' . "Vous devez définir soit un groupe dans lequel valider le fonctionnement du transtypage, soit ajouter ?transtype=yes à l'URL pour effectuer le transtypage sur l'ensemble des forums du site" . '</p>';
		}
	}

	if ($transtype_forums) {
		foreach ($transtype_forums as $transtype_k => $transtype_ent) {
			// Transformation des sujets et réponses des forums en articles
			//$transtype_content .= elgg_view_entity($transtype_ent);
			$transtype_content .= '<p>' . "$transtype_ent->guid $transtype_ent->title $transtype_ent->subtype $transtype_ent->access_id $transtype_ent->status";
		
			// "Simulation" : on limite les risques
			//if (($transtype_transtype == 'yes') || ($transtype_k < 1)) {
			if (($transtype_transtype == 'yes') || ($transtype_k < 1)) {
				if (elgg_instanceof($transtype_ent, 'object', 'groupforumtopic')) {
					$transtype_content .= theme_inria_update_groupforumtopic_as_blog($transtype_ent);
				} else if (elgg_instanceof($transtype_ent, 'object', 'discussion_reply')) {
					$transtype_content .= theme_inria_update_discussion_reply_as_comment($transtype_ent);
				}
				$transtype_content .= " => Transtypage effectué" . '</p>';
				$transtype_ent->save();
			} else {
				$transtype_content .= " => Pas d'action effectuée" . '</p>';
			}
		}
	} else {
		if ($transtype_group_guid > 0) {
			$transtype_content .= '<p>' . "Aucun sujet de discussion trouvé dans ce groupe" . '</p>';
		} else {
			$transtype_content .= '<p>' . "Aucun sujet de discussion trouvé dans l'ensemble du site" . '</p>';
		}
	}

	// Désactivation des forums dans les groupes (si plus rien à convertir)
	// Ensure we get all topics and replies (no orphans)
	$transtype_remaining_forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'count' => true);
	$transtype_remaining_forums = elgg_get_entities($transtype_forums_opt);
	if ($transtype_remaining_forums === 0) {
		$transtype_content .= '<h3>' . "Désactivation des forums" . '</h3>';
		if ($transtype_transtype == 'yes') {
			$transtype_groups = elgg_get_entities(array('type' => 'group', 'limit' => 0));
			foreach($transtype_groups as $transtype_ent) {
				if ($transtype_group->forum_enable != 'no') {
					$transtype_group->forum_enable = 'no';
					$transtype_group->blog_enable = 'yes';
					$transtype_content .= "Forum désactivé et Blog activé dans {$transtype_group->name}<br />";
				}
			}
			$transtype_content .= '<p><strong>' . "Tous les forums ont bien été désactivés. Le transtypage des forums en blogs est terminé !" . '</strong></p>';
		}
	}

	$transtype_content .= '</div>';
}




// @TODO Fusion skills et interests



// @TODO Conversion accès Membres du site => Inria seulement



// @TODO Activation des notifications 'site'
function theme_inria_force_user_site_notifications($user) {
	if (!elgg_instanceof($user, 'user')) { return false; }
	// pour ses propres contenus (réglage global)
	set_user_notification_setting($user->guid, 'site', true);
	
	// pour les groupes
	// Get group memberships and condense them down to an array of guids
	$groups = array();
	$options = array('relationship' => 'member', 'relationship_guid' => $user->guid, 'type' => 'group', 'limit' => false);
	if ($groupmemberships = elgg_get_entities_from_relationship($options)) {
		foreach ($groupmemberships as $group) { elgg_add_subscription($user->guid, 'site', $group); }
	}

	// pour ses contacts
	$friends = $user->getFriends(array('limit' => 0));
	foreach($friends as $friend) { elgg_add_subscription($user->guid, 'site', $friend->guid); }

	// pour ses collections
	if ($collections = get_user_access_collections($user->guid)) {
		$collections_ids[] = -1;
		foreach ($collections as $collection) { $collections_ids[] = $collection->id; }
		$user->collections_notifications_preferences_site = $collections_ids;
	}
	
	// Pour les contenus commentés (réglage global)
	if (elgg_is_active_plugin('comment_tracker')) {
		$site = elgg_get_site_entity();
		remove_entity_relationship($user->guid, 'block_comment_notifysite', $site->guid);
	}
	
	return true;
}

$notifications_content .= '<form method="POST">';
	$notifications_content .= elgg_view('input/securitytoken');
	$notifications_content .= elgg_view('input/hidden', array('name' => 'upgrade_notifications', 'value' => 'yes'));
	$notifications_content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'transtype', 'value' => '', 'options_values' => ['no' => "Non (limité dans un groupe)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
	$notifications_content .= '<p><label>GUID du groupe ' . elgg_view('input/text', array('name' => 'group_guid', 'value' => $transtype_group_guid)) . '</label></p>';
	$notifications_content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer activation des notifications site")) . '</p>';
$notifications_content .= '</form><br /><br />';


$upgrade_notifications = get_input('upgrade_notifications', false);
if ($upgrade_notifications == 'yes') {
	$users = elgg_get_entities(array('type' => 'user', 'limit' => false));
	foreach($users as $user) { theme_inria_force_user_site_notifications($user); }
}




$content .= $transtype_content;
$content .= $notifications_content;
//$content .= $transtype_content;

$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));

// Affichage
echo elgg_view_page($title, $body);

