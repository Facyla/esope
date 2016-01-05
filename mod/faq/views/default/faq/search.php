<?php

elgg_require_js('faq/search');
elgg_require_js('faq/faq_entity');

$minimum_tag_length = elgg_get_plugin_setting("minimumSearchTagSize","faq");
if(!$minimum_tag_length) {
	$minimum_tag_length = 3;
}
$minimum_hit_count = elgg_get_plugin_setting("minimumHitCount","faq");
if(!$minimum_hit_count) {
	$minimum_hit_count = 1;
}

echo "<div class='mbm'><h3>" . elgg_echo("faq:search:title") . "</h3></div>";

echo "<div class='mbm' id='search'>";
$body = "<label>" . elgg_echo("faq:search:label") . "</label><br>";
$body .= elgg_view('input/text', array('name' => 'search')) . "<br>";
$body .= elgg_view("output/longtext", array("value" => elgg_echo("faq:search:description", array($minimum_tag_length, $minimum_hit_count)), 'class' => 'elgg-subtext'));
$body .= elgg_view('input/submit', array('value' => elgg_echo("search"), 'class' => 'mts elgg-button elgg-button-submit'));
echo elgg_view('input/form', array("id" => "searchForm", "action" => "", 'body' => $body));
echo "</div>";

echo "<div id='result' style='display:none;'></div>";
echo "<div id='waiting' style='display:none;'>";
echo "<img src='" . elgg_get_site_url() . "_graphics/ajax_loader.gif" . "'/>";
echo "</div>";
