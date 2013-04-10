<?php
/**
 * Elgg header logo
 */

/* Default :
<h1>
	<a class="elgg-heading-site" href="<?php echo $site_url; ?>">
		<?php echo $site_name; ?>
	</a>
</h1>
*/

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();

?>
<?php // Entête configurable
$header = elgg_get_plugin_setting('header', 'adf_public_platform');
if (!empty($header)) {
  ?>
  <div id="mmtop">
  <!-- this is where the content slider will go... -->
    <?php echo $header; ?>
  </div>
  <?php
} else {
  ?>
  <div id="mmtop">
    <div id="easylogo"><a href="/"><img src="<?php echo $vars['url']; ?>/mod/adf_public_platform/img/logo.gif" alt="Logo du site" /></a></div>
  </div>
  <?php
}
