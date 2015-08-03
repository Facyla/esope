<?php
/**
 * Bookmarklet
 *
 * @package Bookmarks
 */


$url = elgg_get_site_url();
$img = elgg_view('output/img', array(
	'src' => 'mod/bookmarks/graphics/bookmarklet.gif',
	'alt' => $title,
));
$bookmarklet = "<a href=\"javascript:location.href='{$url}transitions/add?url='"
	. "+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)+'&description='+encodeURIComponent(document.getSelection())\">"
	. $img . "</a>";

?>
<p><?php echo elgg_echo("transitions:bookmarklet:description"); ?></p>
<p><?php echo $bookmarklet; ?></p>
<p><?php echo elgg_echo("transitions:bookmarklet:descriptionie"); ?></p>
<p><?php echo elgg_echo("transitions:bookmarklet:description:conclusion"); ?></p>

