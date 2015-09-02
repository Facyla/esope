<?php
/**
 * Bookmarklet
 *
 * @package Bookmarks
 */

$title = elgg_echo('transitions:bookmarklet');
$bookmarklet_title = elgg_echo('transitions:bookmarklet:title');

$url = elgg_get_site_url();
$img = elgg_view('output/img', array(
	//'src' => 'mod/bookmarks/graphics/bookmarklet.gif',
	'src' => 'mod/transitions/graphics/bookmarklet-transitions.png',
	'alt' => $bookmarklet_title,
));
//$bookmarklet = "<a href=\"javascript:location.href='{$url}catalogue/add?url='"
//	. "+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)+'&description='+encodeURIComponent(document.getSelection())\">" . $img . "</a>";
$bookmarklet = '<a href="javascript:(function(){window.open(\'' . $url . 'catalogue/add?url=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&description=\'+encodeURIComponent(document.getSelection()), \'_newtab\');}());">' . $img . '</a>';
// Nouvel onglet : javascript:(function(){window.open('http://www.example.com', '_newtab');}());
// Même onglet, utilisez un code de ce type : javascript:location.href='http://www.example

$content = '';
$content .= '<p>' . elgg_echo("transitions:bookmarklet:description") . '</p>';
$content .= '<p>' . $bookmarklet . '</p>';
$content .= '<p>' . elgg_echo("transitions:bookmarklet:descriptionie") . '</p>';
$content .= '<p>' . elgg_echo("transitions:bookmarklet:description:conclusion") . '</p>';

echo elgg_view_module('aside', $title, $content);

