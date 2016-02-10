<?php

$options = array(
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    )
);

$options['name'] = 'params[adminonly]';
$options['value'] = $vars['entity']->adminonly ? $vars['entity']->adminonly : 'no';
echo elgg_view('input/select', $options) . ' ' . elgg_echo('rssimport:setting:adminonly') . '<br><br>';

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


// Import tools : enable or disable import for specific tools (besides plugin active)
echo "<strong>" . elgg_echo('rssimport:grouptools') . "</strong><br />";

$options['name'] = 'params[blog_enable]';
$options['value'] = $vars['entity']->blog_enable ? $vars['entity']->blog_enable : 'yes';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:enableblog') . "<br />";

$options['name'] = 'params[bookmarks_enable]';
$options['value'] = $vars['entity']->bookmarks_enable ? $vars['entity']->bookmarks_enable : 'yes';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:enablebookmarks') . "<br />";

$options['name'] = 'params[pages_enable]';
$options['value'] = $vars['entity']->pages_enable ? $vars['entity']->pages_enable : 'yes';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:enablepages') . "<br />";

echo '<div class="pvm">';
$options['name'] = 'params[add_river]';
$options['value'] = $vars['entity']->add_river ? $vars['entity']->add_river : 'no';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:setting:add_river') . '<br />';
echo '</div>';

echo '<div class="pvm">';
$options['name'] = 'params[notify]';
$options['value'] = $vars['entity']->notify ? $vars['entity']->notify : 'no';
echo elgg_view('input/dropdown', $options) . " " . elgg_echo('rssimport:setting:notify') . '<br />';
echo '</div>';

echo "<br /><br />";

