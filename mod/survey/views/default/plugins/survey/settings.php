<?php

// Define options

$yn_options = array(elgg_echo('survey:settings:yes') => 'yes', elgg_echo('survey:settings:no') => 'no');

$group_options = array(elgg_echo('survey:settings:group_survey_default')=>'yes_default',
	elgg_echo('survey:settings:group_survey_not_default')=>'yes_not_default',
	elgg_echo('survey:settings:no')=>'no'
);

$survey_group_access_options = array(elgg_echo('survey:settings:group_access:admins') => 'admins', elgg_echo('survey:settings:group_access:members') => 'members');

$survey_site_access_options = array(elgg_echo('survey:settings:site_access:admins') => 'admins', elgg_echo('survey:settings:site_access:all') => 'all');

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


// Set defaults
if (!$survey_send_notification) { $survey_send_notification = 'yes'; }
if (!$survey_create_in_river) { $survey_create_in_river = 'yes'; }
if (!$survey_response_in_river) { $survey_response_in_river = 'no'; }
if (!$survey_group_survey) { $survey_group_survey = 'yes_default'; }
if (!$survey_group_access) { $survey_group_access = 'admins'; }
if (!$survey_site_access) { $survey_site_access = 'all'; }
if (!$survey_front_page) { $survey_front_page = 'no'; }
if (!$allow_close_date) { $allow_close_date = 'no'; }
if (!$allow_open_survey) { $allow_open_survey = 'no'; }



$body .= '<fieldset><legend>' . elgg_echo('survey:settings:notifications') . '</legend>';
	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:send_notification:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[send_notification]', 'value' => $survey_send_notification, 'options' => $yn_options));
	$body .= '</p>';

	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:create_in_river:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[create_in_river]', 'value' => $survey_create_in_river, 'options' => $yn_options));
	$body .= '</p>';

	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:response_in_river:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[response_in_river]', 'value' => $survey_response_in_river, 'options' => $yn_options));
	$body .= '</p>';
$body .= '</fieldset>';


$body .= '<fieldset><legend>' . elgg_echo('survey:settings:access') . '</legend>';
 	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:group:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[group_survey]', 'value' => $survey_group_survey, 'options' => $group_options));
	$body .= '</p>';

	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:group_access:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[group_access]', 'value' => $survey_group_access, 'options' => $survey_group_access_options));
	$body .= '</p>';

	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:site_access:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[site_access]', 'value' => $survey_site_access, 'options' => $survey_site_access_options));
	$body .= '</p>';
	
	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:front_page:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[front_page]', 'value' => $survey_front_page, 'options' => $yn_options));
	$body .= '</p>';
$body .= '</fieldset>';


$body .= '<fieldset><legend>' . elgg_echo('survey:settings:options') . '</legend>';
	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:allow_close_date:title') . '</label>';
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[allow_close_date]', 'value' => $allow_close_date, 'options' => $yn_options));
	$body .= '</p>';

	$body .= '<p>';
	$body .= '<label>' . elgg_echo('survey:settings:allow_open_survey:title');
	$body .= '<br />';
	$body .= elgg_view('input/radio', array('name' => 'params[allow_open_survey]', 'value' => $allow_open_survey, 'options' => $yn_options));
	$body .= '</p>';
$body .= '</fieldset>';


echo $body;

