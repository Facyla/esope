<?php
	
$plugin = elgg_extract("entity", $vars);
$user = elgg_get_page_owner_entity();

if ($user->isAdmin() && $user->canEdit()) {
	$yesno_options = array(
		"yes" => elgg_echo("option:yes"),
		"no" => elgg_echo("option:no")
	);
	
	echo "<div class='mbm'>";
	echo elgg_echo("uservalidationbyadmin:usersettings:notify");
	echo elgg_view("input/dropdown", array("name" => "params[notify]", "options_values" => $yesno_options, "value" => $plugin->getUserSetting("notify", $user->getGUID()), "class" => "mls"));
	echo "</div>";
	
} else {
	echo elgg_view("output/longtext", array("value" => elgg_echo("uservalidationbyadmin:usersettings:nonadmin"), "class" => "mbm"));
}
