<?php
// Displays social presence links

$content = '';

$tools = array('contactemail', 'rss', 'twitter', 'facebook', 'googleplus', 'linkedin', 'netvibes', 'flickr', 'youtube', 'vimeo', 'dailymotion', 'vine', 'instagram', 'github', 'delicious', 'pinterest', 'tumblr', 'slideshare');

foreach ($tools as $tool) {
	$tool_value = elgg_get_plugin_setting($tool, 'esope');
	if (!empty($tool_value)) {
		$content .= '<li class="' . $tool . '"><a href="' . $tool_value . '" target="_blank" title="' . elgg_echo("esope:settings:$tool:title") . '">' . elgg_echo("esope:settings:$tool:icon") . '</a></li>';
	}
}

if (!empty($content)) {
	echo '<div id="social-presence"><ul>' . $content . '</ul></div>';
}

