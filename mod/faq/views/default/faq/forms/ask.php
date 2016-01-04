<?php

$user = elgg_get_logged_in_user_entity();

echo "<div class='mbm'><h3>" . elgg_echo("faq:ask:title") . "</h3></div>";

echo "<div>";
$formBody = "<label>" . elgg_echo("faq:ask:label") . "</label><br>";
$formBody .= elgg_view("input/text", array("name" => "question")) . "<br>";
$formBody .= elgg_view("output/longtext", array("value" => elgg_echo("faq:ask:description"), 'class' => 'elgg-subtext'));
$formBody .= elgg_view("input/hidden", array("name" => "userGuid", "value" => $user->guid));
$formBody .= elgg_view("input/submit", array("name" => "submit", "value" => elgg_echo("faq:ask:button"), 'class' => 'mts elgg-button elgg-button-submit'));
echo elgg_view("input/form", array("action" => elgg_get_site_url(). "action/faq/ask", "body" => $formBody));
echo "</div>";
