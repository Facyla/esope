<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();

// ESOPE : optional override through theme settings
$header = elgg_get_plugin_setting('header', 'esope');
if (!empty($header)) {
	echo $header;
	return;
}
?>

<h1>
	<a class="elgg-heading-site" href="<?php echo $site_url; ?>">
		<?php echo $site_name; ?>
	</a>
</h1>
