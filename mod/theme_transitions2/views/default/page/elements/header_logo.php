<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();

$imgurl = $site_url . 'mod/theme_transitions2/graphics/';
//echo elgg_view('core/account/login_dropdown');
?>

<a class="elgg-heading-site" href="<?php echo elgg_get_site_url(); ?>">
	<h1>
		<img src="<?php echo elgg_get_site_url(); ?>mod/theme_transitions2/graphics/logo-transitions2-small.png" alt="<?php echo elgg_get_site_entity()->name; ?>" />
		Relier <span class="transitions-eco">transition écologique</span> et <span class="transitions-num">transition numérique</span>
	</h1>
</a>

