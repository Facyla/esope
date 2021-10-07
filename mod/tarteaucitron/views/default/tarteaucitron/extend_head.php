<?php
// Configuration for tarteaucitron
$enable_banner = elgg_get_plugin_setting('enable_banner', 'tarteaucitron');
$js_config = elgg_get_plugin_setting('js_config', 'tarteaucitron');

$tarteaucitron_js = elgg_get_simplecache_url('tarteaucitron/tarteaucitron.js');
//$tarteaucitron_css = elgg_get_simplecache_url('tarteaucitron/tarteaucitron.css');

if ($enable_banner) {
	echo '<script type="text/javascript" src="' . $tarteaucitron_js . '"></script>';
	echo "<script type=\"text/javascript\">
tarteaucitron.init({
$js_config
});
</script>";
	
	/*
	elgg_require_js('tarteaucitron.js');

	//elgg_require_css('leaflet.markercluster.default.css');
	//elgg_require_js('leaflet/view_map');

	echo "<script type=\"text/javascript\">
	require(['tarteaucitron', 'tarteaucitron/tac_configuration'], function (tarteaucitron, config) {
	});
	</script>";
	*/
}

