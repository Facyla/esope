<?php
// Publication de nouveaux contenus par email
$mailpost = elgg_get_plugin_setting('mailpost', 'postbymail');

// Extend group profile only if post by email is activated for groups
if (($mailpost == 'grouponly') || ($mailpost == 'userandgroup')) {
	
	$group = elgg_extract("entity", $vars);
	if (elgg_instanceof($group, "group")) {
		$content = '';
		
		$content .= '<div style="padding:1ex;">';
		
		// Génération d'une nouvelle clef, si demandé : GUID + k + md5 aléatoire
		$new_key = get_input('new_key', false);
		if ($new_key == 'change') {
			// Note sur la clef : on utilise toutes les variables de session pour générer une chaîne de longueur variable, avec un grain d'aléatoire supplémentaire
			$key = $vars['entity']->guid . 'k' . md5(microtime() . print_r($vars['entity'], true) . mt_rand());
			$vars['entity']->pubkey = $key;
			system_message(elgg_echo('postbymail:groupsettings:publicationkey:changed'));
			forward($vars['url'] . 'groups/edit/' . $vars['entity']->guid);
		}
		
		// Suppression de la clef, si demandé : vide = désactivé
		$delete_key = get_input('delete_key', false);
		if ($delete_key == 'delete') {
			$vars['entity']->pubkey = '';
			system_message(elgg_echo('postbymail:groupsettings:publicationkey:deleted'));
			forward($vars['url'] . 'groups/edit/' . $vars['entity']->guid);
		}
	
		// Mail à utiliser pour les publications
		$key = $vars['entity']->pubkey;
		if (empty($key)) {
			$post_mail = elgg_echo('postbymail:groupsettings:publicationkey:nomail');
		} else {
			$post_email = get_plugin_setting('username', 'postbymail');
			$post_email = explode('@', $post_email);
			$mail_username = $post_email[0];
			$mail_domain = $post_email[1];
			$mail_params = "+key=$key";
			if ($post_subtype) $mail_params .= "&subtype=$post_subtype";
			if ($post_access) $mail_params .= "&access=$post_access";
			$post_mail = $mail_username . $mail_params . '@' . $mail_domain;
			$post_mail = '<a href="mailto:' . $post_mail . '">' . $post_mail . '</a>';
		}
	
		$content .= '<h4>' . elgg_echo('postbymail:groupsettings:publicationkey') . '</h4>';
		// Explications clef de publication
		$content .= '<p>' . elgg_echo('postbymail:groupsettings:publicationkey:help') . '</p>';
		$content .= '<p><strong>' . elgg_echo('postbymail:groupsettings:publicationkey:email') . '&nbsp;: ' . $post_mail . '</strong></p>';
		$content .= '<p><a href="?group_guid=' . $vars['entity']->guid. '&new_key=change" class="elgg-button elgg-button-action">&raquo;&nbsp;' . elgg_echo('postbymail:groupsettings:publicationkey:change') . '</a></p>';
	
		// Configuration de la clef de publication (vide = désactivé, sinon = activé)
		$content .= '<p>' . elgg_view('input/text', array('name' => 'params[pubkey]', 'value' => $vars['entity']->pubkey, 'disabled' => 'disabled', 'style' => 'width:60%;'));
		$content .= ' &nbsp; <a href="?group_guid=' . $vars['entity']->guid. '&delete_key=delete" class="elgg-button elgg-button-delete">&raquo;&nbsp;' . elgg_echo('postbymail:groupsettings:publicationkey:delete') . '</a></p>';
		$content .= "</div>";
		
		// Render group module
		echo elgg_view_module("info", elgg_echo('postbymail'), $content);
	}
}

