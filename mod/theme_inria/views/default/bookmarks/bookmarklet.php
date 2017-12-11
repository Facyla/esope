<?php
/**
 * Bookmarklet
 *
 * @package Bookmarks
 */

if (!elgg_is_logged_in()) { return; }

$page_owner = elgg_get_page_owner_entity();
$own = elgg_get_logged_in_user_entity();
if (!elgg_instanceof($page_owner)) {
	$page_owner = $own;
	elgg_set_page_owner_guid($own->guid);
}

if (elgg_instanceof($page_owner, 'group')) {
	$title = elgg_echo("bookmarks:this:group", array($page_owner->name));
} else {
	$title = elgg_echo("bookmarks:this");
}

$guid = $page_owner->getGUID();

/*
if (!$name && ($user = elgg_get_logged_in_user_entity())) {
	$name = $user->username;
}
*/

$url = elgg_get_site_url();
// Note : keep default container so we can send directly to a group, but allow to change in the form

/*
$img = elgg_view('output/img', array(
	'src' => 'mod/bookmarks/graphics/bookmarklet.gif',
	'alt' => $title,
));
// Open in same window
//$bookmarklet = '<a href="javascript:location.href=\'' . $url . 'bookmarks/add/' . $guid . '?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&place=yes&description=\'+encodeURIComponent(document.getSelection())">' . $img . '</a>';
// Open in new window
$bookmarklet = '<a href="javascript:(function(){open(\'' . $url . 'bookmarks/add/' . $guid . '?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&place=yes&description=\'+encodeURIComponent(document.getSelection()),\'BOOKMARK\');})()">' . $img . '</a>';
*/

//$bookmarklet = '<a href="javascript:location.href=\'' . $url . 'bookmarks/add?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&description=\'+encodeURIComponent(document.getSelection())">' . $img . '</a>';

// Alternative pour le lien
$img = '<i class="fa fa-hand-o-up"></i></i>&nbsp;' . elgg_echo('theme_inria:bookmarklet:button:title');
// Open in same window
//$bookmarklet = '<a href="javascript:location.href=\'' . $url . 'bookmarks/add/' . $guid . '?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&place=yes&description=\'+encodeURIComponent(document.getSelection()),\'BOOKMARK\');})()" class="bookmarklet-button">' . $img . '</a>';
// Open in new window
$bookmarklet = '<a href="javascript:(function(){open(\'' . $url . 'bookmarks/add/' . $guid . '?address=\'+encodeURIComponent(location.href)+\'&title=\'+encodeURIComponent(document.title)+\'&place=yes&description=\'+encodeURIComponent(document.getSelection()),\'BOOKMARK\');})()" class="bookmarklet-button">' . $img . '</a>';



echo '<p><i class="fa fa-info-circle"></i>' . elgg_echo("theme_inria:bookmarklet:description:intro") . '</p>';
echo '<p>' . elgg_echo("theme_inria:bookmarklet:description") . '</p>';
echo '<p>' . elgg_echo("bookmarks:bookmarklet:description:conclusion") . '</p>';
//echo '<p>' . elgg_echo("bookmarks:bookmarklet:description") . '</p>';
echo '<p>' . $bookmarklet . '</p>';
//echo '<p>' . elgg_echo("bookmarks:bookmarklet:descriptionie") . '</p>';

