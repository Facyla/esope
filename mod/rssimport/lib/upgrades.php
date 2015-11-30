<?php

namespace AU\RSSImport;

function upgrade20151008() {
	$version = (int) elgg_get_plugin_setting('version', PLUGIN_ID);
	if ($version >= 20151008) {
		return true;
	}
	
	elgg_set_plugin_setting('version', 20151008, PLUGIN_ID);
	return true;
}