<?php

namespace AU\RSSImport;

$version = elgg_get_plugin_setting('version', PLUGIN_ID);
if (!$version) {
	elgg_set_plugin_setting('version', PLUGIN_VERSION, PLUGIN_ID);
}

if (get_subtype_id('object', 'rssimport')) {
	update_subtype('object', 'rssimport', __NAMESPACE__ . '\\RSSImport');
} else {
	add_subtype('object', 'rssimport', __NAMESPACE__ . '\\RSSImport');
}