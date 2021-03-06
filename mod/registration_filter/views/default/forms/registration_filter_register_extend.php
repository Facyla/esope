<?php

// Skip if registration form extend is disabled
$extend_registration_form = elgg_get_plugin_setting('extend_registration_form', 'registration_filter', 'yes');
if ($extend_registration_form != 'yes') { return; }

// Skip if not whitelist mode (never display blacklist to registering users!)
$whitelist_enable = elgg_get_plugin_setting('whitelist_enable', 'registration_filter');
if ($whitelist_enable != 'yes') { return; }

// Get and prepare valid domain config array from plugin settings
$whitelist = elgg_get_plugin_setting('whitelist', 'registration_filter');
// Add csv support - cut also on ";" and ","
$whitelist = str_replace(array(' ', '<p>', '</p>'), '', $whitelist); // Clean list - delete all white spaces
$whitelist = preg_replace('/\r\n|\r/', ", ", $whitelist);
$whitelist = str_replace(array(';'), ", ", $whitelist);
$whitelist_intro = substr($whitelist, 0, 185);
$whitelist_end = substr($whitelist, 185);
if (!empty($whitelist_end)) {
	$whitelist_end = '<a href="javascript:void(0);" onclick="$(\'#registration-filter-whitelist\').toggle(); this.innerHTML=\'\';">.. ' . elgg_echo('readmore') . '</a>';
	$whitelist_end .= '<span id="registration-filter-whitelist" style="display:none;">' . substr($whitelist, 185) . '</span>';
}

?>
<div id="registration-filter-notice">
	<i class="fa fa-info-circle"></i> <?php echo elgg_echo('registration_filter:register:whitelist') . $whitelist_intro; ?>
	<?php echo $whitelist_end; ?>
</div>
<hr class="registration-filter-strongseparator" />

