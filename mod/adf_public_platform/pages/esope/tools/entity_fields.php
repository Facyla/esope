<?php
/**
 * List entity matching a specific metadata
 *
 * @package ElggPages
 */


admin_gatekeeper();

$title = "Liste des entités selon leurs métadonnées";
$content = '';
$sidebar = '';

$types = get_input('types', 'group');
$subtypes = get_input('subtypes', false);
$metadata = get_input('metadata', false);


$content .= '<style>
</style>';

$content .= '<form>
	<label>Type(s) d\'entités <input type="text" name="types" value="' . $types . '" /></label>
	<label>Sous-type(s) (facultatif) <input type="text" name="subtypes" value="' . $subtypes . '" /></label>
	<label>Propriété ou métadonnée <input type="text" name="metadata" value="' . $metadata . '" /></label>
	<input type="submit" value="Voir les entités correspondantes" class="elgg-button elgg-button-submit" />
	</form>';



//if (strpos($types, ',')) 
$options['types'] = explode(',', $types);
if (!empty($subtypes)) $options['subtypes'] = explode(',', $subtypes);
if (!empty($metadata) && !in_array($metadata, array('title', 'name', 'guid', 'description', 'briefdescription'))) $options['metadata_names'] = $metadata;
$options['limit'] = 0;
$options['count'] = true;


if ($options['metadata_names']) {
	$count_all_ents = elgg_get_entities_from_metadata($options);
} else {
	$count_all_ents = elgg_get_entities($options);
}
if ($count_all_ents > 500) $options['limit'] = 500;
$options['count'] = false;
if ($options['metadata_names']) {
	$all_ents = elgg_get_entities_from_metadata($options);
} else {
	$all_ents = elgg_get_entities($options);
}

$content .= "Le site comporte actuellement $count_all_ents";
if ($options['types']) $content .= ' "' . implode(', ', $options['types']) . '"';
if ($options['subtypes']) $content .= " / " . implode(', ', $options['subtypes']);
if ($metadata) $content .= " avec la propriété/métadonnée \"" . $metadata . '"';
$content .= ".<br /><br />";
foreach ($all_ents as $ent) {
	$content .= '<p>';
	$content .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' ' . $ent->name . $ent->title . '</a>';
	if ($metadata) $content .= " => $metadata = {$ent->$metadata}";
	$content .= '</p>';
}
$content .= '<br />';



$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


