<?php

namespace AU\RSSImport;

/**
 * This view outputs the links in the sidebar of an rss feed
 * 
 * (int) $vars['container_id'] = the guid of the container of the required feeds
 * (string) $vars['import_into'] = the type of content the feeds import into
 */

//get an array of our imports
//@todo grab them all?  scalability?
$options = array(
	'type' => 'object',
	'subtype' => 'rssimport',
	'owner_guid' => elgg_get_logged_in_user_guid(),
    'container_guids' => array($vars['container_guid']),
    'metadata_name_value_pairs' => array(
		'name' => 'import_into',
		'value' => $vars['import_into']
	),
	'limit' => false
);

$rssimports = elgg_get_entities_from_metadata($options);

// iterate through, creating a link for each import
if ($rssimports) {
  
  // list existing feeds
  echo "<div class=\"rssimport_feedlist\">";
  echo "<h4 class=\"rssimport_center\">" . elgg_echo('rssimport:listing') . "</h4><br>";

  foreach ($rssimports as $rssimport) {
		
      echo "<div class=\"rssimport_listitem clearfix\">";
      echo elgg_view('output/url', array('href' => $rssimport->getURL(), 'class' => 'rssimport_listing', 'text' => $rssimport->title));
      echo elgg_view('output/url', array(
          'href' => elgg_get_site_url() . "action/rssimport/delete?id=" . $rssimport->guid,
          'class' => 'rssimport_deletelisting',
          'text' => '<span class="elgg-icon elgg-icon-delete"></span>',
		  'is_action' => true,
          'confirm' => elgg_echo('rssimport:delete:confirm')
      ));
      echo "</div>";
  }
  
  echo "</div>";
}
