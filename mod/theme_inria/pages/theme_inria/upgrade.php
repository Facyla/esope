<?php
/**
 * 
 */

admin_gatekeeper();

set_time_limit(0);

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

// Transformation des sujets et réponses des forums en articles
// Batch
function theme_inria_transtype_forums($transtype_ent, $getter, $options) {
	//$transtype_content .= elgg_view_entity($transtype_ent);
	$transtype_content .= "$transtype_ent->guid $transtype_ent->title : $transtype_ent->getSubtype(), access $transtype_ent->access_id, status $transtype_ent->status";

	// production ou Simulation
	$transtype_prod = get_input('transtype', 'no');
	if ($transtype_prod != 'yes') {
		$transtype_content .= " => simulation";
	} else {
		$transtype_content .= " => Transtypage : ";
		if (elgg_instanceof($transtype_ent, 'object', 'groupforumtopic')) {
			$transtype_content .= theme_inria_update_groupforumtopic_as_blog($transtype_ent);
		} else if (elgg_instanceof($transtype_ent, 'object', 'discussion_reply')) {
			$transtype_content .= theme_inria_update_discussion_reply_as_comment($transtype_ent);
		}
		$transtype_ent->save();
	}
	return true;
}

// Batch : désactivation forum + activation blog
function theme_inria_disable_forums($group, $getter, $options) {
	if (!elgg_instanceof($group, 'group')) { echo "Not a group"; return true; }
	
	$options = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'count' => true);
	$options['container_guid'] = $group->guid;
	$remaining = elgg_get_entities($options);
	if ($remaining > 0) { echo "{$group->guid} : Remaining topics, cannot disable<br />"; return true; }
	
	$transtype_prod = get_input('transtype', 'no');
	if ($transtype_prod != 'yes') {
		echo "Simulation : Forum désactivé et Blog activé dans {$group->name}<br />";
	} else {
		if ($group->forum_enable != 'no') {
			$group->forum_enable = 'no';
			$group->blog_enable = 'yes';
			echo "Forum désactivé et Blog activé dans {$group->name}<br />";
		}
	}
	return true;
}


// Convert forum topic to blog
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

// Convert discussion repluy to comment
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
$transtype_prod = get_input('transtype', 'no');
$upgrade_transtype = get_input('upgrade_transtype', false);

// Form
$transtype_content .= '<div id="inria-upgrade" class="">';
	$transtype_content .= "<p>Cette page regroupe des outils utiles lors des mises à jour.</p>";

	$transtype_content .= '<h3>Transtypage des sujets de forum en articles de blog</h3>';
	$transtype_content .= '<p><blockquote>' . "<strong>Cette opération est très délicate, et irréversible.</strong><br />Les sujets de discussion des forums seront transformés en articles de blog, et les réponses en commentaires. Ce transtypage ne produit pas de perte d'information, mais les forums d'origine seront détruits.<br />Afin de valider le fonctionnement du transtypage, cette opération peut être limitée dans un groupe précis, en indiquant son GUID : dans ce cas un seul sujet (et ses réponses) sera traité à la fois." . '</blockquote></p>';
	
	$transtype_remaining_forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'count' => true);
	if ($transtype_group_guid > 1) {
		$transtype_remaining_forums_opt['container_guid'] = $transtype_group_guid;
		$transtype_content .= "Transtypage limité au groupe $transtype_group_guid<br />";
	}
	$transtype_remaining_forums = elgg_get_entities($transtype_remaining_forums_opt);
	if ($transtype_remaining_forums === 0) {
		$transtype_content .= '<p>' . "Plus aucun sujet ou réponse de forum : désactivation des forums possible" . '</p>';
	} else  {
		$transtype_content .= '<p>' . "Le site comporte " . $transtype_remaining_forums . " sujets de discussion et réponses." . '</p>';
	}
	
	$transtype_content .= '<form method="POST">';
		$transtype_content .= elgg_view('input/securitytoken');
		$transtype_content .= elgg_view('input/hidden', array('name' => 'upgrade_transtype', 'value' => 'yes'));
		$transtype_content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'transtype', 'value' => '', 'options_values' => ['no' => "Non (limité dans un groupe)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
		$transtype_content .= '<p><label>GUID du groupe ' . elgg_view('input/text', array('name' => 'group_guid', 'value' => $transtype_group_guid)) . '</label></p>';
		$transtype_content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer le transtypage")) . '</p>';
	$transtype_content .= '</form><br /><br />';

// Process
// Simulation "réelle" limitée à un groupe
// attention pour les réponses, container = sujet de forum (pas groupe)
// Note : on ne vérifie pas l'existence du groupe de manière à traiter aussi des contenus dont le groupe n'existerait plus ou serait archivé
if ($upgrade_transtype == 'yes') {
	$transtype_forums_opt = array('type' => 'object', 'subtype' => array('groupforumtopic', 'discussion_reply'), 'limit' => 0);
	$transtype_forums = false;
	// Limitation dans un groupe
	if ($transtype_group_guid > 1) {
		$transtype_forums_opt['container_guid'] = $transtype_group_guid;
		$transtype_content .= "<strong>Transtypage limité au groupe $transtype_group_guid</strong><br />";
	} else {
		$transtype_content .= "<strong>Transtypage de tous les forums du site</strong><br />";
	}
	// Lancement du batch
	$batch = new ElggBatch('elgg_get_entities', $transtype_forums_opt, 'theme_inria_transtype_forums', 10);
	if (!$transtype_forums_opt) {
		if ($transtype_group_guid > 0) {
			$transtype_content .= '<p>' . "Aucun forum trouvé dans ce groupe" . '</p>';
		} else {
			$transtype_content .= '<p>' . "Aucun forum trouvé dans l'ensemble du site" . '</p>';
		}
	}

	// Désactivation des forums dans les groupes (si plus rien à convertir)
	// Ensure we get all topics and replies (no orphans)
	$transtype_content .= '<h3>' . "Désactivation des forums" . '</h3>';
	if ($transtype_prod == 'yes') {
		$disable_groups_opt = array('type' => 'group', 'limit' => 0);
		if ($transtype_group_guid > 1) {
			$disable_groups_opt['guids'] = $transtype_group_guid;
		}
		$batch = new ElggBatch('elgg_get_entities', $disable_groups_opt, 'theme_inria_disable_forums', 10);
		$transtype_content .= '<p><strong>' . "Désactivation des forums et activation des blogs !" . '</strong></p>';
	} else {
		$transtype_content .= '<p><strong>' . "Simulation de désactivation des forums" . '</strong></p>';
	}
}

$transtype_content .= '</div>';




// Fusion skills et interests
// Batch
function theme_inria_merge_skills_interests($user, $getter, $options) {
	if (!elgg_instanceof($user, 'user')) { return false; }
	
	$skills_merge_prod = get_input('skills_merge_prod', false);
	if ($skills_merge_prod == 'yes') {
		$user->skills = array_merge((array)$user->skills, (array)$user->interests);
		$user->interests = null;
		echo $user->guid . ' : skills et interests fusionnés dans skills' . print_r($user->skills, true) . '<br />';
	} else {
		$skills = array_merge((array)$user->skills, (array)$user->interests);
		echo $user->guid . ' : fusion de skills (' . print_r($user->skills, true) . ') et interests (' . print_r($user->skills, true) . ') => ' . print_r($skills, true) . '<br />';
	}
	
	return true;
}

// Form
$merge_user_guid = get_input('merge_user_guid', false);
$skills_merge_content .= '<h3>Fusion skills + interests => skills</h3>';
$skills_merge_content .= '<form method="POST">';
	$skills_merge_content .= elgg_view('input/securitytoken');
	$skills_merge_content .= elgg_view('input/hidden', array('name' => 'skills_merge', 'value' => 'yes'));
	$skills_merge_content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'skills_merge_prod', 'value' => '', 'options_values' => ['no' => "Non (simulation)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
	$skills_merge_content .= '<p><label>GUID du membre ' . elgg_view('input/text', array('name' => 'merge_user_guid', 'value' => $merge_user_guid)) . '</label></p>';
	$skills_merge_content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer fusion des skills et interests dans skills")) . '</p>';
$skills_merge_content .= '</form><br /><br />';

// Process
$skills_merge = get_input('skills_merge', false);
if ($skills_merge == 'yes') {
	$users_options = array('types' => 'user', 'limit' => 0);
	if ($merge_user_guid) { $users_options['guids'] = $merge_user_guid; }
	$batch = new ElggBatch('elgg_get_entities', $users_options, 'theme_inria_merge_skills_interests', 10);
}





// @TODO Conversion accès Membres du site => Inria seulement
// Batch
function theme_inria_entity_access_membertoinria($entity, $getter, $options) {
	if (!elgg_instanceof($entity, 'object') && !elgg_instanceof($entity, 'group')) { return true; }
	if ($entity->access_id != ACCESS_LOGGED_IN) { return true; }
	
	// Skip some special objects, or better filter only those that should be explictely updated
	$update_subtypes = array('blog', 'comment', 'event_calendar', 'groupforumtopic', 'discussion_reply', 'bookmarks', 'file', 'page', 'page_top', 'thewire', 'feedback', 'newsletter', 'poll', 'survey');
	if (elgg_instanceof($entity, 'object')) {
		$subtype = $entity->getSubtype();
		if (!in_array($subtype, $update_subtypes)) { echo "Wrong subtype<br />"; return true; }
	}
	
	
	$inria_collection = access_collections_get_collection_by_name('profiletype:inria');
	if ($inria_collection && !empty($inria_collection->id)) {
		$inria_access_id = $inria_collection->id;
		echo $entity->getType() . " $entity->guid " . $entity->getSubtype() . " : access $entity->access_id => {$inria_collection->id} => ";
		$production = get_input('access_update_prod', false);
		if ($production == 'yes') {
			$entity->access_id = $inria_collection->id;
			echo "OK !";
		} else { echo "Simulation"; }
		echo '<br />';
	}
	return true;
}

// Form
$access_update = get_input('access_update', false);
$access_content .= '<h3>Mise à niveau des accès (Membres Iris => Inria seulement)</h3>';
$access_content .= '<form method="POST">';
	$access_content .= elgg_view('input/securitytoken');
	$access_content .= elgg_view('input/hidden', array('name' => 'access_update', 'value' => 'yes'));
	$access_content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'access_update_prod', 'value' => '', 'options_values' => ['no' => "Non (simulation)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
	$access_content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer mise à niveau des droits d'accès")) . '</p>';
$access_content .= '</form><br /><br />';

// Process
$access_update = get_input('access_update', false);
if ($access_update == 'yes') {
	// Access : Members => Inria access
	$entities_opt = array('types' => array('object', 'group'), 'access_id' => ACCESS_LOGGED_IN, 'limit' => 0);
	$batch = new ElggBatch('elgg_get_entities', $entities_opt, 'theme_inria_entity_access_membertoinria', 50);
	/*
	$groups_opt = array('types' => 'group', 'access_id' => ACCESS_LOGGED_IN, 'limit' => 10);
	$batch = new ElggBatch('elgg_get_entities', $groups_opt, 'theme_inria_entity_access_membertoinria', 50);
	*/
}

/*
	Contenus ; y compris les Champs de profil = contenu (object)
	Groupes
	Etapes : 
		1. Membres Iris => Inria seulement
		2. Tout internaute => Membres Iris : inutile car walled garden activé
*/



// @TODO Activation des notifications 'site'
$notifications_content .= '<h3>Activation systématique des notifications via le site</h3>';

// Batch
function theme_inria_force_user_site_notifications($user, $getter, $options) {
	if (!elgg_instanceof($user, 'user')) { return false; }
	
	$notifications = get_input('notifications', false);
	if ($notifications == 'yes') { $simulate = false; } else { $simulate = true;  }
	
	$notifications_content .= "User {$user->guid} {$user->name} : ";
	// pour ses propres contenus (réglage global)
	if ($simulate) {
		$notifications_content .= "<br /> - notifications personnelles : aucune action";
	} else {
		set_user_notification_setting($user->guid, 'site', true);
		$notifications_content .= " - notifications personnelles : activées";
	}
	
	// pour les groupes
	// Get group memberships and condense them down to an array of guids
	$groups = array();
	$options = array('relationship' => 'member', 'relationship_guid' => $user->guid, 'type' => 'group', 'limit' => false);
	if ($groupmemberships = elgg_get_entities_from_relationship($options)) {
		$notifications_content .= "<br /> - notifications pour les groupes : ";
		foreach ($groupmemberships as $group) {
			if ($simulate) {
				$notifications_content .= "{$group->guid} {$group->name} : aucune action, ";
			} else {
				elgg_add_subscription($user->guid, 'site', $group);
				$notifications_content .= "{$group->guid} {$group->name} : activé, ";
			}
		}
	}

	// pour ses contacts
	$friends = $user->getFriends(array('limit' => 0));
	if ($friends) {
		$notifications_content .= "<br /> - notifications pour les contacts : ";
		foreach($friends as $friend) {
			if ($simulate) {
				$notifications_content .= "{$friend->guid} {$friend->name} : aucune action, ";
			} else {
				elgg_add_subscription($user->guid, 'site', $friend->guid);
				$notifications_content .= "{$friend->guid} {$friend->name} : activé, ";
			}
		}
	}

	// pour ses collections
	if ($collections = get_user_access_collections($user->guid)) {
		$collections_ids[] = -1;
		foreach ($collections as $collection) { $collections_ids[] = $collection->id; }
		$notifications_content .= "<br /> - notifications pour les listes de contacts : " . implode(', ', $collections_ids);
		if ($simulate) {
			$notifications_content .= " : aucune action";
		} else {
			$user->collections_notifications_preferences_site = $collections_ids;
			$notifications_content .= " : activé";
		}
	}
	
	// Pour les contenus commentés (réglage global)
	if (elgg_is_active_plugin('comment_tracker')) {
		$site = elgg_get_site_entity();
		if ($simulate) {
			$notifications_content .= "<br /> - notifications pour les contenus commentés : aucune action";
		} else {
			remove_entity_relationship($user->guid, 'block_comment_notifysite', $site->guid);
			$notifications_content .= "<br /> - notifications pour les contenus commentés : activé";
		}
	}
	
	echo $user->guid . ' : ' . $notifications_content . '<br />';
	return true;
}

// Form
$notifications_content .= '<form method="POST">';
	$notifications_content .= elgg_view('input/securitytoken');
	$notifications_content .= elgg_view('input/hidden', array('name' => 'upgrade_notifications', 'value' => 'yes'));
	$notifications_content .= '<p><label>Mise en production ' . elgg_view('input/select', array('name' => 'notifications', 'value' => '', 'options_values' => ['no' => "Non (simulation)", 'yes' => "Oui (mise en production)"])) . '</label></p>';
	$notifications_content .= '<p>' . elgg_view('input/submit', array('value' => "Démarrer activation des notifications site")) . '</p>';
$notifications_content .= '</form><br /><br />';

// Process
$upgrade_notifications = get_input('upgrade_notifications', false);
if ($upgrade_notifications == 'yes') {
	$notifications = get_input('notifications', false);
	if ($notifications == 'yes') { $simulate_notifications = false; } else { $simulate_notifications = true;  }
	/*
	$users = elgg_get_entities(array('type' => 'user', 'limit' => false));
	foreach($users as $user) { theme_inria_force_user_site_notifications($user, $simulate_notifications); }
	*/
	$users_options = array('types' => 'user', 'limit' => false);
	$batch = new ElggBatch('elgg_get_entities', $users_options, 'theme_inria_force_user_site_notifications', 10);
}



/* Batch example
error_log("CRON : LDAP start " . date('Ymd H:i:s'));
		$debug_0 = microtime(TRUE);
		$users_options = array('types' => 'user', 'limit' => 0);
		$batch = new ElggBatch('elgg_get_entities', $users_options, 'theme_inria_cron_ldap_check', 10);
		$debug_1 = microtime(TRUE);
		error_log("CRON : LDAP end " . date('Ymd H:i:s') . " => " . round($debug_1-$debug_0, 4) . " secondes");
		echo '<p>' . elgg_echo('theme_inria:cron:ldap:done') . '</p>';

function theme_inria_cron_ldap_check($user, $getter, $options) {

*/



$content .= $transtype_content;
$content .= '<hr />';
$content .= $notifications_content;
$content .= '<hr />';
$content .= $skills_merge_content;
$content .= '<hr />';
$content .= $access_content;

//$content .= $transtype_content;

$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));

// Affichage
echo elgg_view_page($title, $body);

