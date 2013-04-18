<?php
/**
 * Displays the default shortcut icon
 */
$footer = elgg_get_plugin_setting('faviconurl', 'adf_public_platform');
if (empty($footer)) $footer = elgg_get_site_url() . '_graphics/favicon.ico';
else $footer = elgg_get_site_url() . $footer;
?>
<link rel="SHORTCUT ICON" href="<?php echo $footer; ?>" />

