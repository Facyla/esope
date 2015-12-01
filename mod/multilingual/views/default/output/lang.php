<?php
// Display entity language

$lang = elgg_extract('lang', $vars, false);

if (!$lang) {
	$entity = elgg_extract('entity', $vars);
	if (elgg_instanceof($entity)) {
		$lang = multilingual_get_entity_language($entity);
	}
}
$content = '';

if (!empty($lang)) {
	echo '<img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $lang . '.gif" title="' . elgg_echo($lang) . '" />';
}

