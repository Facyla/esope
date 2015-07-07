<?php
/**
 * English strings
 */

$url = elgg_get_site_url();
$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . $url . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Powered by Elgg" width="106" height="15" /></a></div>';

return array(
	
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
	'export_embed:widget:group_guid:help' => "Group \"GUID\" is the unique number that is displayed in the group URL. E.g. it is XXXXX in " . $url . "<em>groups/profile/<strong>XXXXX</strong>/group-name</em>.",
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
	'export_embed:type:profile_card' => "Profile card", 
	'export_embed:type:entity' => "Entity display", 
	'export_embed:type:entities' => "Entities display", 
	
	// Exported elements
	'export_embed:notconfigured' => "<p>This widget is not configured yet (or the parameters are invalid)).</p>
		<p>
			If you want to display this site's widgets on another site, please use following informations&nbsp;:
			<ul>
				<li>Site address&nbsp;: <strong>" . $url . "</strong></li>
				<li>Then select the informations you wish to display in the dropdown menu.</li>
				<li>To display a specific group activity, you need to set the GUID of that group : it is the number that displays in the group URL : <em>groups/profile/<strong>GUID</strong>/group-name</em></li>
			</ul></p>",
	'export_embed:nocontent' => "No content yet.",
	'export_embed:notconnected' => "CAUTION, you're not logged on %s. Please <a href=\"" . $url . "\" target=\"_blank\">log in</a> to access content that is restricted to the site members",
	'export_embed:openintab' => "Open %s in a new tab",
	'export_embed:site_activity' => "%s's activity", 
	'export_embed:site_activity:viewall' => "View all site activity", 
	'export_embed:friends_activity' => "Friends activity", 
	'export_embed:friends_activity:viewall' => "View all site activity", 
	'export_embed:my_activity' => "My activity", 
	'export_embed:my_activity:viewall' => "View all site activity", 
	'export_embed:group_activity' => "Recent activity of group %s of %s", 
	'export_embed:group_activity:viewall' => "Display %s group", 
	'export_embed:group_activity:noaccess' => "No access or invalid group GUID", 
	'export_embed:groups_list' => "%s's group list", 
	'export_embed:groups_list:viewall' => "Display group list", 
	'export_embed:groups_list' => "Display featured group list of %s", 
	'export_embed:groups_list:viewall' => 'Display featured group list', 
	'export_embed:agenda' => "%s's calendar",
	'export_embed:agenda:viewall' => 'Calendar',
	'export_embed:entity' => "Display %s", 
	'export_embed:entity:noaccess' => "No access or invalid GUIDs", 
	'export_embed:entities' => "Display %s", 
	'export_embed:entities:noaccess' => "No access or invalid GUIDs", 
	
);

