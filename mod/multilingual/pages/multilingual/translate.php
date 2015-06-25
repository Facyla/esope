<?php
/**
 * Multilingual translate content page
 *
 */

$guid = get_input('guid');
$lang = get_input('locale', 'en');


$title = elgg_echo('multilingual:translate');
$content = '';


$entity = get_entity($guid);
if (elgg_instanceof($entity)) {
	
	$content .= '<h3>' . elgg_echo('multilingual:translate:version') . '</h3>';
	$content .= "<p>{$entity->guid} {$entity->title}</p>";
	
	$content .= '<h3>' . elgg_echo('multilingual:translate:version') . '</h3>';
	$translation = multilingual_get_translation($entity, $lang);
	if ($translation) {
		system_message(elgg_echo('multilingual:translate:alreadyexists'));
	} else {
		$translation = multilingual_add_translation($entity, $lang);
		system_message(elgg_echo('multilingual:translate:newcreated'));
	}
	$content .= "{$translation->guid} {$translation->title}</p>";
	$content .= elgg_view_entity($translation);
	
	
	$content .= '<h3>' . elgg_echo('multilingual:translate:otherversions') . '</h3>'>;
	// Get all translations
	$translations = multilingual_get_translations($entity);
	foreach ($translations as $ent) {
		$content .= '<p><strong><img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $lang_code . '.gif" alt="' . $lang_code . '" />' . $ent->lang . ' :</strong> ' . $ent->guid . ' : ' . $ent->title . '</p>';
	}
	
	$content .= '<p>' . elgg_echo('multilingual:translate:otherlanguages') . '</p>'>;

	
	
	
} else {
	$content .= '<p>' . elgg_echo('multilingual:translate:missingentity') . '</p>'>;
}


$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
));

echo elgg_view_page($title, $body);

