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
	
	$url = elgg_get_site_url();
	$add_text = false;
	$add_form = false;
	$add_forms = '';
	
	if ($group->announcements_enable == 'yes') {
		if ($add_form) $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-announcements\').toggle()" ';
		else $text = '<a href="' . $url . 'announcements/add/' . $group->guid . '"';
		$text .= ' class="group-tool-tab" title="' . elgg_echo('announcements:add') . '">' . elgg_echo('esope:icon:announcements');
		if ($add_text) $text .= '<br />' . elgg_echo('announcements:add');
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) $add_forms .= '<div id="group-tool-tab-announcements" style="display:none;">' . elgg_view_form('announcements/add', $vars) . '</div>';
	}
	
	if ($group->forum_enable == 'yes') {
		if ($add_form) $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-forum\').toggle()" ';
		else $text = '<a href="' . $url . 'discussion/add/' . $group->guid . '"';
		$text .= ' class="group-tool-tab" title="' . elgg_echo('discussion:add') . '">' . elgg_echo('esope:icon:discussion');
		if ($add_text) $text .= '<br />' . elgg_echo('discussion:add');
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) $add_forms .= '<div id="group-tool-tab-forum" style="display:none;">' . elgg_view_form('discussion/add', $vars) . '</div>';
	}
	
	if ($group->blog_enable == 'yes') {
		if ($add_form) $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-blog\').toggle()" ';
		else $text = '<a href="' . $url . 'blog/add/' . $group->guid . '"';
		$text .= ' class="group-tool-tab" title="' . elgg_echo('blog:add') . '">' . elgg_echo('esope:icon:blog');
		if ($add_text) $text .= '<br />' . elgg_echo('blog:add');
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) $add_forms .= '<div id="group-tool-tab-blog" style="display:none;">' . elgg_view_form('blog/save', $vars) . '</div>';
	}
	
	if ($group->file_enable == 'yes') {
		if ($add_form) $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-file\').toggle()" ';
		else $text = '<a href="' . $url . 'file/add/' . $group->guid . '"';
		$text .= ' class="group-tool-tab" title="' . elgg_echo('file:add') . '">' . elgg_echo('esope:icon:file');
		if ($add_text) $text .= '<br />' . elgg_echo('file:add');
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) $add_forms .= '<div id="group-tool-tab-file" style="display:none;">' . elgg_view_form('file/upload', $vars) . '</div>';
	}
	
	if ($group->bookmarks_enable == 'yes') {
		if ($add_form) $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-bookmarks\').toggle()" ';
		else $text = '<a href="' . $url . 'bookmarks/add/' . $group->guid . '"';
		$text .= ' class="group-tool-tab" title="' . elgg_echo('bookmarks:add') . '">' . elgg_echo('esope:icon:bookmarks');
		if ($add_text) $text .= '<br />' . elgg_echo('bookmarks:add');
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) $add_forms .= '<div id="group-tool-tab-bookmarks" style="display:none;">' . elgg_view_form('bookmarks/save', $vars) . '</div>';
	}
	
	if ($group->pages_enable == 'yes') {
		if ($add_form) $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-pages\').toggle()" ';
		else $text = '<a href="' . $url . 'pages/add/' . $group->guid . '"';
		$text .= ' class="group-tool-tab" title="' . elgg_echo('pages:add') . '">' . elgg_echo('esope:icon:pages');
		if ($add_text) $text .= '<br />' . elgg_echo('pages:add');
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) $add_forms .= '<div id="group-tool-tab-pages" style="display:none;">' . elgg_view_form('pages/add', $vars) . '</div>';
	}
	
	if ($group->event_calendar_enable == 'yes') {
		if ($add_form) $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-event_calendar\').toggle()"';
		else $text = '<a href="' . $url . 'event_calendar/add/' . $group->guid . '"';
		$text .= '  class="group-tool-tab" title="' . elgg_echo('event_calendar:add') . '">' . elgg_echo('esope:icon:event_calendar');
		if ($add_text) $text .= '<br />' . elgg_echo('event_calendar:add_event_title');;
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) $add_forms .= '<div id="group-tool-tab-event_calendar" style="display:none;">' . elgg_view_form('event_calendar/edit', $vars) . '</div>';
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


