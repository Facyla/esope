<?php
// All admin specific infos and actions (does not include those related to a specific offer)
// (so basically we have admin stats here)

$title = elgg_echo('uhb_annonces:sidebar:stats:title');

$content = '';

$memorised = uhb_annonces_get_from_relationship('memorised', false, false, true);
$candidated = uhb_annonces_get_from_relationship('has_candidated', false, false, true);
$reported = uhb_annonces_get_from_relationship('reported', false, false, true);

/*
$content .= '<p><a href="' . $CONFIG->url . 'annonces/list/memorised">' . elgg_echo('uhb_annonces:sidebar:stats:memorised', array($memorised)) . '</a></p>';
$content .= '<p><a href="' . $CONFIG->url . 'annonces/list/candidated">' . elgg_echo('uhb_annonces:sidebar:stats:candidated', array($candidated)) . '</a></p>';
$content .= '<p><a href="' . $CONFIG->url . 'annonces/list/reported">' . elgg_echo('uhb_annonces:sidebar:stats:reported', array($reported)) . '</a></p>';
*/
$content .= '<p><a href="' . $CONFIG->url . 'annonces/search?followinterested_min=1">' . elgg_echo('uhb_annonces:sidebar:stats:memorised', array($memorised)) . '</a></p>';
$content .= '<p><a href="' . $CONFIG->url . 'annonces/list/candidated?followcandidates_min=1">' . elgg_echo('uhb_annonces:sidebar:stats:candidated', array($candidated)) . '</a></p>';
$content .= '<p><a href="' . $CONFIG->url . 'annonces/list/reported?followreport_min=1">' . elgg_echo('uhb_annonces:sidebar:stats:reported', array($reported)) . '</a></p>';

/*
$entity = elgg_extract('entity', $vars);
if (elgg_instanceof($entity, 'object', 'uhb_offer')) {
	$content .= '<p><a href="' . $CONFIG->url . 'annonces/">' . elgg_echo('uhb_annonces:sidebar:resendconfirm') . '</a><br />';
	$content .= '<a href="' . $CONFIG->url . 'annonces/">' . elgg_echo('uhb_annonces:sidebar:validate') . '</a></p>';
	$content .= '<p><a href="' . $CONFIG->url . 'annonces/">' . elgg_echo('uhb_annonces:sidebar:publish') . '</a></p>';
	$content .= '<p><a href="' . $CONFIG->url . 'annonces/">' . elgg_echo('uhb_annonces:sidebar:removefilled') . '</a></p>';
	$content .= '<p><a href="' . $CONFIG->url . 'annonces/">' . elgg_echo('uhb_annonces:sidebar:archive') . '</a></p>';
}
*/

echo elgg_view_module('aside', $title, $content);

