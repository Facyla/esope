<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;

$limit = 0;

$title = elgg_echo('pin:title');
$body = '';


// Highlighted - for everybody
$body .= elgg_view('pin/highlight_nicelisting', array('exclude' => null, 'nolink' => true, 'limit' => 0));
//$body .= elgg_view('pin/highlight_nicelisting', array('exclude' => null));

$body .= '<h3>' . elgg_echo('pin:highlighted:title') . '</h3>';
$ents = elgg_get_entities_from_metadata(array('metadata_name' => 'highlight', 'types' => 'object', 'limit' => $limit));
//$ents = get_entities_from_metadata('highlight', '', 'object', '', 0, 10);
//get_entities_from_annotations ($entity_type="", $entity_subtype="", $name="", $value="", $owner_guid=0, $group_guid=0, $limit=10, $offset=0, $order_by="asc", $count=false, $timelower=0, $timeupper=0);
//$ents = get_entities_from_annotations("object", "", "memorize", "", 0, 0, 10, 0, "asc", false, 0, 0);
$body .= '<ul>';
foreach ($ents as $ent) {
  $linktext = $ent->title;
  if (empty($linktext)) $linktext = $ent->description;
  if (empty($linktext)) $linktext = elgg_echo('item:object:'.$ent->getSubtype());
  $body .= '<li><a href="' . $ent->getURL() . '">' . $linktext . '</a> - <small>' . get_entity($ent->container_guid)->name . '</small></li>';
}
$body .= '</ul>';



// Build page content
$body = elgg_view_title($title) . '<div class="contentWrapper">' . $body . '</div>';
$body = elgg_view_layout('one_column', $body);

// Finally draw the page
page_draw($title, $body);

