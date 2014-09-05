<?php
// Displays social presence links

$content = '';

$tools = array('contactemail', 'rss', 'twitter', 'facebook', 'googleplus', 'lindekin', 'netvibes', 'flickr', 'youtube', 'dailymotion', 'pinterest', 'tumblr', 'slideshare');

foreach ($tools as $tool) {
	$tool_value = elgg_get_plugin_setting('contactemail', 'adf_public_platform');
	if (!empty($tool_value)) {
		$content .= '<li class="' . $tool . '"><a href="' . $tool_value . '" target="_blank" title="' . elgg_echo("adf_platform:settings:$tool:title") . '">' . elgg_echo("adf_platform:settings:$tool:icon") . '</a></li>';
	}
}

if (!empty($content)) echo '<div id="social-presence"><ul>' . $content . '</ul></div>';

