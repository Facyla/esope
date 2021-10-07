<?php
// Configuration for tarteaucitron
$enable_banner = elgg_get_plugin_setting('enable_banner', 'tarteaucitron');

if ($enable_banner) {
	$js_config = elgg_get_plugin_setting('js_config', 'tarteaucitron');
	echo $js_config
}

