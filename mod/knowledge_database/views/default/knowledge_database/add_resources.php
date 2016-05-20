<?php
// Add content block

$content = '<div class="knowledge_database-add-resources">';

$content .= '<h3>' . elgg_echo('knowledge_database:addresource') . '</h3>';

if (elgg_is_logged_in()) {
	
	$publish_guid = elgg_extract('publish_guid', $vars);
	if (!$publish_guid) { $publish_guid = elgg_get_logged_in_user_guid(); }
	if ($publish_entity = get_entity($publish_guid)) {
		$content .= '<ul id="knowledge_database-add">';
		foreach ($vars['tools'] as $tool) {
			$content .= '<li><a href="' . elgg_get_site_url() . $tool . '/add/' . $publish_guid . '">' . elgg_echo('knowledge_database:add' . $tool) . '</a></li>';
		}
		$content .= '</ul>';
	}
	
} else {
	$content = '<h3>' . elgg_echo('knowledge_database:contribute') . '</h3>';
}

$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

echo $content;


