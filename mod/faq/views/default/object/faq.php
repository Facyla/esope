<?php

elgg_require_js('faq/faq_entity');

$faq = $vars["entity"];
$selected = $vars["selected"];
$hitcount = $vars["hitcount"];

echo "<div>";
echo "<table><tr>";

if (elgg_is_admin_logged_in()) {
	echo "<td><div id='faqSelect" . $faq->guid . "' class='faqSelect'>";
	echo elgg_view('input/checkbox', array("name" => "selectQuestion", "id" => "selectQuestion" . $faq->guid, "value" => $faq->guid));
	echo "</div></td>";
}

echo "<td width='100%'>";
if (!empty($hitcount)) {
	echo "<a href='" . elgg_get_site_url() . "faq/list?categoryId=" . elgg_get_metastring_id($faq->category) . "'>" . $faq->category . "</a>&nbsp;>&nbsp;";
}
echo "<a href='javascript:void(0);' class='qID' id='qID" . $faq->guid . "' data-faqguid='" . $faq->guid . "'>" . $faq->question . "</a>";
echo "</td>";

if (!empty($hitcount)) {
	echo "<td class='hitcount'>" . elgg_echo("faq:search:hitcount") . " " . $hitcount . "</td>";
}

if (elgg_is_admin_logged_in()) {
	echo "<td>";
	echo "<div class='faqedit' data-faqguid='" . $faq->guid . "'>" . elgg_view_icon('faqedit') . "</div>";
	echo "</td>";

	echo "<td>";
	echo "<div class='delForm' data-faqguid='" . $faq->guid . "'>" . elgg_view_icon('delete') . "</div>";
	echo "</td>";
}

echo "</tr></table>";

echo "<div id='aID" . $faq->guid . "' class='answer'>";
echo elgg_view('output/longtext', array('value' => $faq->answer));
echo "</div></div>";
