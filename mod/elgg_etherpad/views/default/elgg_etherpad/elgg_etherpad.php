<?php
// Display some info about a pad in a single line

$padID = elgg_extract('padID', $vars, false);

$body = '';

if ($padID) {
	
	if (strpos($padID, '$')) {
		$pad_name = explode('$', $padID);
		$group_id = $pad_name[0];
		$pad_name = $pad_name[1];
	} else {
		$pad_name = $padID;
	}
	
	$isPasswordProtected = elgg_etherpad_is_password_protected($padID);
	$isPublic = elgg_etherpad_is_public($padID);
	$body .= '<p><strong>Pad "' . $pad_name . '"</strong>';
	if ($group_id) $body .= " (groupe d'accès : $group_id)";
	
	$body .= '&nbsp;: &nbsp; ';
	if ($isPublic == 'yes') $body .= '<i class="fa fa-unlock"></i> Accès Public';
	else if ($isPublic == 'no') $body .= '<i class="fa fa-lock"></i> Accès Privé';
	
	$body .= ' &nbsp; ';
	if ($isPasswordProtected == 'yes') $body .= '<i class="fa fa-key"></i> Avec mot de passe';
	else if ($isPasswordProtected == 'no') $body .= '<i class="fa fa-key"></i> (sans mot de passe)';
	
	$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher le pad</a> ';
	
	$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/edit/' . $padID . '" class="elgg-button elgg-button-action" title="Modifier la visibilité et/ou le mot de passe du pad"><i class="fa fa-gear"></i> Modifier les réglages du pad</a> ';
	
	$body .= '</p>';
}

echo $body;

