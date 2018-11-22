<?php
/**
 * Emojis index page
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('emojis'));

$title = elgg_echo('emojis:index');
$content = '';


$objects = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => '1000',
));


// 67 objects thewire / témoin / $ent->description => 0.0001s
// 67 objects thewire / texte / emojis_to_html($ent->description) => 0.3224s
// 67 objects thewire / témoin / print_r($ent, true) => 0.0014s
// 67 objects thewire / tableau / emojis_to_html(print_r($ent, true)) => 3.0283s
// 67 objects thewire / emojis_to_html(["text", "integers", 1345, "http://www.some.web/%20space/", "some longer text but still short"]) => 1.228s
// 67 objects thewire / emojis_to_html(["mixed", "content", 1345, "http://www.some.web/%20space/", "👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤"]) => 1.3673s
// 67 objects thewire / emojis_to_html(["👶 👧 👦", " 👩👵👳 ♂", '👩⚕ 👩🌾 ', " 👨🍳 ", "👩‍🎤"]) => 1.27s
// 67 objects thewire / emojis_to_html(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis "]) => 1.1971s
// avec array_walk_recursive => 0.8s  mais pas sûr que ce soit propre (et ne gère pas les clefs)
// 67 objects thewire / emojis_to_html(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis ", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]]) => 2.35s en récursif classique, 1.27 avec array_walk_recursive
// 67 objects thewire / optimisations = global map + detect int/numeric/emojis => 0.32s
// 67 objects thewire /  => s

$content .= "Traitement de " . count($objects) . " messages<br />";
$content .= esope_dev_profiling(false, false) . '<br />';
foreach ($objects as $ent) {
	//$string = $ent->description;
	//$string = emojis_to_html($ent->description);
	//$string = print_r($ent, true);
	//$string = emojis_to_html(print_r($ent, true));
	
	//$string = emojis_to_html(["text", "integers", 1345, "http://www.some.web/%20space/", "some longer text but still short"]);
	//$string = emojis_to_html(["mixed", "content", 1345, "http://www.some.web/%20space/", "👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤"]);
	//$string = emojis_to_html(["👶 👧 👦", " 👩👵👳 ♂", '👩⚕ 👩🌾 ', " 👨🍳 ", "👩‍🎤"]);
	$string = emojis_to_html(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis ", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]]);
	//$string = emojis_to_html(print_r($ent, true));
	
	
	$content .= print_r($string, true) . '<br />';
}
$content .= esope_dev_profiling(false, false) . '<br />';




$body = elgg_view_layout('one_column', array(
	'title' => $title,
	'content' => $content,
	//'sidebar' => elgg_view('emojis/sidebar'),
	//'filter_context' => 'all',
));

echo elgg_view_page($title, $body);

