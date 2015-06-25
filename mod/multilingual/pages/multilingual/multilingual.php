<?php
/**
 * Multilingual translate content page
 *
 */

$guid = get_input('guid');


$title = elgg_echo('multilingual:translate');
$content = '';


$entity = get_entity($guid);
if (elgg_instanceof($entity)) {
	$content .= "<h3>Original entity</h3>";
	$content .= "{$entity->guid} {$entity->title}<br />";
	
	$content .= "<h3>EN translation</h3>";
	$translation = multilingual_get_translation($entity, 'en');
	if ($translation) {
		$content .= "EN translation already exists<br />";
	} else {
		$translation = multilingual_add_translation($entity, 'en');
		$content .= "C ENreating new translation<br />";
	}
	$content .= "{$translation->guid} {$translation->title}<br />";
	$content .= elgg_view_entity($translation);
	
	
	// Get all translations
	$content .= "<h3>Existing translations</h3>";
	$translations = multilingual_get_translations($entity);
	foreach ($translations as $ent) {
		$content .= "<strong>{$ent->lang}</strong> => {$ent->guid} : {$ent->title}<br />";
	}
	
}


$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
));

echo elgg_view_page($title, $body);

