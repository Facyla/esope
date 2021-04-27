<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 */

$url = elgg_get_site_url();

echo '<img src="' . $url . 'mod/theme_adf/graphics/logo-ADF-assemblee-des-departements-de-france_long.png" style="padding: 1rem 2rem; max-height: 6rem;" />';
echo elgg_view_menu('footer');

