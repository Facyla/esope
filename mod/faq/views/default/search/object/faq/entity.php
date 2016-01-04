<?php

elgg_require_js('faq/faq_entity');

$faq = $vars["entity"];

echo "<div>";
echo "<table><tr>";

if (elgg_is_admin_logged_in()) {
	echo "<td><div id='faqSelect" . $faq->guid . "' class='faqSelect'>";
	echo elgg_view('input/checkbox', array("name" => "selectQuestion", "id" => "selectQuestion" . $faq->guid, "value" => $faq->guid));
	echo "</div></td>";
}

echo "<td width='100%'>";
echo "<a href='javascript:void(0);' class='qID' id='qID" . $faq->guid . "' data-faqguid='" . $faq->guid . "'>" . $faq->question . "</a>";
echo "</td>";

if (elgg_is_admin_logged_in()) {
	echo "<td>";
	echo "<div class='faqedit' data-faqguid='" . $faq->guid . "'></div>";
	echo "</td>";

	echo "<td>";
	echo "<div class='delForm elgg-icon elgg-icon-delete' data-faqguid='" . $faq->guid . "'></div>";
	echo "</td>";
}

echo "</tr></table>";

echo "<div id='aID" . $faq->guid . "' class='answer'>";
echo elgg_view('output/longtext', array('value' => $faq->answer));
echo "</div></div>";
