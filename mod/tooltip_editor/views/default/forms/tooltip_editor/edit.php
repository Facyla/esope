<?php

$title = elgg_echo('tooltip_editor:form:edit:title');

$title_label = elgg_echo('tooltip_editor:label:title');
$title_input = elgg_view('input/text', array(
	'name' => 'params[tooltip_title]',
	'value' => $vars['tooltip_title'],
));

$tooltip_label = elgg_echo('tooltip_editor:label:tooltip');
$tooltip_input = elgg_view('input/plaintext', array(
	'name' => 'params[tooltip]',
	'value' => $vars['tooltip']
));
$tooltip_help = elgg_view('output/longtext', array(
	'value' => elgg_echo('tooltip_editor:tooltip:help'),
	'class' => 'elgg-subtext'
));

$position_my_label = elgg_echo('tooltip_editor:label:positionmy');
$position_my_input = elgg_view('input/dropdown', array(
	'name' => 'params[positionmy]',
	'value' => $vars['positionmy'],
	'options_values' => array(
		'top left' => elgg_echo('tooltip_editor:positionmy:topleft'),
		'top center' => elgg_echo('tooltip_editor:positionmy:topcenter'),
		'top right' => elgg_echo('tooltip_editor:positionmy:topright'),
		'center left' => elgg_echo('tooltip_editor:positionmy:centerleft'),
		'center center' => elgg_echo('tooltip_editor:positionmy:centercenter'),
		'center right' => elgg_echo('tooltip_editor:positionmy:centerright'),
		'bottom left' => elgg_echo('tooltip_editor:positionmy:bottomleft'),
		'bottom center' => elgg_echo('tooltip_editor:positionmy:bottomcenter'),
		'bottom right' => elgg_echo('tooltip_editor:positionmy:bottomright'),
		'left top' => elgg_echo('tooltip_editor:positionmy:lefttop'),
		'left center' => elgg_echo('tooltip_editor:positionmy:leftcenter'),
		'left bottom' => elgg_echo('tooltip_editor:positionmy:leftbottom'),
		'center top' => elgg_echo('tooltip_editor:positionmy:centertop'),
		'center bottom' => elgg_echo('tooltip_editor:positionmy:centerbottom'),
		'right top' => elgg_echo('tooltip_editor:positionmy:righttop'),
		'right center' => elgg_echo('tooltip_editor:positionmy:rightcenter'),
		'right bottom' => elgg_echo('tooltip_editor:positionmy:rightbottom'),
	)
));

$link = elgg_view('output/url', array(
	'href' => "http://qtip2.com/demos#section-positioning",
	'text' => "http://qtip2.com/demos#section-positioning",
	'target' => "_blank"
));

$position_my_input_help = elgg_view('output/longtext', array(
	'value' => elgg_echo('tooltip_editor:positionmy:help', array($link)),
	'class' => 'elgg-subtext'
));

$position_at_label = elgg_echo('tooltip_editor:label:positionat');
$position_at_input = elgg_view('input/dropdown', array(
	'name' => 'params[positionat]',
	'value' => $vars['positionat'],
	'options_values' => array(
		'top left' => elgg_echo('tooltip_editor:positionmy:topleft'),
		'top center' => elgg_echo('tooltip_editor:positionmy:topcenter'),
		'top right' => elgg_echo('tooltip_editor:positionmy:topright'),
		'center left' => elgg_echo('tooltip_editor:positionmy:centerleft'),
		'center center' => elgg_echo('tooltip_editor:positionmy:centercenter'),
		'center right' => elgg_echo('tooltip_editor:positionmy:centerright'),
		'bottom left' => elgg_echo('tooltip_editor:positionmy:bottomleft'),
		'bottom center' => elgg_echo('tooltip_editor:positionmy:bottomcenter'),
		'bottom right' => elgg_echo('tooltip_editor:positionmy:bottomright'),
	)
));

$persistent_label = elgg_echo('tooltip_editor:label:persistent');
$persistent_input = elgg_view('input/dropdown', array(
	'name' => 'params[persistent]',
	'value' => $vars['persistent'],
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	)
));

$tooltip_delay_label = elgg_echo('tooltip_editor:label:delay');
$tooltip_delay_input = elgg_view('input/text', array(
	'name' => 'params[delay]',
	'value' => $vars['delay']
));

$fontsize_label = elgg_echo('tooltip_editor:label:fontsize');
$fontsize_input = elgg_view('input/dropdown', array(
	'name' => 'params[fontsize]',
	'value' => $vars['fontsize'],
	'options_values' => array(
		'6' => '6px',
		'8' => '8px',
		'10' => '10px',
		'12' => '12px',
		'14' => '14px',
		'16' => '16px',
		'18' => '18px',
		'20' => '20px',
	)
));

$body = '';

if ($vars['set_content']) {
$body .= <<<BODY
	<label>$title_label</label><br>
	$title_input
		
	<br><br>
	
	<label>$tooltip_label</label><br>
	$tooltip_input
	$tooltip_help
	
	<br>
BODY;
}

$body .= <<<BODY
	<label>$tooltip_delay_label</label>
	$tooltip_delay_input
	
	<br><br>
		
	<label>$position_my_label</label>&nbsp;&nbsp;
	$position_my_input
	$position_my_input_help
		
	<br>
		
	<label>$position_at_label</label>&nbsp;&nbsp;
	$position_at_input
	$position_my_input_help
		
	<br>
		
	<label>$fontsize_label</label> &nbsp;&nbsp;
	$fontsize_input
		
	<br><br>
		
	<label>$persistent_label</label>&nbsp;&nbsp;
	$persistent_input
BODY;

if ($vars['token']) {
	$body .= elgg_view('input/hidden', array('name' => 'token', 'value' => $vars['token']));
}

// bit of a hack but we want to reuse this form in settings
// which already has a submit button
if ($vars['submit']) {
	$body .= '<br><br>';
	$body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));
}

echo elgg_view_module('info', $title, $body, array('class' => 'menu-tooltip-module'));