<?php
/**
 * Bookmarklet
 *
 * @package Bookmarks
 */

$page_owner = elgg_get_page_owner_entity();

if ($page_owner instanceof ElggGroup) {
	$title = elgg_echo("bookmarks:this:group", array($page_owner->name));
} else {
	$title = elgg_echo("bookmarks:this");
}

$guid = $page_owner->getGUID();

if (!$name && ($user = elgg_get_logged_in_user_entity())) {
	$name = $user->username;
}

$url = elgg_get_site_url();
$img = elgg_view('output/img', array(
	'src' => 'mod/bookmarks/graphics/bookmarklet.gif',
	'alt' => $title,
));
// Note : keep default container so we can send directly to a group, but allow to change in the form
$bookmarklet = '<a href="javascript:location.href=\'' . $url . 'bookmarks/add/' . $guid . '?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&place=yes&description=\'+encodeURIComponent(document.getSelection())">' . $img . '</a>';
//$bookmarklet = '<a href="javascript:location.href=\'' . $url . 'bookmarks/add?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&description=\'+encodeURIComponent(document.getSelection())">' . $img . '</a>';

// Alternative pour le lien
$img = '<i class="fa fa-hand-o-up"></i></i> &nbsp; ' . elgg_echo('theme_inria:bookmarklet:button:title');
$bookmarklet = '<a href="javascript:location.href=\'' . $url . 'bookmarks/add/' . $guid . '?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&place=yes&description=\'+encodeURIComponent(document.getSelection())" class="bookmarklet-button">' . $img . '</a>';



echo '<p><i class="fa fa-info-circle"></i>' . elgg_echo("theme_inria:bookmarklet:description:intro") . '</p>';
echo '<p>' . elgg_echo("theme_inria:bookmarklet:description") . '</p>';
echo '<p>' . elgg_echo("bookmarks:bookmarklet:description:conclusion") . '</p>';
//echo '<p>' . elgg_echo("bookmarks:bookmarklet:description") . '</p>';
echo '<p>' . $bookmarklet . '</p>';
//echo '<p>' . elgg_echo("bookmarks:bookmarklet:descriptionie") . '</p>';

