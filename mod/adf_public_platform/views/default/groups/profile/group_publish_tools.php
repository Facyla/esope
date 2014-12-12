<?php
/**
* Group profile activity
* 
* @package ElggGroups
*/ 

$group = $vars['entity'];

// @TODO : dev en cours, vérifier si les outils existent, mise en page, icônes, formulaires spécifiques plus courts...
// Ou mettre de simples liens...

// ESOPE : add publication tools if asked
if (elgg_get_plugin_setting('groups_add_publish_tools', 'adf_public_platform') == 'yes') {
	$tools = array('discussion' => 'discussion/save', 'file' => 'file/upload', 'bookmarks' => 'bookmarks/save', 'event_calendar' => 'event_calendar/edit');
	foreach ($tools as $tool => $form_name) {
		$tabs[] = '<div class="group-tool-tab group-tool-tab-' . $tool . '"><a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-' . $tool . '\').toggle()">' . elgg_echo($tool) . '</a></div>';
		$forms[] = '<div id="group-tool-tab-' . $tool . '" style=display:none;">' . elgg_view_form($form_name, $vars) . '</div>';
	}

	echo '<div id="group-tool-tabs">';
	echo implode('', $tabs);
	echo '<div class="clearfloat"></div>';
	echo implode('', $forms);
	echo '</div>';
}


