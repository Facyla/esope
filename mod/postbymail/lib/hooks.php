<?php


// Postbymail CRON : vérifie les mails non lus et les traite - check mails and publish...
function postbymail_cron_handler($hook, $entity_type, $returnvalue, $params) {
	//error_log("MARQUEUR DU CRON DU START.PHP DE POSTBYMAIL");
	// require libraries
	elgg_load_library('elgg:postbymail');
	
	require_once(elgg_get_plugins_path() . 'postbymail/pages/checkandpost.php');
	$resulttext = elgg_echo("postbymail:mailprocessed");
	return $returnvalue . $resulttext;
}


// Ce hook (sensible) se contente ici de passer le GUID de l'objet commenté
// @TODO : devenu inutile avec Elgg 1.12
function postbymail_send_before_notifications_hook($hook, $entity_type, $returnvalue, $params) {
	$object = $params['event']->getObject();
	if (elgg_instanceof($object, 'object')) {
		global $postbymail_guid;
		if (!$postbymail_guid || empty($postbymail_guid)) { $postbymail_guid = $object->guid; }
	}
	// pas de modification du comportement (défini par ailleurs)
	return $returnvalue;
}


// Ce hook modifie le contenu du message de notification des contenus (object) et y ajoute le bloc de réponse
// S'appuie sur le hook : create / subtype
function postbymail_prepare_notification($hook, $type, $notification, $params) {
	// Skip if missing required parameters
	if (!postbymail_check_required()) { return $returnvalue; }
	
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];
	
	$message_body = $notification->body;
	$postbymail_guid = $entity->guid;
	
	//$debug = elgg_get_plugin_setting('debug', 'postbymail');
	//if ($debug == 'yes') error_log("DEBUG POSTBYMAIL : $postbymail_guid / $entity->guid || $hook, $type, $message_body, " . print_r($params, true));
	//error_log("DEBUG POSTBYMAIL : $postbymail_guid => $recipient->guid / $hook, $type, $entity_type");
	
	// Add instructions to object notifications
	if (elgg_instanceof($entity, 'object')) {
		
		// The Wire specific notice : 140 chars limit (or 250...)
		if (elgg_instanceof($entity, 'object', 'thewire')) {
			$message_body = elgg_echo('postbymail:thewire:charlimitnotice', array(), $language) . $message_body;
		}
		
		// Comments : we need to use the commented entity to reply, not the comment itself !
		if (elgg_instanceof($entity, 'object', 'comment')) {
			$postbymail_guid = $entity->container_guid;
		}
		
		// Note : all new content and comments use this, and also the messages
		$message_body = postbymail_add_to_message($message_body, $postbymail_guid, $language);
	/*
	} else {
		// Other cases (should not happen)
		// On ne peut ajouter le lien que si on a l'info sur l'entité concernée...
		if (!empty($postbymail_guid)) { $message_body = postbymail_add_to_message($message_body, $postbymail_guid); }
	*/
	}
	
	// Update notification message body
	if (!empty($message_body)) { $notification->body = $message_body; }
	
	return $notification;
}


// Ce hook ajoute le bloc de notification aux messages de tous types
// Prend en charge : object, annotation
// @TODO : old function, should not be used anymore
function postbymail_add_to_notify_message_hook($hook, $entity_type, $returnvalue, $params) {
	
	// Skip if missing required parameters
	if (!postbymail_check_required()) { return $returnvalue; }
	
	global $postbymail_guid;
	$entity = $params['entity'];
	$annotation = $params['annotation'];
	//$to_entity = $params['to_entity'];
	//$method = $params['method'];
	//error_log("DEBUG POSTBYMAIL : $postbymail_guid / $entity->guid || $hook, $entity_type, $returnvalue, " . print_r($params, true));
	
	// Add instructions to object notifications
	if (elgg_instanceof($entity, 'object')) {
		// The Wire specific notice : 140 chars limit
		if (elgg_instanceof($entity, 'object', 'thewire')) {
			$returnvalue = elgg_echo('postbymail:thewire:charlimitnotice') . $returnvalue;
		}
		// Note : all new content and comments use this, and also the messages
		if (empty($postbymail_guid)) { $postbymail_guid = $entity->guid; }
		$returnvalue = postbymail_add_to_message($returnvalue, $postbymail_guid);
	
	// Add instructions to annotations (forum replies)
	} else if ($annotation instanceof ElggAnnotation) {
		// Only forum replies should use this
		// Dans ce cas le mode d'envoi peut demander de déterminer l'entité concernée
		global $postbymail_guid;
		// Note : always get commented entity from annotation ?
		if (empty($postbymail_guid)) {
			$postbymail_guid = $annotation->entity_guid;
		}
		$returnvalue = postbymail_add_to_message($returnvalue, $postbymail_guid);
	
	// Other cases
	} else {
		// On ne peut ajouter le lien que si on a l'info sur l'entité concernée...
		if (!empty($postbymail_guid)) { $returnvalue = postbymail_add_to_message($returnvalue, $postbymail_guid); }
	}
	
	return $returnvalue;
}





// Permet de notifier le contenu du commentaire au lieu du sujet commenté
// @todo : si pls réponses en //, seul l'un des contenus est bon :-(
/*
function postbymail_groupforumtopic_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (elgg_instanceof($entity, 'groupforumtopic')) {
		$descr = $entity->description;
		$title = $entity->title;
		$url = $entity->getURL();
		$owner = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();
		$reply = get_input('group_topic_post'); // Note : vide si via cron et import mail..
		if (empty($reply)) {
			// Note : si pls messages publiés en même temps on n'aura que le dernier
			global $postbymail_content;
			$reply = $postbymail_content;
		}
		//error_log("POSTBYMAIL start : via le site = " . $reply);
		//error_log("POSTBYMAIL start : via postbymail = " . $postbymail_content);
		// Selon les cas, on notifie avec le sujet initial ou la réponse
		if (!empty($reply)) {
			// Réponse à un sujet de forum
			// @TODO notifie avec l'auteur du post initial et non celui qui publie !
			// cf. http://reference.elgg.org/1.8/annotations_8php_source.html#l00065
			$member_name = elgg_echo('postbymail:someone');
			return elgg_echo('groups:notification:reply', array(
				$member_name,
				$group->name,
				$entity->title,
				$reply,
				$entity->getURL()
			));
		} else {
			// Nouveau sujet de forum
			return elgg_echo('groups:notification', array(
				$owner->name,
				$group->name,
				$entity->title,
				$entity->description,
				$entity->getURL()
			));
		}
	}
	
	return null;
}
*/


