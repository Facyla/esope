<?php

$plugin = elgg_extract("entity", $vars);

$admin_notify_options = array(
	"none" => elgg_echo("uservalidationbyadmin:settings:admin_notify:none"),
	"direct" => elgg_echo("uservalidationbyadmin:settings:admin_notify:direct"),
	"daily" => elgg_echo("uservalidationbyadmin:settings:admin_notify:daily"),
	"weekly" => elgg_echo("uservalidationbyadmin:settings:admin_notify:weekly")
);

echo "<div>";
echo elgg_echo("uservalidationbyadmin:settings:admin_notify");
echo elgg_view("input/dropdown", array("name" => "params[admin_notify]", "value" => $plugin->admin_notify, "options_values" => $admin_notify_options, "class" => "mls"));
echo "</div>";
