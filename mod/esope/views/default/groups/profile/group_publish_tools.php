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
if (elgg_get_plugin_setting('groups_add_publish_tools', 'esope') == 'yes') {
	global $CONFIG;
	
	if ($group->forum_enable == 'yes') {
		$tabs[] = '<a href="' . $CONFIG->url . 'discussion/add' . $group->guid . '" class="group-tool-tab">' . elgg_echo('esope:icon:discussion') . '<br />' . elgg_echo('discussion:add') . '</a>';
	}
	if ($group->bookmarks_enable == 'yes') {
		$tabs[] = '<a href="' . $CONFIG->url . 'bookmarks/add' . $group->guid . '" class="group-tool-tab">' . elgg_echo('esope:icon:bookmarks') . '<br />' . elgg_echo('bookmarks:add') . '</a>';
	}
	if ($group->event_calendar_enable == 'yes') {
		$tabs[] = '<a href="' . $CONFIG->url . 'event_calendar/add' . $group->guid . '" class="group-tool-tab">' . elgg_echo('esope:icon:event_calendar') . '<br />' . elgg_echo('event_calendar:add_event_title') . '</a>';
	}
	echo '<div id="group-tool-tabs">';
	//echo '<i class="fa fa-plus"> &nbsp; ';
	echo implode('', $tabs);
	echo '<div class="clearfloat"></div>';
	echo '</div>';
	
	/* Tabs and direct publication tools
	$tools = array('discussion' => 'discussion/save', 'file' => 'file/upload', 'bookmarks' => 'bookmarks/save', 'event_calendar' => 'event_calendar/edit');
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
	*/
}


