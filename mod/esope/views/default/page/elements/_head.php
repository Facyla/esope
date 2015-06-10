<?php
/**
 * The HTML head
 *
 * JavaScript load sequence (set in views library and this view)
 * ------------------------
 * 1. Elgg's initialization which is inline because it can change on every page load.
 * 2. RequireJS config. Must be loaded before RequireJS is loaded.
 * 3. RequireJS
 * 4. jQuery
 * 5. jQuery migrate
 * 6. jQueryUI
 * 7. elgg.js
 *
 * @uses $vars['title'] The page title
 * @uses $vars['metas'] Array of meta elements
 * @uses $vars['links'] Array of links
 */

$metas = elgg_extract('metas', $vars, array());
$links = elgg_extract('links', $vars, array());

echo elgg_format_element('title', array(), $vars['title'], array('encode_text' => true));
foreach ($metas as $attributes) {
	echo elgg_format_element('meta', $attributes);
}
foreach ($links as $attributes) {
	echo elgg_format_element('link', $attributes);
}

$js = elgg_get_loaded_js('head');
$css = elgg_get_loaded_css();
$elgg_init = elgg_view('js/initialize_elgg');

$html5shiv_url = elgg_normalize_url('vendors/html5shiv.js');
$ie_url = elgg_get_simplecache_url('css', 'ie');
$ie8_url = elgg_get_simplecache_url('css', 'ie8');
$ie7_url = elgg_get_simplecache_url('css', 'ie7');

// Get ESOPE config
$theme_url = $CONFIG->url . 'mod/esope/';
$config_semanticui = elgg_get_plugin_setting('semanticui', 'esope');
$config_css = elgg_get_plugin_setting('css', 'esope');

// Output the head content
/*
 * @TODO : META tags
 * description (réglage générique ou distinction par page): <meta name="description" content="XXXX">
 * keywords (distinction par page): <meta name="keywords" content="XXXX">
 * author (distinction par page): <meta name="author" content="XXXX">
 * robots (intérêt moyen) (réglage générique ou distinction par page): <meta name="robots" content="XXXX">
*/
?>

	<!--[if lt IE 9]>
		<script src="<?php echo $html5shiv_url; ?>"></script>
	<![endif]-->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<?php
	
foreach ($css as $url) {
	echo elgg_format_element('link', array('rel' => 'stylesheet', 'href' => $url, 'media' => "all"));
	}
	// Specific CSS for print
	echo '<link rel="stylesheet" href="' . $theme_url . 'print.css" type="text/css" media="print" />' . "\n";
	// Other stylesheets
	echo '<link rel="stylesheet" href="' . $theme_url . 'vendors/jquery-ui-1.10.2.custom/css/smoothness/jquery-ui-1.10.2.custom.min.css" />' . "\n";
	
	?>
	<!--[if gt IE 8]>
		<link rel="stylesheet" href="<?php echo $ie_url; ?>" />
	<![endif]-->
	<!--[if IE 8]>
		<link rel="stylesheet" href="<?php echo $ie8_url; ?>" />
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo $ie7_url; ?>" />
	<![endif]-->

	<script><?php echo $elgg_init; ?></script>
	<?php
	if ($config_semanticui == 'yes') {
		echo '<link rel="stylesheet" type="text/css" href="' . $theme_url . 'vendors/semantic-ui/packaged/css/semantic.css" />' . "\n";
	}
	
	// CSS complémentaire configurable
	if (!empty($config_css)) {
		echo "\n<style>" . html_entity_decode($config_css) . "</style>\n";
	}

foreach ($js as $url) {
	echo elgg_format_element('script', array('src' => $url));
}

echo elgg_view_deprecated('page/elements/shortcut_icon', array(), "Use the 'head', 'page' plugin hook.", 1.9);
	if ($config_semanticui == 'yes') {
		echo '<script src="' . $theme_url . 'vendors/semantic-ui/packaged/javascript/semantic.js"></script>' . "\n";
	}
	
echo elgg_view_deprecated('metatags', array(), "Use the 'head', 'page' plugin hook.", 1.8);
