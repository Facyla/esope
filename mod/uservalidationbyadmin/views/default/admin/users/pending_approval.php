<?php

elgg_require_js('uservalidationbyadmin/admin');

// make sure we can see everything
$hidden = access_get_show_hidden_status();
access_show_hidden_entities(true);

echo "<div class='mbm'>" . elgg_echo("uservalidationbyadmin:pending_approval:description") . "</div>";

$title = elgg_echo("uservalidationbyadmin:pending_approval:title");

$options = uservalidationbyadmin_get_selection_options();
$body = elgg_list_entities($options, "elgg_get_entities_from_relationship", "uservalidationbyadmin_view_users_list");
if (!empty($body)) {
	// we need to add some bulk actions to the title
	$check_all = elgg_view("input/checkbox", array(
		"name" => "check_all",
		"id" => "uservalidationbyadmin-check-all",
		"value" => 1,
		"class" => "mrs"
	));
	
	$bulk_actions = "<span class='float-alt'>";
	$bulk_actions .= elgg_view("output/url", array(
		"text" => elgg_echo("uservalidationbyadmin:validate"),
		"href" => "action/uservalidationbyadmin/bulk_action?do=validate",
		"id" => "uservalidationbyadmin-bulk-validate",
		"confirm" => true
	));
	$bulk_actions .= " | ";
	$bulk_actions .= elgg_view("output/url", array(
		"text" => elgg_echo("delete"),
		"href" => "action/uservalidationbyadmin/bulk_action?do=delete",
		"id" => "uservalidationbyadmin-bulk-delete",
		"confirm" => elgg_echo("deleteconfirm:plural")
	));
	$bulk_actions .= "</span>";
	
	// make new title
	$title = $check_all . $title . $bulk_actions;
} else {
	// no content
	$body = elgg_echo("notfound");
}

echo elgg_view_module("inline", $title, $body, array("id" => "uservalidationbyadmin-wrapper"));

// restore access settings
access_show_hidden_entities($hidden);
