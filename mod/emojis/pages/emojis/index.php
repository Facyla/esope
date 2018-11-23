<?php
/**
 * Emojis index page
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('emojis'));

$title = elgg_echo('emojis:index');
$content = '';

elgg_admin_gatekeeper();

// @Devs Comment forward() to use this page for tests
//forward(REFERER);

$exec = get_input('exec');
// Clear all plugin session caches - exec early, as we forward after that
if ($exec == "clear") {
	$_SESSION['emojis_known'] = null;
	$_SESSION['emojis_Emoji_load_map'] = null;
	$_SESSION['emojis_Emoji_load_regex'] = null;
	system_message('Emojis plugin session caches cleared');
	forward('emojis');
}


// Admin options links
$content .= '<p><a href="?exec=clear" class="elgg-button elgg-button-action">Clear all emojis session caches</a></p>';
$content .= '<p><a href="?exec=benchmark" class="elgg-button elgg-button-action">Speed tests (edit source to adjust tests)</a></p>';
$content .= '<p><a href="?exec=session" class="elgg-button elgg-button-action">View emojis session cache (string cache, map and regex)</a></p>';


// Performs tests for benchmarking
if ($exec == "benchmark") {
	$objects = elgg_get_entities(array(
		'type' => 'object',
		//'subtype' => 'thewire',
		'limit' => '100',
	));

	/* Tests results 
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
	 */

	$content .= "Traitement de " . count($objects) . " boucles et objets<br />";
	
	// INPUT EMOJIS FILTER
	$content .= "Tests de la fonction de détection et conversion des INPUT : emojis_to_html<br />";
	esope_dev_profiling("VALIDATE,INPUT", false) . '<br />';
	foreach ($objects as $ent) {
		// Testing strings and sources
		//$string = $ent->description;
		//$string = emojis_to_html($ent->description);
		//$string = print_r($ent, true);
		//$string = emojis_to_html(print_r($ent, true));
	
		//$string = emojis_to_html(["text", "integers", 1345, "http://www.some.web/%20space/", "some longer text but still short"]);
		//$string = emojis_to_html(["mixed", "content", 1345, "http://www.some.web/%20space/", "👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤"]);
		//$string = emojis_to_html(["👶 👧 👦", " 👩👵👳 ♂", '👩⚕ 👩🌾 ', " 👨🍳 ", "👩‍🎤"]);
		$string = emojis_to_html(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis ", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]]);
		//$string = emojis_to_html(print_r($ent, true));
	
		$string = emojis_to_html($ent->description);
	
		//$content .= print_r($string, true) . '<br />';
	}
	$content .= esope_dev_profiling("VALIDATE,INPUT", false) . '<hr />';


	// OUTPUT EMOJIS FILTER
	$content .= "Tests de la fonction de conversion des OUTPUT : via output/longtext (hook view,all)<br />";
	$content .= esope_dev_profiling("OUTPUT", false) . '<br />';
	$string = print_r(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis ", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]], true);
	foreach ($objects as $ent) {
		$test .= elgg_view('output/longtext', ['content' => $string]);
		$test .= elgg_view('output/longtext', ['content' => $ent->description]);
		//$test .= elgg_trigger_plugin_hook('view', 'all', null, $string);
		//$test .= elgg_trigger_plugin_hook('view', 'all', null, $ent->description);
	
	}
	$content .= esope_dev_profiling("OUTPUT", false) . '<hr />';

	// VALIDATE HOOKS
	$content .= "Tests du hook de validation INPUT : validate,input<br />";
	// Speed tests : no hook 0.03, htmlawed 0.03, emojis 0.05, both 0.05
	// Speed tests (no session cache) : no hook 0.03, htmlawed 0.03, emojis 1.7, both 1.7
	$content .= esope_dev_profiling("VALIDATE", false) . '<br />';
	$string = print_r(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis ", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]], true);
	foreach ($objects as $ent) {
		$test .= elgg_trigger_plugin_hook('validate', 'input', null, $string);
		$test .= elgg_trigger_plugin_hook('validate', 'input', null, $ent->description);
	}
	$content .= esope_dev_profiling("VALIDATE", false) . '<hr />';
}


// Display cached data
if (in_array($exec, ['clear', 'benchmark', 'session'])) {
	// CACHED DATA
	$content .= 'SESSION CACHE CONTENT : ';
	$content .= '<br />EMOJIS STRINGS CACHE : <pre>' . print_r($_SESSION['emojis_known'], true) . '</pre>';
	$content .= '<hr />REGEXP : <pre>' . print_r($_SESSION['emojis_Emoji_load_regex'], true) . '</pre>';
	$content .= '<hr />MAP : <pre>' . print_r($_SESSION['emojis_Emoji_load_map'], true) . '</pre>';
	// Speed : Clear session cache vs keep it : 0.05 vs 0.002 (x50, but only after first exec with no gain)
	//$_SESSION['emojis_known']= null;
}



// Compose layout and view page
$body = elgg_view_layout('one_column', array(
	'title' => $title,
	'content' => $content,
	//'sidebar' => elgg_view('emojis/sidebar'),
	//'filter_context' => 'all',
));

echo elgg_view_page($title, $body);

