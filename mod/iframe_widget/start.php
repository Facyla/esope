<?php
/**
 * Iframe Plugin
 * 
 * Provides an iframe widget
 **/

elgg_register_event_handler('plugins_boot', 'system', 'iframe_init');

function iframe_init() {
	elgg_register_widget_type('iframe_widget', elgg_echo('iframe:widget'), elgg_echo('iframe:description'), array('all'), true);

	elgg_extend_view('css','iframe_widget/css');
}


