<?php
/**
 * Web Services plugin settings
 */


echo '<div>';
echo elgg_view('output/longtext', array('value' => elgg_echo('web_services:settings:api_information')));
$api_url = $vars['url'] . 'services/api/rest/xml/?method=system.api.list&api_key=&auth_token=';
echo '<p>' . elgg_view('output/url', array('href' => $api_url, 'text' => $api_url)) . '</p>';
echo '<br />';

echo elgg_echo('web_services:settings_description');
echo elgg_view("input/checkboxes", array(
			'name' => 'params[enabled_webservices]',
			'value' => unserialize(elgg_get_plugin_setting('enabled_webservices', 'web_services')),
			'options' => array(
					elgg_echo("web_services:user") => 'user', 
					elgg_echo("web_services:messages") => 'message',
					elgg_echo("web_services:group") => 'group',
					elgg_echo("web_services:blog") => 'blog', 
					elgg_echo("web_services:wire") => 'wire', 
					elgg_echo("web_services:file") => 'file',
					elgg_echo("web_services:object") => 'object',
					elgg_echo("web_services:likes") => 'likes',
			)));

echo '</div>';

