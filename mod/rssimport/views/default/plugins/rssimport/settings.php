<?php

$options = array(
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    )
);

$options['name'] = 'params[adminonly]';
$options['value'] = $vars['entity']->adminonly ? $vars['entity']->adminonly : 'no';
echo elgg_view('input/dropdown', $options) . ' ' . elgg_echo('rssimport:setting:adminonly') . '<br><br>';

echo elgg_echo('rssimport:cron:frequency:explanation') . "<br><br>";

echo "<strong>" . elgg_echo('rssimport:cron:frequency') . "</strong><br>";

$options['name'] = 'params[cron_hourly]';
$options['value'] = $vars['entity']->cron_hourly ? $vars['entity']->cron_hourly : 'no';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:allow:cron:hourly') . "<br>";

$options['name'] = 'params[cron_daily]';
$options['value'] = $vars['entity']->cron_daily ? $vars['entity']->cron_daily : 'no';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:allow:cron:daily') . "<br>";

$options['name'] = 'params[cron_weekly]';
$options['value'] = $vars['entity']->cron_weekly ? $vars['entity']->cron_weekly : 'no';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:allow:cron:weekly') . "<br>";

echo "<br><br>";




/* ESOPE improvements */

// Tools access : based on contextual rights : user > groupadmin > admin
/*
$roles_opt = array('user' => elgg_echo('rssimport:role:user'), 'groupadmin' => elgg_echo('rssimport:role:groupadmin'), 'admin' => elgg_echo('rssimport:role:admin'));
if (!isset($vars['entity']->import_role)) $vars['entity']->import_role = 'groupadmin';
echo "<strong>" . elgg_echo('rssimport:roles') . "</strong><br />" . elgg_echo('rssimport:roles:explanation');
echo elgg_view('input/pulldown', array('name' => 'params[import_role]', 'value' => $vars['entity']->import_role, 'options_values' => $roles_opt)) . "<br /><br />";
*/


// Imported elements ownership
$ownership_opt = array('container' => elgg_echo('rssimport:ownership:container'), 'owner' => elgg_echo('rssimport:ownership:owner'));
if (!isset($vars['entity']->ownership)) $vars['entity']->ownership = 'container';
echo "<strong>" . elgg_echo('rssimport:ownership') . "</strong><br />" . elgg_echo('rssimport:ownership:explanation');
echo elgg_view('input/pulldown', array('name' => 'params[ownership]', 'value' => $vars['entity']->ownership, 'options_values' => $ownership_opt)) . "<br /><br />";


// Import tools : enable or disable import for specific tools (besides plugin active)
echo "<strong>" . elgg_echo('rssimport:grouptools') . "</strong><br />";
if (!isset($vars['entity']->blog_enable)) $vars['entity']->blog_enable = 'no';
if (!isset($vars['entity']->bookmarks_enable)) $vars['entity']->bookmarks_enable = 'yes';
if (!isset($vars['entity']->pages_enable)) $vars['entity']->pages_enable = 'no';

$options['name'] = 'params[blog_enable]';
$options['value'] = $vars['entity']->blog_enable;
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:enableblog') . "<br />";

$options['name'] = 'params[bookmarks_enable]';
$options['value'] = $vars['entity']->bookmarks_enable;
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:enablebookmarks') . "<br />";

$options['name'] = 'params[pages_enable]';
$options['value'] = $vars['entity']->pages_enable;
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:enablepages') . "<br />";

echo "<br /><br />";

