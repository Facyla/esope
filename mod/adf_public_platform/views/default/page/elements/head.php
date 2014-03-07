<?php
/**
 * The standard HTML head
 *
 * @uses $vars['title'] The page title
 */
global $CONFIG;

// Set title
if (empty($vars['title'])) {
	$title = elgg_get_config('sitename');
} else {
	$title = elgg_get_config('sitename') . ": " . $vars['title'];
}

// Set RSS feed
global $autofeed;
$feedref = "";
if (isset($autofeed) && $autofeed == true) {
	$fullurl = full_url();
	if (substr_count($fullurl,'?')) { $fullurl .= "&view=rss"; } else { $fullurl .= "?view=rss"; }
	$fullurl = elgg_format_url($fullurl);
	$feedref = '<link rel="alternate" type="application/rss+xml" title="RSS" href="' . $fullurl . '" />';
}

// Load JS and CSS
$js = elgg_get_loaded_js('head');
$css = elgg_get_loaded_css();

// Get ESOPE config
$theme_url = $CONFIG->url . 'mod/adf_public_platform/';
$config_awesomefont = elgg_get_plugin_setting('awesomefont', 'adf_public_platform');
$config_semanticui = elgg_get_plugin_setting('semanticui', 'adf_public_platform');
$config_css = elgg_get_plugin_setting('css', 'adf_public_platform');

// Output the head content
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<?php
	echo elgg_view('page/elements/shortcut_icon', $vars);
	
	// CSS stylesheets
	foreach ($css as $link) {
		echo '<link rel="stylesheet" href="' . $link . '" type="text/css" />';
	}
	echo '<link rel="stylesheet" href="' . $theme_url . 'print.css" type="text/css" media="print" />';
	echo '<link rel="stylesheet" href="' . $theme_url . 'vendors/jquery-ui-1.10.2.custom/css/smoothness/jquery-ui-1.10.2.custom.min.css" />';
	
	$ie_url = elgg_get_simplecache_url('css', 'ie');
	$ie7_url = elgg_get_simplecache_url('css', 'ie7');
	$ie6_url = elgg_get_simplecache_url('css', 'ie6');
	?>
	<!--[if gt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie_url; ?>" />
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie7_url; ?>" />
	<![endif]-->
	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie6_url; ?>" />
	<![endif]-->
	<?php // Pure CSS menu integration : a piece of CSS + a JS script in 'page/elements/foot' for IE6 ?>
	<!--[if lt IE 7]>
		<style type="text/css">#menu li { width:164px; }</style>
	<![endif]-->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo $CONFIG->url; ?>mod/adf_public_platform/views/default/adf_platform/js/html5-ie.php"></script>
	<![endif]-->
	<?php
	if ($config_awesomefont == 'yes') {
		echo '<link rel="stylesheet" href="' . $theme_url . 'vendors/font-awesome/css/font-awesome.min.css" />';
	}
	if ($config_semanticui == 'yes') {
		echo '<link rel="stylesheet" type="text/css" href="' . $theme_url . 'vendors/semantic-ui/packaged/css/semantic.css" />';
	}
	
	// CSS complémentaire configurable
	if (!empty($config_css)) {
		echo "\n<style>" . html_entity_decode($config_css) . "</style>\n";
	}
	
	/* jQuery : use CDN instead of registered JS ?
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	*/
	
	// JS et extensions supplémentaires
	foreach ($js as $script) {
		echo '<script type="text/javascript" src="' . $script . '"></script>' . "\n";
	}
	if ($config_semanticui == 'yes') {
		echo '<script src="' . $theme_url . 'vendors/semantic-ui/packaged/javascript/semantic.js"></script>';
	}
	echo '<script type="text/javascript">' . elgg_view('js/initialize_elgg') . '</script>';
	
	echo $feedref;
	
	$metatags = elgg_view('metatags', $vars);
	if ($metatags) {
		elgg_deprecated_notice("The metatags view has been deprecated. Extend page/elements/head instead", 1.8);
		echo $metatags;
	}
	
