<?php
/**
 * User export embed widget display view
 */

$embedurl = $vars['entity']->embedurl;
$site_url = $vars['entity']->site_url;
$embedtype = $vars['entity']->embedtype;
$group_guid = $vars['entity']->group_guid;
$limit = $vars['entity']->limit;
$offset = $vars['entity']->offset;
$user_guid = $vars['entity']->user_guid;
$customparams = $vars['entity']->customparams;


if (!empty($embedurl)) {
	// Soit on a une URL complète : OK
	
} else if (!empty($site_url)) {
	// Soit on a configuré l'URL du site => ajout du type de widget et OK
	$embedurl .= $site_url . 'export_embed/';
	if (!empty($embedtype)) $embedurl .= $embedtype;
	
} else {
	// Soit rien n'est configuré => Aide
  /*
  $site_url = $vars['entity']->site_url;
  $embedtype = $vars['entity']->embedtype;
  $embedparams = $vars['entity']->customparams;
  */
}

// On ajoute les paramètres supplémentaires
if (!empty($group_guid)) $embedurl .= '&group_guid=' . $group_guid;
if (!empty($limit)) $embedurl .= '&limit=' . $limit;
if (!empty($offset)) $embedurl .= '&offset=' . $offset;
if (!empty($user_guid)) $embedurl .= '&user_guid=' . $user_guid;
if (!empty($customparams)) $embedurl .= '&' . $customparams;

//echo $embedurl; // URl complète du widget externe
if (empty($embedurl)) {
	$embedurl = $vars['url'] . 'export_embed'; // En local => Aide du widget
	echo '<iframe src="' . html_entity_decode($embedurl) . '" style="height:360px; overflow-y:auto; width:100%;">Chargement en cours</iframe>';
} else {
	echo '<iframe src="' . html_entity_decode($embedurl) . '" style="height:600px; overflow-y:auto; width:100%;">Chargement en cours</iframe>';
}

