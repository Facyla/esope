<?php
/**
 * Create pads, or edit pad settings
 *
 */

// What should we do ?
$request = get_input('request', false);

// padID is used for existing pad edit
$padID = get_input('padID', false);
// Public is the public status of the pad : can be set to 'true' (public), 'false' (not public), or null or empty (don't change)
$public = get_input('public', null);
if ($public == 'yes') { $public = true; } else if ($public == 'no') { $public = false; } else { $public = null; }
// Password is the password of the pad : can be set to a value (the password), 'no' (no password), or empty value (don't change)
$password = get_input('password', null);
if ($password == 'no') { $password = false; } else if (empty($password)) { $password = null; }
// Title is used for new pads, it's the full name for public pads, and the end of group pads name
$title = get_input('title');
// Container_guid is used for group pad name mapper, as a group represents an Elgg user, group or object
$container_guid = get_input('container_guid');

if ($request) {
	switch ($request) {
		
		// CREATION DE NOUVEAU PAD EN ACCESS RESTREINT
		case 'creategrouppad':
			// Default access group is pad container (=creator/owner if no specific context)
			if (empty($container_guid)) $container_guid = elgg_get_logged_in_user_guid();
			if (!empty($title)) {
				$padID = elgg_etherpad_create_pad($title, $container_guid, $public, $password);
				$result = 'Pad "' . $padID . '" créé';
				/*
				$result = ' &nbsp; <a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher</a> ';
				$result = ' &nbsp; <a href="' . $CONFIG->url . 'pad/edit/' . $padID . '"><i class="fa fa-gear"></i> Modifier</a> ';
				*/
				$forward = 'pad/view/' . $padID;
			} else {
				register_error('Nom du pad et/ou du groupe manquant : &padName=XXXX&groupName=YYYY');
			}
			break;
		
		// CREATION DE NOUVEAU PAD PUBLIC
		case 'createpad':
			if (!empty($title)) {
				$padID = elgg_etherpad_create_pad($title, false, $public, $password);
				$result = 'Pad "' . $padID . '" créé';
				/*
				$result = ' &nbsp; <a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher</a> ';
				$result = ' &nbsp; <a href="' . $CONFIG->url . 'pad/edit/' . $padID . '"><i class="fa fa-gear"></i> Modifier</a> ';
				*/
				$forward = 'pad/view/' . $padID;
			} else {
				register_error('Nom du pad manquant : &padName=XXXX');
			}
			break;
		
		case 'editpad':
			$result = elgg_etherpad_set_pad_access($padID, $public, $password);
			system_message("Pad modified, please check that your changes have been properly updated.");
			$forward = 'pad/edit/' . $padID;
			break;
		
		// SUPPRESSION D'UN PAD
		case 'delete':
			//$result = elgg_etherpad_set_pad_access($padID, $public, $password);
			system_message("Pad $padID deleted status : $result");
			$forward = 'pad/edit/' . $padID;
			break;
		
		// GESTION DES ACCES
		case 'makeprivate':
			$public = false;
			$password = null;
			$result = elgg_etherpad_set_pad_access($padID, $public, $password);
			system_message("Pad $padID public status set to private : $result");
			$forward = 'pad/edit/' . $padID;
			break;
		
		case 'makepublic':
			$public = true;
			$password = null;
			$result = elgg_etherpad_set_pad_access($padID, $public, $password);
			system_message("Pad $padID public status set to public : $result");
			$forward = 'pad/edit/' . $padID;
			break;
		
		case 'changepassword':
			$public = null;
			$result = elgg_etherpad_set_pad_access($padID, $public, $password);
			system_message("Pad $padID password set to $password : $result");
			$forward = 'pad/edit/' . $padID;
			break;
		
		case 'removepassword':
			$public = null;
			$password = false;
			$result = elgg_etherpad_set_pad_access($padID, $public, $password);
			system_message("Pad $padID password removed status : $result");
			$forward = 'pad/edit/' . $padID;
			break;
		
		default:
			register_error('No action chosen');
	}
	
	system_message($result);
}



if ($forward) { forward($forward); }
forward(REFERER);


