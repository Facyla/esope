<?php
/**
 * Displays the default shortcut icon
 */
$favicon = elgg_get_plugin_setting('faviconurl', 'esope');
if (empty($favicon)) {
	$favicon = elgg_get_site_url() . '_graphics/favicon.ico';
} else {
	$favicon = elgg_get_site_url() . $favicon;
}
?>
<link rel="SHORTCUT ICON" href="<?php echo $favicon; ?>" />

