<?php
// Available translations for given entity
// + available languages for translation

$entity = elgg_extract('entity', $vars);
if (!$entity) { return true; }
$guid = $entity->guid;
$content = '';

$translations = multilingual_get_translations($entity);

// @TODO : Add a single menu with both available languages and translate link ?
$languages = multilingual_available_languages(false);


$text = '<i class="fa fa-language"></i>Translations';
$params = array(
		'text' => $text, 'title' => elgg_echo('multilingual:menu:versions'),
		'rel' => 'popup', 'href' => "#multilingual-menu-$guid"
	);
$content .= elgg_view('output/url', $params);

// Popup
$content .= '<div class="elgg-module elgg-module-popup elgg-multilingual hidden clearfix" id="multilingual-menu-' . $guid . '">';

// Existing translations
if ($translations) {
	$content .= '<p>Available translations : ';
	foreach ($translations as $ent) {
		$content .= '<a href="' . $ent->getURL() . '?lang=' . $ent->lang . '"><img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $ent->lang . '.gif" />&nbsp;' . $ent->lang . '</a> ';
	}
	$content .= '</p>';
} else {
	$content .= '<p>No translation yet</p>';
}

// Add new translations
// Available languages
$content .= '<p>Translate into : ';
foreach ($languages as $lang_code) {
	$content .= '<a href="' . elgg_get_site_url() . 'multilingual/translate' . $lang_code . '"><img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $lang_code . '.gif" />&nbsp;' . $lang_code . '</a> ';
}
$content .= '</p>';

$content .= '</div>';

echo $content;

