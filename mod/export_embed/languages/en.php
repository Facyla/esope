<?php
/**
 * English strings
 */

$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . elgg_get_site_url() . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Powered by Elgg" width="106" height="15" /></a></div>';

$en = array(
	
	'export_embed' => "Embeddable Widgets",
	'export_embed:help' => "These widgets allow to access remote data from other Elgg sites. They are useful to embed Elgg content into a news agregator or custom dashboard.<br />They are accessible via a genric or custom URL, and can also be embedded on your desk, or in a website.",
	'export_embed:widget:title' => "Embeddable Widgets",
	'export_embed:widget:description' => "Lets you display information from other Elgg sites, or widgets from other websites.",
	
	// Embed widget settings
	'export_embed:widget:embedurl' => "Widget URL",
	'export_embed:widget:embedurl:help' => "Full URL of embeddable widget (if set, replaces the 2 other settings below).",
	'export_embed:widget:site_url' => "Site URL",
	'export_embed:widget:site_url:help' => "The main URL of the site you want to get your data from. On a Elgg site, this is your dashboard URL, ending with a \"/\" and before any \"export_embed\" word.",
	'export_embed:widget:embedtype' => "Widget type",
	'export_embed:widget:embedtype:help' => "The widget type you want to display. Settings below will be needed or not depending on the widget type.",
	'export_embed:widget:limit' => "Number of items to display",
	'export_embed:widget:limit:help' => "Limits the number of displayed results, for lists.",
	'export_embed:widget:offset' => "Start at specific offset (default is 0)",
	'export_embed:widget:offset:help' => "For lists, lets you start at o specific offset (= number of results to ignore).",
	'export_embed:widget:group_guid' => "Group number (GUID) (if needed)",
	'export_embed:widget:group_guid:help' => "Group \"GUID\" is the unique number that is displayed in the group URL. E.g. it is XXXXX in " . elgg_get_site_url() . "<em>groups/profile/<strong>XXXXX</strong>/group-name</em>.",
	'export_embed:widget:user_guid' => "Member number (GUID) (if needed)",
	'export_embed:widget:user_guid:help' => "This number is quite harder to get as a basic user. It is mainly used by administrators who would wish to follow a specific user's activity.",
	'export_embed:widget:params' => "Additional parameters (param1=value1&param2=value2... etc.)",
	'export_embed:widget:params:help' => "Various other optional custom parameters can be added via the common URL parameter syntax: <strong>param1=value1&amp;param2=value2</strong> etc.)",
	
	// Embed type
  'export_embed:type:site_activity' => 'Site activity', 
  'export_embed:type:friends_activity' => 'Friends activity', 
  'export_embed:type:my_activity' => 'My activity', 
  'export_embed:type:group_activity' => "Group activity", 
  'export_embed:type:groups_list' => 'Public groups list', 
  'export_embed:type:agenda' => 'Calendar',
	
	'' => "",
	
);

add_translation('en', $en);

