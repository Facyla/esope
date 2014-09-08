<?php
global $CONFIG;

$title = elgg_echo('pin:title');
$body = '';


// Highlighted - for everybody
//$body .= elgg_view('pin/highlight_nicelisting', array('exclude' => null, 'nolink' => true, 'limit' => "0"));
//$body .= elgg_view('pin/highlight_nicelisting', array('exclude' => null));

//$body .= '<h3>' . elgg_echo('pin:highlighted:title') . '</h3>';
$ents = elgg_get_entities_from_metadata(array('metadata_name' => 'highlight', 'types' => 'object', 'limit' => 0));
$body .= '<ul>';
foreach ($ents as $ent) {
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
}
$body .= '</ul>';



// Build page content
$body = elgg_view_layout('one_column', array('content' => $body));


// Affichage
echo elgg_view_page($title, $body);

