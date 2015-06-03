<?php
/**
* This view displays the Digest header.
*
* Available in $vars
* 	$vars['user'] 		=> the current user for whom we're creating the digest
* 	$vars['group'] 		=> (optional) the current group for whom we're creating the digest
* 	$vars['ts_lower']	=> the lower time limit of the content in this digest
* 	$vars['ts_upper']	=> the upper time limit of the content in this digest
* 	$vars['interval']	=> the interval of the current digest
* 							(as defined in DIGEST_INTERVAL_DAILY, DIGEST_INTERVAL_WEEKLY, DIGEST_INTERVAL_FORTNIGHTLY, DIGEST_INTERVAL_MONTHLY)
*
*/

$group = elgg_extract("group", $vars);
$interval = elgg_extract("interval", $vars);
$site = elgg_get_site_entity();

$logo = elgg_get_plugin_setting('email_logo', 'theme_cocon');
//if (empty($logo)) { $logo = $site->url . 'mod/theme_cocon/graphics/email/logo_cocon.png'; }

echo '<h1 style="text-align:center;">';
if (!empty($logo)) echo '<img src="' . $logo . '" alt="Cocon" align="absbottom" />';
else echo $site->name;
/*
if(!empty($group)){
	echo elgg_echo("digest:message:title:group", array($site->name, $group->name, elgg_echo("digest:interval:" . $interval)));
} else {
	echo elgg_echo("digest:message:title:site", array($site->name, elgg_echo("digest:interval:" . $interval)));
}
*/
echo "</h1>";

