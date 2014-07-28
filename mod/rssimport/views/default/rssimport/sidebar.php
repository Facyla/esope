<?php
/**
 * This view outputs the links in the sidebar of an rss feed
 * 
 * (int) $vars['container_id'] = the guid of the container of the required feeds
 * (string) $vars['import_into'] = the type of content the feeds import into
 */

//get an array of our imports
$options = array(
    'container_guids' => array($vars['container_guid']),
    'metadata_name_value_pairs' => array('name' => 'import_into', 'value' => $vars['import_into']),
);

$rssimports = get_user_rssimports(elgg_get_page_owner_entity(), $options);

// iterate through, creating a link for each import
if ($rssimports) {
  
  // list existing feeds
  echo "<div class=\"rssimport_feedlist\">";
  echo "<h4 class=\"rssimport_center\">" . elgg_echo('rssimport:listing') . "</h4><br>";

  foreach ($rssimports as $rssimport) {
		
      echo "<div class=\"rssimport_listitem clearfix\">";
      echo elgg_view('output/url', array('href' => $rssimport->getURL(), 'class' => 'rssimport_listing', 'text' => $rssimport->title));
      echo elgg_view('output/confirmlink', array(
          'href' => elgg_get_site_url() . "action/rssimport/delete?id=" . $rssimport->guid,
          'class' => 'rssimport_deletelisting',
          'text' => '<span class="elgg-icon elgg-icon-delete"></span>',
          'confirm' => elgg_echo('rssimport:delete:confirm')
      ));
      echo "</div>";
  }
  
  $sidebar .= "</div>";
}


echo $sidebar;