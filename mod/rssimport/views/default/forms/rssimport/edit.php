<?php

$rssimport = $vars['entity'];

// create the link to toggle form
echo "<h4 class=\"rssimport_center\"><a href=\"javascript:void(0);\" class=\"rssimport-formtoggle\">";
echo $rssimport ? elgg_echo('rssimport:edit:settings') : elgg_echo('rssimport:create:new');
echo "</a></h4><br>";


//create the div for the form, hidden if we're viewing a feed, visible if we're adding a new feed
$class = $rssimport ? 'hidden' : '';
echo '<div id="createrssimportform" class="' . $class . '">';


// set up the title
echo '<label for="feedName">' . elgg_echo('rssimport:name') . "</label>";
echo elgg_view('input/text', array(
     'name' => 'feedtitle',
     'id' => 'feedName',
     'value' => elgg_get_sticky_value('rssimport', 'feedtitle', $rssimport->title)
     ));
  
echo "<br><br>";


// set up the feed url
echo '<label for="feedurl">' . elgg_echo('rssimport:url') . "</label>";
echo elgg_view('input/text', array(
    'name' => 'feedurl',
    'id' => 'feedurl',
    'value' => elgg_get_sticky_value('rssimport', 'feedurl', $rssimport->description)
    ));

echo "<br><br>";


// dropdown for cron import - if no cron allowed make it a hidden input with value 'never'

// default options
$view = 'input/dropdown';
$view_suffix = "<br><br>";
$options = array(
    'name' => 'cron',
    'id' => 'feedcron',
    'value' => elgg_get_sticky_value('rssimport', 'cron', $rssimport->cron),
    'options_values' => array('never' => elgg_echo('rssimport:cron:never'))
);
  
// add in various times, as set by the plugin settings
$cron_times = array('hourly', 'daily', 'weekly');

foreach ($cron_times as $time) {
  $cron_allowed = elgg_get_plugin_setting('cron_' . $time, 'rssimport');
    
  if ($cron_allowed == 'yes') {
    $options['options_values'][$time] = elgg_echo('rssimport:cron:'.$time);
  }
}
  
// no cron schedules allowed, force hidden input
if (count($options['options_values']) <= 1) {
  $view = 'input/hidden';
  $options['value'] = 'never';
  unset($options['options_values']);
  $view_suffix = '';
}
else {
  echo '<label for="feedcron">' . elgg_echo('rssimport:cron:description') . "</label> ";
}

echo elgg_view($view, $options) . $view_suffix;


// default access
// hacky bit specifically for AU - to force default access to group
$container_guid = get_input('container_guid');
$container = get_entity($container_guid);

if (elgg_instanceof($container, 'group')) {
  $context = elgg_get_context();
  elgg_set_context('group');
  $page_owner_guid = elgg_get_page_owner_guid();
  elgg_set_page_owner_guid($container_guid);
}

echo '<label for="defaultaccess">' . elgg_echo('rssimport:defaultaccess:description') . "</label> ";
echo elgg_view('input/access', array(
    'name' => 'defaultaccess',
    'value' => elgg_get_sticky_value('rssimport', 'defaultaccess', $rssimport->defaultaccess)
    ));
echo "<br><br>";

if (elgg_instanceof($container, 'group')) {
  elgg_set_context($context);
  elgg_set_page_owner_guid($page_owner_guid);
}

// default tags textbox
echo '<label for="defaulttags">' . elgg_echo('rssimport:defaulttags') . "</label>";
echo elgg_view('input/text', array(
    'name' => 'defaulttags',
    'id' => 'defaulttags',
    'value' => elgg_get_sticky_value('rssimport', 'defaulttags', $rssimport->defaulttags)
    ));

echo "<br><br>";


// copyright checkbox
echo elgg_view('output/longtext', array(
	'value' => elgg_echo('rssimport:copyright:warning'),
	'class' => 'elgg-subtext rssimport_copyright_warning'
));

$options = array(
    'name' => 'copyright',
    'value' => 1
);

if (elgg_get_sticky_value('rssimport', 'copyright', $rssimport->copyright)) {
  $options['checked'] = 'checked';
}

echo elgg_view('input/checkbox', $options);

echo elgg_echo('rssimport:copyright');
echo "<br><br>";


// hidden input for import_into - the type of content to import into
echo elgg_view('input/hidden', array(
    'name' => 'import_into',
    'value' => elgg_get_sticky_value('rssimport', 'import_into', $vars['import_into'])
    ));

// hidden input for container_guid
echo elgg_view('input/hidden', array(
    'name' => 'container_guid',
    'value' => elgg_get_sticky_value('rssimport', 'container_guid', $vars['container_guid'])
));

// are we updating something?
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $rssimport->guid));


//submit button
echo elgg_view('input/submit', array(
    'value' => $rssimport ? elgg_echo('rssimport:update') : elgg_echo('rssimport:create')
    ));

echo elgg_view('input/button', array(
    'value' => elgg_echo('rssimport:cancel'),
    'class' => 'rssimport-formtoggle',
    ));

echo "</div>";