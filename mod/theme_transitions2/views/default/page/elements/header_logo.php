<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();

$imgurl = $site_url . 'mod/theme_transitions2/graphics/';
//echo elgg_view('core/account/login_dropdown');

$lang = get_language();
if ($lang == 'fr') {
	$lang_title = 'Relier <span class="transitions-eco">transition écologique</span> et <span class="transitions-num">transition numérique</span>';
} else {
	$lang_title = 'Connecting <span class="transitions-eco">the Digital</span> and <span class="transitions-num">the Ecological Transitions</span>';
}
?>

<a class="elgg-heading-site" href="<?php echo elgg_get_site_url(); ?>">
	<h1>
		<img src="<?php echo elgg_get_site_url(); ?>mod/theme_transitions2/graphics/logo-transitions2-small.png" alt="<?php echo elgg_get_site_entity()->name; ?>" />
		<?php echo $lang_title; ?>
	</h1>
</a>

