<?php
/**
 * Display an image
 *
 * @uses $vars['entity']
 */

$file = $vars['entity'];

$image_url = $file->getIconURL('large');
$image_url = elgg_format_url($image_url);
$download_url = elgg_get_site_url() . "file/download/{$file->guid}";
// Iris : le bouton de DL étant au-dessus, pas besoin de lien sur l'image (qui devrait s'afficher en lightbox une fois le JS chargé)
//$download_url = "javascript:void(0);";

if ($vars['full_view']) {
	elgg_load_js('lightbox');
	elgg_load_css('lightbox');
	echo <<<HTML
		<div class="file-photo">
			<a href="$download_url" onClick="javascript:void(0);" class="elgg-lightbox-photo">
				<img class="elgg-photo" src="$image_url" />
				<div class="file-colorbox-link hidden"><i class="fa fa-expand"></i></div>
			</a>
		</div>
HTML;
}
