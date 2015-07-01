<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();

$imgurl = $site_url . 'mod/theme_transitions2/graphics/';
?>

<h1>
	<a class="elgg-heading-site" href="<?php echo $site_url; ?>">
		<img src="<?php echo $imgurl; ?>logo-transitions2.png" alt="<?php echo $site_name; ?>" />
	</a>
</h1>
