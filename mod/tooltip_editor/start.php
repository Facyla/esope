<?php

/**
 * Development of this plugin was funded by Connecting Conservation
 * 
 * For tooltip package info see:  http://qtip2.com/demos
 */

require_once 'lib/functions.php';
require_once 'lib/hooks.php';

elgg_register_event_handler('init', 'system', 'tooltip_editor_init');

function tooltip_editor_init() {
	elgg_extend_view('js/elgg', 'js/jquery/qtip');
	elgg_extend_view('css/elgg', 'css/jquery/qtip');
	elgg_extend_view('css/elgg', 'css/tooltip_editor/site');
	elgg_extend_view('css/admin', 'css/tooltip_editor/admin');
	elgg_extend_view('js/elgg', 'js/tooltip_editor/js');
	
	elgg_register_plugin_hook_handler('register', 'all', 'tooltip_editor_menu_modify');
	
	if (tooltip_editor_can_edit()) {
		elgg_load_css('lightbox');
		elgg_load_js('lightbox');
		
		elgg_register_ajax_view('tooltip_editor/form');
	}
	
	if (elgg_is_admin_logged_in()) {
		elgg_register_menu_item('extras', array(
			'name' => 'tooltip_editor',
			'text' => elgg_view_icon("speech-bubble-alt"),
			'href' => 'action/tooltip_editor/toggle',
			'is_action' => true,
			'title' => elgg_echo('tooltip_editor:admin:toggle:help'),
		));
		
		elgg_register_menu_item('admin_control_panel', array(
			'name' => 'tooltip_editor',
			'text' => elgg_echo('tooltip_editor:admin:edit'),
			'href' => 'action/tooltip_editor/toggle',
			'is_action' => true,
			'title' => elgg_echo('tooltip_editor:admin:toggle:help'),
			'link_class' => 'elgg-button elgg-button-action'
		));
		
		elgg_register_action('tooltip_editor/toggle', dirname(__FILE__) . '/actions/toggle.php', 'admin');
		elgg_register_action('tooltip_editor/edit', dirname(__FILE__) . '/actions/edit.php', 'admin');
	}
}
