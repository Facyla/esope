<?php
/**
 * Multilingual translate content page
 *
 */

$guid = get_input('guid');
$lang = get_input('lang');


$title = elgg_echo('multilingual:translate');
$content = '';


$entity = get_entity($guid);
if (elgg_instanceof($entity)) {
	
	$content .= '<p>' . elgg_echo('multilingual:translate:version') . '</p>'>;
	$content .= "<p>{$entity->guid} {$entity->title}</p>";
	
	$content .= '<p>' . elgg_echo('multilingual:translate:otherversions') . '</p>'>;
	
	$content .= '<p>' . elgg_echo('multilingual:translate:otherlanguages') . '</p>'>;

	$content .= "<h3>Original entity</h3>";
	
	$content .= "<h3>EN translation</h3>";
	$translation = multilingual_get_translation($entity, 'en');
	if ($translation) {
		$content .= "<p>EN translation already exists</p>";
	} else {
		$translation = multilingual_add_translation($entity, 'en');
		$content .= "<p>Creating new translation</p>";
	}
	$content .= "{$translation->guid} {$translation->title}</p>";
	$content .= elgg_view_entity($translation);
	
	
	// Get all translations
	$content .= "<h3>Existing translations</h3>";
	$translations = multilingual_get_translations($entity);
	foreach ($translations as $ent) {
		$content .= "<p><strong>{$ent->lang}</strong> => {$ent->guid} : {$ent->title}</p>";
	}
	
} else {
	$content .= '<p>' . elgg_echo('multilingual:translate:missingentity') . '</p>'>;
}


$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
));

echo elgg_view_page($title, $body);

