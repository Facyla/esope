<?php
$limit = get_input('limit', 10);
$offset = get_input('offset', 0);

$exclude = $vars['exclude'];
if (isset($vars['nolink'])) $nolink = true; else $nolink = false;

// Highlighted - for everybody, depending of their access rights
$body .= '<h2>Articles choisis</h2>';
$body .= '<div class="clearfloat"></div><br />';
//$homehighlight .=	'<div class="clearfloat"></div>';

//$body .= '<h3>' . elgg_echo('pin:highlighted:title') . '</h3>';
$ents_count = get_entities_from_metadata('highlight', '', 'object', '', 0, $limit, 0, '', -1, true);
$ents = get_entities_from_metadata('highlight', '', 'object', '', 0, $ents_count, 0, '', -1, false);

//$body .= elgg_view_entity_list($ents, $ents_count, $offset, $limit, false, false, true);

$i = 0;
foreach ($ents as $ent) {
	// On passe si déjà publié (ou exclu pour X autre raison)
	if (is_array($exclude) && in_array($ent->guid, $exclude)) { continue; }
	$i++;
	
	// Récupération icône du plus pertinent (lieu de publication) au moins pire (site courant)..
	if ($ent_for_icon = get_entity($ent->container_guid)) {} 
	else if ($ent_for_icon = get_entity($ent->owner_guid)) {}
	else if ($ent_for_icon = get_entity($ent->site_guid)) {}
	if ($ent_for_icon instanceof ElggEntity) { $icon = get_entity_icon_url($ent_for_icon, "small"); }
	$icon = '<a href="' . $ent->getURL() . '"><img src="'.$icon.'" /></a>';
	
	$linktext = $ent->title;
	if (empty($linktext)) $linktext = $ent->description;
	if (empty($linktext)) $linktext = elgg_echo('item:object:'.$ent->getSubtype());
	$owner = get_entity($ent->owner_guid);
	$info = '<a href="' . $ent->getURL() . '">' . $linktext . '</a><br />
		<p class="owner_timestamp"><a href="' . $owner->getURL() . '">' . $owner->name . '</a> ' 
		. friendly_time($ent->time_created);
	if ($ent_for_icon->guid != $owner->guid) {
		$info .= ' <i>in</i> <a href="' . $ent_for_icon->getURL() . '">' . $ent_for_icon->name . '</a>';
	}
	$info .= '</p>';
	$body .= elgg_view_listing($icon, $info);
	if ($i > $limit) { break; }
}
if (!$nolink) {
	$body .= '<br /><h4><a href="' . $CONFIG->url . 'mod/pin/index.php">&raquo;&nbsp;Retrouver tous les articles choisis</a></h4>';
}

echo $body;

