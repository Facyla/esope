<?php

if (empty($vars['entity']->publicAvailable)) {
	$publicAvailable = 'no';
} else {
	$publicAvailable = $vars['entity']->publicAvailable;
}

if (empty($vars['entity']->publicAvailable_sitemenu)) {
	$publicAvailable_sitemenu = 'no';
} else {
	$publicAvailable_sitemenu = $vars['entity']->publicAvailable_sitemenu;
}

if (empty($vars['entity']->publicAvailable_footerlink)) {
	$publicAvailable_footerlink = 'no';
} else {
	$publicAvailable_footerlink = $vars['entity']->publicAvailable_footerlink;
}

if (empty($vars['entity']->userQuestions)) {
	$userQuestions = 'no';
} else {
	$userQuestions = $vars['entity']->userQuestions;
}

if (!$vars['entity']->minimumSearchTagSize) {
	$minimumSearchTagSize = 3;
} else {
	$minimumSearchTagSize = $vars['entity']->minimumSearchTagSize;
}

if (!$vars['entity']->minimumHitCount) {
	$minimumHitCount = 1;
} else {
	$minimumHitCount = $vars['entity']->minimumHitCount;
}


// Publicly available?
$form = "<div class='mbm'>";
$form .= "<label>" . elgg_echo("faq:settings:public") . "</label>";
$form .= elgg_view('input/select', array(
	'name' => 'params[publicAvailable]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
	'value' => $publicAvailable
));
$form .= "</div>";

// Site Menu entry visible when not logged in?
$form .= "<div class='mbm'>";
$form .= "<label>" . elgg_echo("faq:settings:publicAvailable_sitemenu") . "</label>";
$form .= elgg_view('input/select', array(
	'name' => 'params[publicAvailable_sitemenu]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
	'value' => $publicAvailable_sitemenu
));
$form .= "</div>";

// Footer link visible when not logged in?
$form .= "<div class='mbm'>";
$form .= "<label>" . elgg_echo("faq:settings:publicAvailable_footerlink") . "</label>";
$form .= elgg_view('input/select', array(
	'name' => 'params[publicAvailable_footerlink]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
	'value' => $publicAvailable_footerlink
));
$form .= "</div>";

// Allow user questions?
$form .= "<div class='mbm'>";
$form .= "<label>" . elgg_echo("faq:settings:ask") . "</label>";
$form .= elgg_view('input/select', array(
	'name' => 'params[userQuestions]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
	'value' => $userQuestions
));
$form .= "</div>";

// Minimum search word length
$form .= "<div class='mbm'>";
$form .= "<label>" . elgg_echo("faq:settings:minimum_search_tag_size") . "</label><br>";
$form .= elgg_view('input/text', array(
	'name' => 'params[minimumSearchTagSize]',
	'value' => $minimumSearchTagSize
));
$form .= "</div>";

// Minimum search hit count
$form .= "<div class='mbm'>";
$form .= "<label>" . elgg_echo("faq:settings:minimum_hit_count") . "</label><br>";
$form .= elgg_view('input/text', array(
	'name' => 'params[minimumHitCount]',
	'value' => $minimumHitCount
));
$form .= "</div>";

echo $form;