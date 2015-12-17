<?php

$plugin = elgg_extract("entity", $vars);

$admin_notify_options = array(
	"none" => elgg_echo("uservalidationbyadmin:settings:admin_notify:none"),
	"direct" => elgg_echo("uservalidationbyadmin:settings:admin_notify:direct"),
	"daily" => elgg_echo("uservalidationbyadmin:settings:admin_notify:daily"),
	"weekly" => elgg_echo("uservalidationbyadmin:settings:admin_notify:weekly")
);

$yn_options = array(
	"no" => elgg_echo('option:no'),
	"yes" => elgg_echo('option:yes'),
);

echo "<div>";
echo "<label>";
echo elgg_echo("uservalidationbyadmin:settings:admin_notify");
echo elgg_view("input/dropdown", array("name" => "params[admin_notify]", "value" => $plugin->admin_notify, "options_values" => $admin_notify_options, "class" => "mls"));
echo "</label>";
echo "</div>";

// List notified admins + link to their settings
echo '<p>' . elgg_echo('uservalidationbyadmin:admin:listnotified');
$site = elgg_get_site_entity();
$admin_options = array(
	"type" => "user",
	"limit" => false,
	"site_guids" => false,
	"relationship" => "member_of_site",
	"relationship_guid" => $site->getGUID(),
	"inverse_relationship" => true,
	"joins" => array("JOIN " . elgg_get_config("dbprefix") . "users_entity ue ON e.guid = ue.guid"),
	"wheres" => array("ue.admin = 'yes'")
);
$admins = elgg_get_entities_from_relationship($admin_options);
// trigger hook to adjust the admin list
$params = array(
	"admins" => $admins
);
$admins = elgg_trigger_plugin_hook("notify_admin", "uservalidationbyadmin", $params, $admins);
// List the admins
if (!empty($admins)) {
	echo '<ul>';
	foreach ($admins as $admin) {
		echo '<li>' . $admin->name . '&nbsp;: <strong>' . elgg_echo('option:' . $plugin->getUserSetting("notify", $admin->getGUID())) . '</strong> &nbsp; <a href="' . elgg_get_site_url() . 'settings/plugins/' . $admin->username . '/uservalidationbyadmin" target="_blank">' . elgg_echo('uservalidationbyadmin:admin:usersettings') . '</a></li>';
	}
	echo '</ul>';
}
echo '</p>';


// Enable direct email validation link
echo '<p><label>' . elgg_echo('uservalidationbyadmin:settings:emailvalidation') . elgg_view("input/dropdown", array("name" => "params[admin_validation_link]", "value" => $plugin->admin_validation_link, "options_values" => $yn_options, "class" => "mls")) . '</label></p>';


// Add more information to admin notification email
echo '<p><label>' . elgg_echo('uservalidationbyadmin:settings:admin:additionalinfo') . elgg_view("input/dropdown", array("name" => "params[admin_notification_info]", "value" => $plugin->admin_notification_info, "options_values" => $yn_options, "class" => "mls")) . '</label></p>';


// Add more information to user validation email
echo '<p><label>' . elgg_echo('uservalidationbyadmin:settings:user:additionalinfo') . elgg_view("input/dropdown", array("name" => "params[user_notification_info]", "value" => $plugin->user_notification_info, "options_values" => $yn_options, "class" => "mls")) . '</label></p>';



