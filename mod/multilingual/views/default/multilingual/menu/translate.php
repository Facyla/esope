<?php
// Available languages to translate a given entity into

$entity = elgg_extract('entity', $vars);
if (!$entity) { return true; }
$guid = $entity->guid;
$content = '';

$languages = multilingual_available_languages(false);

if ($languages) {
	$text = elgg_echo('multilingual:menu:dotranslate');
	$params = array(
			'text' => $text, 'title' => elgg_echo('multilingual:menu:translate'),
			'rel' => 'popup', 'href' => "#multilingual-menu-$guid"
		);
	$list = elgg_view('output/url', $params);
	
	// Popup
	$content .= '<div class="elgg-module elgg-module-popup elgg-multilingual hidden clearfix" id="multilingual-menu-' . $guid . '">';
	foreach ($translations as $ent) {
		$content .= '<a href="' . $ent->getURL() . '?lang=' . $ent->lang . '">' . $ent->lang . '</a>';
	}
	$content .= '</div>';

} else {
	$content .= elgg_echo('multilingual:menu:notranslation');
}

echo $content;

