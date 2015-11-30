<?php

$rssimport = $vars['entity'];
$blacklisted = $vars['blacklisted'];
$item = $vars['item'];

//simplepie list of allowed tags
$allow_tags = '<a><p><br><b><i><em><del><pre><strong><ul><ol><li><img><hr>';

$class = "";
$checkboxname = "rssmanualimport";
$itemid = $item->get_id(true);

$checkbox_params = array(
	'name' => 'rssmanualimport',
	'default' => false,
	'value' => $itemid,
	'id' => 'checkbox-' . $itemid
);

// different css for blacklisted items
if ($blacklisted) {
	$class = " rssimport_blacklisted";
	$checkbox_params['name'] = "rssmanualimportblacklisted";
	$checkbox_params['disabled'] = "disabled";
}

//wrapper div
echo "<div id=\"rssimport-item-" . $itemid . "\" class=\"rssimport_item" . $class . "\">";
echo "<table><tr><td>";

// 	checkbox here
// 	using hash of the id, because the id is a URL and could potentially contain commas which will screw up our array
echo elgg_view('input/checkbox', $checkbox_params);

echo "</td><td>";


//item title
echo "<div class=\"rssimport_title\">";
echo "<h4><a href=\"" . $item->get_permalink() . "\">" . $item->get_title() . "</a></h4>";
echo "</div>";

//if content is long (more than 800 characters) create a short excerpt to show so page isn't really long
$content = strip_tags($item->get_content(), $allow_tags);
$use_excerpt = false;
if (strlen($content) > 800) {
	$excerpt = elgg_get_excerpt($content, 800);
	$excerpt .= "<br>" . elgg_view('output/url', array('text' => elgg_echo('rssimport:more'), 'class' => 'rssimport-excerpt-toggle', 'data-id' => $itemid)) . "<br><br>"; //"<br> (<a href=\"javascript:rssimportToggleExcerpt('$itemid');\">" . elgg_echo('rssimport:more') . "</a>)<br><br>";
	$content .= "<br>" . elgg_view('output/url', array('text' => elgg_echo('rssimport:less'), 'class' => 'rssimport-excerpt-toggle', 'data-id' => $itemid)) . "<br><br>"; //"<br> (<a href=\"javascript:rssimportToggleExcerpt('$itemid');\">" . elgg_echo('rssimport:less') . "</a>)<br><br>";
	$use_excerpt = true;
}

// description excerpt
echo "<div class=\"rssimport_excerpt\" id=\"rssimport_excerpt" . $itemid . "\">";
if ($use_excerpt) {
	echo $excerpt;
} else {
	echo $content;
}

echo "</div>";

echo "<div class=\"hidden\" id=\"rssimport_content" . $itemid . "\">";
echo $content;
echo "</div>";

// date of posting	
echo "<div class=\"rssimport_date\">";
echo elgg_echo('rssimport:postedon');
echo $item->get_date(elgg_echo('rssimport:date:format'));
echo "</div>";

echo "<div class=\"tags\">";

$count = 0;
$tags = '';
if (is_array($item->get_categories())) {
	foreach ($item->get_categories() as $category) {
		if ($count == 0) {
			$prefix = "";
		} else {
			$prefix = ", ";
		}
		$tags .= $category->get_label() . ", ";
	}
}

if ($tags) {
	echo elgg_echo('rssimport:tags') . ": " . $tags;
}

echo "</div>";
echo "</td></tr></table>";

//create delete/undelete link
if ($blacklisted) {
	$url = elgg_get_site_url() . "action/rssimport/blacklist?id=" . $itemid . "&feedid=" . $rssimport->guid . "&method=undelete";
	$text = elgg_echo('rssimport:undelete');
} else {
	$url = elgg_get_site_url() . "action/rssimport/blacklist?id=" . $itemid . "&feedid=" . $rssimport->guid . "&method=delete";
	$text = elgg_echo('rssimport:delete');
}

echo elgg_view('output/url', array(
	'href' => '#',
	'text' => $text,
	'id' => 'rssimport-disable-' . $itemid,
	'class' => 'rssimport-disable',
	'data-item' => $itemid,
	'data-guid' => $rssimport->guid
));

echo elgg_view('graphics/ajax_loader');

//end of wrapper div
echo "</div>";
