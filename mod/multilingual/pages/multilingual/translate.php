<?php
/**
 * Multilingual translate content page
 *
 */

$guid = get_input('guid');
$lang = get_input('locale', 'en');

if (!empty($lang)) $lang_name = elgg_echo($lang);

$title = elgg_echo('multilingual:translate');
$content = '';
$sidebar = '';


$entity = get_entity($guid);
if (elgg_instanceof($entity)) {
	
	$base_url = $entity->getURL() . '?lang=';
	
	$languages = multilingual_available_languages();
	
	$sidebar .= '<h3>' . elgg_echo('multilingual:translate:original') . '</h3>';
	$sidebar .= "<p>{$entity->guid} {$entity->title}</p>";
	$sidebar .= '<br />';
	
	$content .= '<h3>' . elgg_echo('multilingual:translate:version', array($lang_name)) . '</h3>';
	$translation = multilingual_get_translation($entity, $lang);
	if ($translation) {
		system_message(elgg_echo('multilingual:translate:alreadyexists'));
	} else {
		$translation = multilingual_add_translation($entity, $lang);
		//system_message(elgg_echo('multilingual:translate:newcreated'));
		$content .= '<blockquote>' . elgg_echo('multilingual:translate:newcreated') . '</blockquote>';
	}
	$content .= "<p>{$translation->guid} {$translation->title}</p>";
	$content .= elgg_view_entity($translation);
	$content .= '<br />';
	
	
	$sidebar .= '<h3>' . elgg_echo('multilingual:translate:otherversions') . '</h3>';
	// Get all translations
	$translations = multilingual_get_translations($entity);
	foreach ($translations as $ent) {
		if (!empty($ent->locale)) $l_name = elgg_echo($ent->locale);
		$sidebar .= '<p><a href="' . $base_url . $ent->locale . '"><img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $ent->locale . '.gif" alt="' . $l_name . '" /> ' . $l_name . ' (' . $ent->locale . ') : ' . $ent->title . ' (' . $ent->guid . ')</a></p>';
		// Remove from new translations array
		unset($languages[$ent->locale]);
	}
	$sidebar .= '<br />';
	
	$sidebar .= '<h3>' . elgg_echo('multilingual:translate:otherlanguages') . '</h3>';
	foreach ($languages as $lang_code => $l_name) {
		$sidebar .= '<p><a href="' . elgg_get_site_url() . 'multilingual/translate/' . $entity->guid . '/' . $lang_code . '"><img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $lang_code . '.gif" alt="' . $l_name . '" /> ' . elgg_echo('multilingual:menu:translateinto', array($languages[$lang_code])) . '</a></p>';
	}
	$sidebar .= '<br />';
	
	
} else {
	register_error(elgg_echo('multilingual:translate:missingentity'));
}


$body = elgg_view_layout('one_sidebar', array(
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);

