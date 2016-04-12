<?php

// Define options
$yn_opts = array('yes' => elgg_echo('survey:settings:yes'), 'no' => elgg_echo('survey:settings:no'));

$group_options = array(
	'yes_default' => elgg_echo('survey:settings:group_survey_default'),
	'yes_not_default' => elgg_echo('survey:settings:group_survey_not_default'),
	'no' => elgg_echo('survey:settings:no'),
);

$survey_group_access_options = array(
	'admins' => elgg_echo('survey:settings:group_access:admins'), 
	'members' => elgg_echo('survey:settings:group_access:members'),
	);

$survey_site_access_options = array(
	'admins' => elgg_echo('survey:settings:site_access:admins'), 
	'all' => elgg_echo('survey:settings:site_access:all'),
	);

$body = '';


// Get values
$survey_send_notification = elgg_get_plugin_setting('send_notification', 'survey');
$survey_create_in_river = elgg_get_plugin_setting('create_in_river', 'survey');
$survey_response_in_river = elgg_get_plugin_setting('response_in_river', 'survey');
$survey_group_survey = elgg_get_plugin_setting('group_survey', 'survey');
$survey_group_access = elgg_get_plugin_setting('group_access', 'survey');
$survey_site_access = elgg_get_plugin_setting('site_access', 'survey');
$survey_front_page = elgg_get_plugin_setting('front_page', 'survey');
$allow_close_date = elgg_get_plugin_setting('allow_close_date', 'survey');
$allow_open_survey = elgg_get_plugin_setting('allow_open_survey', 'survey');
$allow_show_active_only = elgg_get_plugin_setting('allow_show_active_only', 'survey');
$allow_results_export = elgg_get_plugin_setting('results_export', 'survey');



// Set defaults
if (!$survey_send_notification) { $survey_send_notification = 'yes'; }
if (!$survey_create_in_river) { $survey_create_in_river = 'yes'; }
if (!$survey_response_in_river) { $survey_response_in_river = 'no'; }
if (!$survey_group_survey) { $survey_group_survey = 'yes_default'; }
if (!$survey_group_access) { $survey_group_access = 'admins'; }
if (!$survey_site_access) { $survey_site_access = 'admins'; }
if (!$survey_front_page) { $survey_front_page = 'no'; }
if (!$allow_close_date) { $allow_close_date = 'yes'; }
if (!$allow_open_survey) { $allow_open_survey = 'no'; }
if (!$survey_show_active_only) { $survey_show_active_only = 'yes'; }
if (!$survey_results_export) { $survey_results_export = 'yes'; }



$body .= '<fieldset><legend>' . elgg_echo('survey:settings:notifications') . '</legend>';
	$body .= '<p><label>' . elgg_echo('survey:settings:send_notification:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[send_notification]', 'value' => $survey_send_notification, 'options_values' => $yn_opts));
	$body .= '</label><br />' . elgg_echo('survey:settings:send_notification:details');
	$body .= '</p>';

	$body .= '<p><label>' . elgg_echo('survey:settings:create_in_river:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[create_in_river]', 'value' => $survey_create_in_river, 'options_values' => $yn_opts));
	$body .= '</label></p>';

	$body .= '<p><label>' . elgg_echo('survey:settings:response_in_river:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[response_in_river]', 'value' => $survey_response_in_river, 'options_values' => $yn_opts));
	$body .= '</label></p>';

	$body .= '<p><label>' . elgg_echo('survey:settings:show_active_only') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[show_active_only]', 'value' => $survey_show_active_only, 'options_values' => $yn_opts));
	$body .= '</label></p>';
$body .= '</fieldset>';


$body .= '<fieldset><legend>' . elgg_echo('survey:settings:access') . '</legend>';
	$body .= '<p><label>' . elgg_echo('survey:settings:group:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[group_survey]', 'value' => $survey_group_survey, 'options_values' => $group_options));
	$body .= '</label></p>';

	$body .= '<p><label>' . elgg_echo('survey:settings:group_access:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[group_access]', 'value' => $survey_group_access, 'options_values' => $survey_group_access_options));
	$body .= '</label></p>';

	$body .= '<p><label>' . elgg_echo('survey:settings:site_access:title') . '</label>';
	$body .= elgg_view('input/select', array('name' => 'params[site_access]', 'value' => $survey_site_access, 'options_values' => $survey_site_access_options));
	$body .= '</label></p>';
	
	$body .= '<p><label>' . elgg_echo('survey:settings:front_page:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[front_page]', 'value' => $survey_front_page, 'options_values' => $yn_opts));
	$body .= '</label><br />' . elgg_echo('survey:settings:front_page:details') . '</p>';
	
	$body .= '<p><label>' . elgg_echo('survey:settings:results_export') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[results_export]', 'value' => $survey_results_export, 'options_values' => $yn_opts));
	$body .= '</label></p>';
$body .= '</fieldset>';


$body .= '<fieldset><legend>' . elgg_echo('survey:settings:options') . '</legend>';
	$body .= '<p><label>' . elgg_echo('survey:settings:allow_close_date:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[allow_close_date]', 'value' => $allow_close_date, 'options_values' => $yn_opts));
	$body .= '</label><br />' . elgg_echo('survey:settings:allow_close_date:details') . '</p>';

	$body .= '<p><label>' . elgg_echo('survey:settings:allow_open_survey:title') . ' ';
	$body .= elgg_view('input/select', array('name' => 'params[allow_open_survey]', 'value' => $allow_open_survey, 'options_values' => $yn_opts));
	$body .= '</label><br />' . elgg_echo('survey:settings:allow_open_survey:details') . '</p>';
$body .= '</fieldset>';


echo $body;

