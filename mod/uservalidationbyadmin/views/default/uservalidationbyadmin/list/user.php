<?php

$user = elgg_extract("entity", $vars);

// make the different parts of the listing
$checkbox = elgg_view("input/checkbox", array(
	"name" => "user_guids[]",
	"value" => $user->getGUID()
));

$params = array(
	"entity" => $user,
	"title" => $user->name . " (" . $user->email . ")",
	"subtitle" => elgg_view_friendly_time($user->time_created)
);
$params = $params + $vars;
$summary = elgg_view("user/elements/summary", $params);

$actions = "<span>";
$actions .= elgg_view("output/url", array(
	"text" => elgg_echo("uservalidationbyadmin:validate"),
	"href" => "action/uservalidationbyadmin/validate?user_guid=" . $user->getGUID(),
	"confirm" => elgg_echo("uservalidationbyadmin:validate:confirm")
));
$actions .= " | ";
$actions .= elgg_view("output/url", array(
	"text" => elgg_echo("delete"),
	"href" => "action/uservalidationbyadmin/delete?user_guid=" . $user->getGUID(),
	"confirm" => elgg_echo("deleteconfirm")
));
$actions .= "</span>";

echo elgg_view_image_block($checkbox, $summary, array("image_alt" => $actions));
