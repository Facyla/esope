<?php
	$renderto_subtypes = array_filter(explode(',', elgg_get_plugin_setting('renderto_subtypes','related-items')));
	if(in_array($vars['entity']->getSubtype(),$renderto_subtypes))
		related_items($vars['entity']);
?>