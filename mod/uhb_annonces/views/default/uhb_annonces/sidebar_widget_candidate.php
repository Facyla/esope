<?php
// All candidate specific infos and actions (does not include those related to a specific offer)

$title = elgg_echo('uhb_annonces:sidebar:title');

$content = '';

$ownguid = elgg_get_logged_in_user_guid();

$mycandidated = uhb_annonces_get_from_relationship('has_candidated', $ownguid, false, true);
$mymemorised = uhb_annonces_get_from_relationship('memorised', $ownguid, false, true);

// List generic tools for candidates
//$content .= '<p><a href="' . $CONFIG->url . 'annonces/search">' . elgg_echo('uhb_annonces:sidebar:search') . '</a></p>';
$content .= '<p><a href="' . $CONFIG->url . 'annonces/list/memorised">' . elgg_echo('uhb_annonces:sidebar:memorised', array($mymemorised)) . '</a></p>';
$content .= '<p><a href="' . $CONFIG->url . 'annonces/list/candidated">' . elgg_echo('uhb_annonces:sidebar:candidated', array($mycandidated)) . '</a></p>';


echo elgg_view_module('aside', $title, $content);

