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
	
	// Announcements
	if (elgg_is_active_plugin('announcements') && $group->announcements_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-announcements\').toggle()" '; }
		else { $text = '<a href="' . $url . 'announcements/add/' . $group->guid . '"';
		$text .= ' class="group-tool-tab" title="' . elgg_echo('announcements:add') . '">' . elgg_echo('esope:icon:announcements'); }
		if ($add_text) { $text .= '<br />' . elgg_echo('announcements:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-announcements" style="display:none;">' . elgg_view_form('announcements/add', $vars) . '</div>'; }
	}
	
	if ($group->forum_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-forum\').toggle()" '; }
		else { $text = '<a href="' . $url . 'discussion/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('discussion:add') . '">' . elgg_echo('esope:icon:discussion');
		if ($add_text) { $text .= '<br />' . elgg_echo('discussion:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-forum" style="display:none;">' . elgg_view_form('discussion/add', $vars) . '</div>'; }
	}
	
	// Blog
	if (elgg_is_active_plugin('blog') && $group->blog_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-blog\').toggle()" '; }
		else { $text = '<a href="' . $url . 'blog/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('blog:add') . '">' . elgg_echo('esope:icon:blog');
		if ($add_text) { $text .= '<br />' . elgg_echo('blog:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-blog" style="display:none;">' . elgg_view_form('blog/save', $vars) . '</div>'; }
	}
	
	// Files
	if (elgg_is_active_plugin('file') && $group->file_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-file\').toggle()" '; }
		else { $text = '<a href="' . $url . 'file/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('file:add') . '">' . elgg_echo('esope:icon:file');
		if ($add_text) { $text .= '<br />' . elgg_echo('file:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-file" style="display:none;">' . elgg_view_form('file/upload', $vars) . '</div>'; }
	}
	
	// Bookmarks
	if (elgg_is_active_plugin('bookmarks') && $group->bookmarks_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-bookmarks\').toggle()" '; }
		else { $text = '<a href="' . $url . 'bookmarks/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('bookmarks:add') . '">' . elgg_echo('esope:icon:bookmarks');
		if ($add_text) { $text .= '<br />' . elgg_echo('bookmarks:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-bookmarks" style="display:none;">' . elgg_view_form('bookmarks/save', $vars) . '</div>'; }
	}
	
	if (elgg_is_active_plugin('pages') && $group->pages_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-pages\').toggle()" '; }
		else { $text = '<a href="' . $url . 'pages/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('pages:add') . '">' . elgg_echo('esope:icon:pages');
		if ($add_text) { $text .= '<br />' . elgg_echo('pages:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-pages" style="display:none;">' . elgg_view_form('pages/add', $vars) . '</div>'; }
	}
	
	// Event calendar (K. Jardine)
	if (elgg_is_active_plugin('event_calendar') && $group->event_calendar_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-event_calendar\').toggle()"'; }
		else { $text = '<a href="' . $url . 'event_calendar/add/' . $group->guid . '"'; }
		$text .= '  class="group-tool-tab" title="' . elgg_echo('event_calendar:add') . '">' . elgg_echo('esope:icon:event_calendar');
		if ($add_text) { $text .= '<br />' . elgg_echo('event_calendar:add_event_title'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-event_calendar" style="display:none;">' . elgg_view_form('event_calendar/edit', $vars) . '</div>'; }
	}
	
	// Newsletter
	if ($group->newsletter_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-newsletter\').toggle()" '; }
		else { $text = '<a href="' . $url . 'newsletter/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('newsletter:add') . '">' . elgg_echo('esope:icon:newsletter');
		if ($add_text) { $text .= '<br />' . elgg_echo('newsletter:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-newsletter" style="display:none;">' . elgg_view_form('newsletter/edit', $vars) . '</div>'; }
	}
	
	// Market - petites annonces
	if (elgg_is_active_plugin('market') && $group->market_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-market\').toggle()" '; }
		else { $text = '<a href="' . $url . 'market/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('market:add') . '">' . elgg_echo('esope:icon:market');
		if ($add_text) { $text .= '<br />' . elgg_echo('market:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-market" style="display:none;">' . elgg_view_form('market/save', $vars) . '</div>'; }
	}
	
	// Poll - sondages courts (1 question fermée)
	if (elgg_is_active_plugin('poll') && $group->poll_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-poll\').toggle()" '; }
		else { $text = '<a href="' . $url . 'poll/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('poll:add') . '">' . elgg_echo('esope:icon:poll');
		if ($add_text) { $text .= '<br />' . elgg_echo('poll:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-poll" style="display:none;">' . elgg_view_form('poll/edit', $vars) . '</div>'; }
	}
	
	// Survey - Sondage complet
	if (elgg_is_active_plugin('survey') && $group->survey_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-survey\').toggle()" '; }
		else { $text = '<a href="' . $url . 'survey/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('survey:add') . '">' . elgg_echo('esope:icon:survey');
		if ($add_text) { $text .= '<br />' . elgg_echo('survey:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-survey" style="display:none;">' . elgg_view_form('survey/edit', $vars) . '</div>'; }
	}
	
	// Transitions - versatile content for Transitions²
	if (elgg_is_active_plugin('transitions') && $group->transitions_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-transitions\').toggle()" '; }
		else { $text = '<a href="' . $url . 'transitions/add/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('transitions:add') . '">' . elgg_echo('esope:icon:transitions');
		if ($add_text) { $text .= '<br />' . elgg_echo('transitions:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-transitions" style="display:none;">' . elgg_view_form('transitions/save', $vars) . '</div>'; }
	}
	
	// Event - calendrier (Coldtrick)
	if (elgg_is_active_plugin('event_manager') && $group->event_manager_enable == 'yes') {
		if ($add_form) { $text = '<a href="javascript:void(0);" onclick="javascript:$(\'#group-tool-tab-events\').toggle()" '; }
		else { $text = '<a href="' . $url . 'events/event/new/' . $group->guid . '"'; }
		$text .= ' class="group-tool-tab" title="' . elgg_echo('events:add') . '">' . elgg_echo('esope:icon:event');
		if ($add_text) { $text .= '<br />' . elgg_echo('events:add'); }
		$text .=  '</a>';
		$tabs[] = $text;
		if ($add_form) { $add_forms .= '<div id="group-tool-tab-events" style="display:none;">' . elgg_view_form('events/upload', $vars) . '</div>'; }
	}
	
	
	// Compose tools bar
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


