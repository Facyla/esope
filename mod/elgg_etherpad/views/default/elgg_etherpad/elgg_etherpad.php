<?php
/* Display some info about a pad in a single line
 * Note that pads are organised this way :
 * - Public pads
 * - Group pads : properties can be changed
 * -- Private/Public access
 * -- No password / Password protected
 */

$padID = elgg_extract('padID', $vars, false);

$body = '';

if (!$padID) { return; }

// Only display pads we can view...
if (!elgg_etherpad_can_read_pad($padID)) {
	echo "(No access to $padID)";
	return;
}

$server = elgg_get_plugin_setting('server', 'elgg_etherpad');

if (strpos($padID, '$')) {
	$pad_name = explode('$', $padID);
	$group_id = $pad_name[0];
	$pad_name = $pad_name[1];
} else {
	$pad_name = $padID;
}


// Pad type and title
if ($group_id) {
	$pad_type = '<i class="fa fa-eye-slash" title="Pad associé au groupe d\'accès : '. $group_id . '"></i>';
} else {
	$pad_type = '<i class="fa fa-eye"></i>';
}
$pad_title = '<strong><a href="' . $CONFIG->url . 'pad/view/' . $padID . '" title="Ouvrir et utiliser le pad">' . ucfirst($pad_name) . '</a></strong>';


// Edit settings and access rights apply only to group pads !
if ($group_id) {
	$isPasswordProtected = elgg_etherpad_is_password_protected($padID);
	$isPublic = elgg_etherpad_is_public($padID);
	
	$pad_access = ' ';
	
	if ($isPublic == 'yes') {
		// Accès Public
		//$body .= '<span class="fa-stack" style="font-size:50%;><i class="fa fa-lock fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x"></i></span>';
		$pad_access .= '<i class="fa fa-unlock"></i>';
	} else if ($isPublic == 'no') {
		// Accès Privé
		$pad_access .= '<i class="fa fa-lock"></i>';
	}
	
	$pad_access .= ' ';
	if ($isPasswordProtected == 'yes') {
		// Avec mot de passe
		$pad_access .= '<i class="fa fa-key"></i> ';
	} else if ($isPasswordProtected == 'no') {
		// (sans mot de passe)
		$pad_access .= '<span class="fa-stack" style="font-size:60%;"><i class="fa fa-key fa-stack-1x"><i class="fa fa-ban fa-stack-2x"></i></span></i>';
	}
	
	//$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher le pad</a> ';
	
	if (elgg_etherpad_can_edit_pad($padID)) {
		$pad_edit .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/edit/' . $padID . '" title="Configurer le pad (visibilité, mot de passe)"><i class="fa fa-gear"></i></a> ';
	}
}

// Ssi pad public ou en accès public (avec ou sans mot de passe)
// car sinon on n'aura pas les autorisations pour y accéder
$pad_extlink = '';
if (!$group_id || ($isPublic == 'yes')) {
	$pad_extlink .= '&nbsp; <a href="' . $server . '/p/' . $padID . '" title="Ouvrir et utiliser le pad (adresse publique)" target="_blank"><i class="fa fa-external-link"></i></a>';
}

$body = '<p>' . $pad_type . $pad_access . '&nbsp; ' . $pad_title . $pad_extlink . $pad_edit . '</p>';


echo $body;

