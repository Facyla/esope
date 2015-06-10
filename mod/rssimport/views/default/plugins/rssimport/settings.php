<?php

// Define options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$options = array('options_values' => $yes_no_opt);
$group_role_opt = array('user' => elgg_echo('rssimport:role:user'), 'groupadmin' => elgg_echo('rssimport:role:groupadmin'), 'admin' => elgg_echo('rssimport:role:admin'));

// Set defaults
if (!isset($vars['entity']->group_role)) $vars['entity']->group_role = 'groupadmin';
if (!isset($vars['entity']->user_role)) $vars['entity']->user_role = 'no';
if (!isset($vars['entity']->ownership)) $vars['entity']->ownership = 'container';
if (!isset($vars['entity']->notifications)) $vars['entity']->notifications = 'yes';

if (!isset($vars['entity']->cron_hourly)) $vars['entity']->cron_hourly = 'no';
if (!isset($vars['entity']->cron_daily)) $vars['entity']->cron_daily = 'no';
if (!isset($vars['entity']->cron_weekly)) $vars['entity']->cron_weekly = 'no';

if (!isset($vars['entity']->blog_enable)) $vars['entity']->blog_enable = 'no';
if (!isset($vars['entity']->bookmarks_enable)) $vars['entity']->bookmarks_enable = 'yes';
if (!isset($vars['entity']->pages_enable)) $vars['entity']->pages_enable = 'no';


// Access to import tools
echo '<fieldset><legend>' . elgg_echo('rssimport:settings:access') . '</legend>';
	
	// Personal import
	echo '<p><label>' . elgg_echo('rssimport:user_role') . ' ' . elgg_view('input/dropdown', array('name' => 'params[user_role]', 'value' => $vars['entity']->user_role, 'options_values' => $yes_no_opt)) . '</label><br />' . elgg_echo('rssimport:user_role:explanation') . '</p>';
	
	// Group import : access based on contextual rights : user | groupadmin | admin
	echo '<p><label>' . elgg_echo('rssimport:group_role') . ' ' . elgg_view('input/dropdown', array('name' => 'params[group_role]', 'value' => $vars['entity']->group_role, 'options_values' => $group_role_opt)) . '</label><br />' . elgg_echo('rssimport:group_role:explanation') . '</p>';
	
	// Imported elements ownership (for groups)
	$ownership_opt = array('container' => elgg_echo('rssimport:ownership:container'), 'owner' => elgg_echo('rssimport:ownership:owner'));
	echo '<p><label>' . elgg_echo('rssimport:ownership') . elgg_view('input/pulldown', array('name' => 'params[ownership]', 'value' => $vars['entity']->ownership, 'options_values' => $ownership_opt)) . '</label><br />' . elgg_echo('rssimport:ownership:explanation') . '</p>';
	
echo '</fieldset>';


// Enabled import tools : allow import for specific tools (also requires active plugin)
echo '<fieldset><legend>' . elgg_echo('rssimport:grouptools') . '</legend>';
	
	echo '<p><label>' . elgg_echo('rssimport:enableblog') . ' ' . elgg_view('input/dropdown', array('name' => 'params[blog_enable]', 'value' => $vars['entity']->blog_enable, 'options_values' => $yes_no_opt)) . '</label></p>';
	
	echo '<p><label>' . elgg_echo('rssimport:enablebookmarks') . ' ' . elgg_view('input/dropdown', array('name' => 'params[bookmarks_enable]', 'value' => $vars['entity']->bookmarks_enable, 'options_values' => $yes_no_opt)) . '</label></p>';
	
	echo '<p><label>' . elgg_echo('rssimport:enablepages') . ' ' . elgg_view('input/dropdown', array('name' => 'params[pages_enable]', 'value' => $vars['entity']->pages_enable, 'options_values' => $yes_no_opt)) . '</label></p>';
	
echo '</fieldset>';


// Cron frequencies
echo '<fieldset><legend>' . elgg_echo('rssimport:cron:frequency') . '</legend>';

	echo '<p>' . elgg_echo('rssimport:cron:frequency:explanation') . '</p>';
	
	echo '<p><label>' . elgg_echo('rssimport:allow:cron:hourly') . ' ' . elgg_view('input/dropdown', array('name' => 'params[cron_hourly]', 'value' => $vars['entity']->cron_hourly, 'options_values' => $yes_no_opt)) . '</label></p>';
	
	echo '<p><label>' . elgg_echo('rssimport:allow:cron:daily') . ' ' . elgg_view('input/dropdown', array('name' => 'params[cron_daily]', 'value' => $vars['entity']->cron_daily, 'options_values' => $yes_no_opt)) . '</label></p>';
	
	echo '<p><label>' . elgg_echo('rssimport:allow:cron:weekly') . ' ' . elgg_view('input/dropdown', array('name' => 'params[cron_weekly]', 'value' => $vars['entity']->cron_weekly, 'options_values' => $yes_no_opt)) . '</label></p>';
	
echo '</fieldset>';


// General settings
//echo '<fieldset><legend>' . elgg_echo('rssimport:settings:general') . '</legend>';
	
	// Email notifications
	echo '<p><label>' . elgg_echo('rssimport:notifications') . ' ' . elgg_view('input/dropdown', array('name' => 'params[notifications]', 'value' => $vars['entity']->notifications, 'options_values' => $yes_no_opt)) . '</label><br />' . elgg_echo('rssimport:notifications:details') . '</p>';
	
//echo '</fieldset>';


