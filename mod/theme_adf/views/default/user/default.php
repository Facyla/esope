<?php
/**
 * Elgg user display
 *
 * @uses $vars['entity'] ElggUser entity
 * @uses $vars['size']   Size of the icon
 * @uses $vars['title']  Optional override for the title
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggUser) {
	return;
}

$size = elgg_extract('size', $vars, 'medium');

if (elgg_get_context() == 'gallery') {
	echo elgg_view_entity_icon($entity, $size, $vars);
	return;
}
	
$title = elgg_extract('title', $vars);
if (!$title) {
	$title = elgg_view('output/url', [
		'href' => $entity->getUrl(),
		'text' => $entity->getDisplayName(),
		'is_trusted' => true,
	]);
}


// Infos statutaires : statut, poste, organisation... : cf. imprint/contents
/*
//if (!empty($entity->briefdescription)) $content .= '<p class="">' . $entity->briefdescription . '</p>';
if (!empty($entity->organisation)) 
$content .= '<p class=""><strong>' . elgg_view('output/tags', ['value' => $entity->organisation]) . '</strong></p>';
if (!empty($entity->interests)) 
$content .= '<p class="">' . elgg_view('output/tags', ['value' => $entity->interests]) . '</p>';
*/


// Coordonnées, contacts
if (!empty($entity->email)) 
$contacts .= '<i class="far fa-fw fa-envelope"></i> <a href="mailto:' . $entity->email . '">' . $entity->email . '</a><br />';
if (!empty($entity->phone)) 
$contacts .= '<i class="fas fa-fw fa-phone"></i> ' . $entity->phone . '<br />';
if (!empty($entity->mobile)) 
$contacts .= '<i class="fas fa-fw fa-mobile"></i> ' . $entity->mobile . '<br />';

$contacts = '<div class="contacts">' . $contacts . '</div>';


$params = [
	'entity' => $entity,
	'title' => $title,
	'icon_entity' => $entity,
	'icon_size' => $size,
	'tags' => false,
	'content' => $content,
];
$params = $params + $vars;

echo elgg_view('user/elements/summary', $params);
echo $contacts;

