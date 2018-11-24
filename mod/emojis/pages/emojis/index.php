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
if (in_array($exec, ['clearbenchmark', 'clear'])) {
	$_SESSION['emojis_known'] = null;
	$_SESSION['emojis_Emoji_load_map'] = null;
	$_SESSION['emojis_Emoji_load_regex'] = null;
	system_message('Emojis plugin session caches cleared');
	if (in_array($exec, ['clear'])) { forward('emojis'); }
}


// Admin options links
$content .= '<p><a href="?exec=clear" class="elgg-button elgg-button-action">Clear cache</a> clears all emojis session caches (strings + map + regexp)</p>';
$content .= '<p><a href="?exec=benchmark" class="elgg-button elgg-button-action">Speed tests</a> performs several speed tests on various involved functions and hooks, both with a new cache or with existing cache. Edit this file source to adjust tests.</p>';
$content .= '<p><a href="?exec=clearbenchmark" class="elgg-button elgg-button-action">Clear cache and Speed tests</a> same, but clears the static cache first. As content cache is cleared frequently, this simulates the caching process, ie. initial load. It also clears the map and regex cache.</p>';
$content .= '<p><a href="?exec=session" class="elgg-button elgg-button-action">View emojis session cache </a> displays the content of strings cache (converted emojis strings), map (static map file) and regex (static regex file). These are always displayed after a benchmark test.</p>';


// Performs tests for benchmarking
if (in_array($exec, ['clearbenchmark', 'benchmark'])) {
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

	$content .= "Pour chaque test, " . count($objects) . " itérations avec 2 contenus distincts passés dans la fonction testée : l'un avec la description de l'objet (\$ent->description), et l'autre avec un tableau imbriqué contenant des emojis (mais avec un élément variable qui le rend unique) : <br />";
	$content .= '<q>' . print_r(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis {\$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]], true) . '</q>';
	$content .= '<br /><hr />';
	
	
	
	// INPUT EMOJIS FILTER - no cache
	$content .= "<h3>Fonction de validation (emojis_to_html)</h3><h4>sans cache</h4><p>Tests de la fonction de détection et conversion des input (get_input) utilisée par le hook validate,input</p>";
	$_SESSION['emojis_known'] = null;
	$content .= esope_dev_profiling("Start", false) . '<br />';
	foreach ($objects as $ent) {
		$string = ["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]];
		$test .= emojis_to_html($string);
		$test .= emojis_to_html($ent->description);
		//$test .= emojis_to_html(print_r($ent, true)); // more data to process
	}
	$content .= esope_dev_profiling("End", false) . '<br />';
	
	// INPUT EMOJIS FILTER - cache
	$content .= "<h4>avec cache</h4>";
	$content .= esope_dev_profiling("Start", false) . '<br />';
	foreach ($objects as $ent) {
		$string = ["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]];
		$test .= emojis_to_html($string);
		$test .= emojis_to_html($ent->description);
	}
	$content .= esope_dev_profiling("End", false) . '<hr />';
	
	
	// CLASS Emojis - idem avec la classe
	// Speed : comparativement à procédural => un peu plus rapide avec les données de test, mais non significatif (dépend probablement fortement des données)
	$_SESSION['emojis_known'] = null;
	$FacylaEmojis = new \Facyla\Emojis();
	$content .= "<h3>Test classe - Fonction de validation</h3><h4>sans cache</h4><p>Tests de la fonction de détection et conversion des input (get_input) utilisée par le hook validate,input - sous forme de classe</p>";
	$content .= esope_dev_profiling("Start", false) . '<br />';
	foreach ($objects as $ent) {
		$string = ["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]];
	
		$test .= $FacylaEmojis->emojis_to_html($string);
		$test .= $FacylaEmojis->emojis_to_html($ent->description);
		//$test .= emojis_to_html(print_r($ent, true)); // more data to process
	}
	$content .= esope_dev_profiling("End", false) . '<br />';
	
	$content .= "<h4>avec cache</h4>";
	$content .= esope_dev_profiling("Start", false) . '<br />';
	foreach ($objects as $ent) {
		$string = ["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]];
		$test .= $FacylaEmojis->emojis_to_html($string);
		$test .= $FacylaEmojis->emojis_to_html($ent->description);
		//$test .= emojis_to_html(print_r($ent, true)); // more data to process
	}
	$content .= esope_dev_profiling("End", false) . '<hr />';
	
	
	
	
	// INPUT HOOK - no cache
	// Speed tests : no hook 0.03, htmlawed 0.03, emojis 0.05, both 0.05
	// Speed tests (no session cache) : no hook 0.03, htmlawed 0.03, emojis 1.7, both 1.7
	$content .= "<h3>Input hook</h3><h4>sans cache</h4><p>Test du hook de validation des INPUT : validate,input</p>";
	$_SESSION['emojis_known'] = null;
	$content .= esope_dev_profiling("Start", false) . '<br />';
	foreach ($objects as $ent) {
		$string = ["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis  {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]];
		$test .= elgg_trigger_plugin_hook('validate', 'input', null, $string);
		$test .= elgg_trigger_plugin_hook('validate', 'input', null, $ent->description);
	}
	$content .= esope_dev_profiling("End", false) . '<br />';
	
	// INPUT HOOK - cache
	$content .= "<h4>avec cache</h4>";
	// Speed tests : no hook 0.03, htmlawed 0.03, emojis 0.05, both 0.05
	// Speed tests (no session cache) : no hook 0.03, htmlawed 0.03, emojis 1.7, both 1.7
	$content .= esope_dev_profiling("Start", false) . '<br />';
	foreach ($objects as $ent) {
		$string = ["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis  {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]];
		$test .= elgg_trigger_plugin_hook('validate', 'input', null, $string);
		$test .= elgg_trigger_plugin_hook('validate', 'input', null, $ent->description);
	}
	$content .= esope_dev_profiling("End", false) . '<hr />';
	
	
	
	// OUTPUT HOOK
	$content .= "<h3>Output hook (view,all)</h3><p>Test du hook de conversion des OUTPUT pour l'affichage, via le hook view,all</p>";
	$content .= esope_dev_profiling("Start", false) . '</p>';
	foreach ($objects as $ent) {
		$string = print_r(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis  {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]], true); // has to be a string
		$test .= elgg_trigger_plugin_hook('view', 'all', null, $string);
		$test .= elgg_trigger_plugin_hook('view', 'all', null, $ent->description);
	}
	$content .= esope_dev_profiling("End", false) . '<hr />';
	
	// OUTPUT VIEW
	$content .= "<h3>Affichage vue output/longtext</h3><p>Test de la fonction de conversion des OUTPUT pour l'affichage, via la vue output/longtext qui déclenche le hook view,all</p>";
	$content .= esope_dev_profiling("Start", false) . '</p>';
	foreach ($objects as $ent) {
		$string = print_r(["text", 12345, "👦", '👩', " some texte 👩‍ around 🎤 emojis  {$ent->guid}", '👦' => [3 => "👦", "test" => '👩', ['👩' => '👩', '👩']]], true); // has to be a string
		$test .= elgg_trigger_plugin_hook('view', 'all', null, $string);
		$test .= elgg_trigger_plugin_hook('view', 'all', null, $ent->description);
	
	}
	$content .= esope_dev_profiling("End", false) . '<hr />';
	
}


// Display cached data
if (in_array($exec, ['clear', 'benchmark', 'session', 'clearbenchmark'])) {
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

