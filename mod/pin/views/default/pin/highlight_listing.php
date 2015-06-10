<?php
$limit = get_input('limit', 12);
$offset = get_input('offset', 0);

$exclude = $vars['exclude'];
if (isset($vars['nolink'])) $nolink = true; else $nolink = false;
$wrap1 = '	<div class="river_item">
		<div class="river_object">
			<div class="river_pin">
				<div class="river_highlight">
					<div class="river_hightlight_new">';
$wrap2 = '					</div>
				</div>				
			</div>
		</div>
	</div>';

// Highlighted - for everybody, depending of their access rights
//$body .= '<h3>' . elgg_echo('pin:highlighted:title') . '</h3>';
$params = array('metadata_name' => 'highlight', 'types' => 'object', 'limit' => $limit, 'count' => true);
$ents_count = elgg_get_entities_from_metadata($params);
$params['count'] = false;
$ents = elgg_get_entities_from_metadata($params);

$i = 0;
foreach ($ents as $ent) {
	// On passe si déjà publié (ou exclu pour X autre raison)
	if (is_array($exclude) && in_array($ent->guid, $exclude)) { continue; }
	$i++;
	
	// Récupération icône du plus pertinent (lieu de publication) au moins pire (site courant)..
	if ($ent_for_icon = get_entity($ent->container_guid)) {} 
	else if ($ent_for_icon = get_entity($ent->owner_guid)) {}
	else if ($ent_for_icon = get_entity($ent->site_guid)) {}
	if ($ent_for_icon instanceof ElggEntity) { $icon = $ent_for_icon->getIcon("tiny"); }
	
	$linktext = $ent->title;
	if (empty($linktext)) $linktext = $ent->description;
	if (empty($linktext)) $linktext = elgg_echo('item:object:'.$ent->getSubtype());
	$owner = get_entity($ent->owner_guid);
	
	$body .= $wrap1;
	$body .= '<p style="padding-left:0;">
	<img src="'.$icon.'" style="float:left; margin-right:4px; width:16px; height:16px;" />
	<a href="' . $ent->getURL() . '">' . $linktext . '</a>, publié par <a href="' . $owner->getURL() . '">' . $owner->name . '</a> ';
	if ($ent_for_icon->guid != $owner->guid) {
		$body .= ' <i>in</i> <a href="' . $ent_for_icon->getURL() . '">' . $ent_for_icon->name . '</a> ';
	}
	$body .= '<span class="river_item_time">' . elgg_get_friendly_time($ent->time_created) . '</span>';
	$body .= '</p>';
	$body .= $wrap2;
	
	if ($i > $limit) { break; }
}
if (!$nolink) {
	$body .= '<br /><strong><a href="' . $CONFIG->url . 'mod/pin/index.php">&rarr;&nbsp;Retrouver tous les articles choisis</a></strong>';
}
$body .= '</div><br />';


echo $body;

