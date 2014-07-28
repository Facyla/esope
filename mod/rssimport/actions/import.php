<?php

// get our form inputs
$feedid = get_input('feedid');
$rssimport = get_entity($feedid);
$itemidstring = get_input('rssimportImport');
$items = explode(',', $itemidstring);


//sanity checking
if (!($rssimport instanceof ElggObject)) {
	register_error(elgg_echo('rssimport:invalid:id'));
	forward(REFERRER);
}

if (empty($itemidstring)) {
	register_error(elgg_echo('rssimport:none:selected'));
	forward(REFERRER);	
}

if (!rssimport_content_importable($rssimport)) {
  register_error(elgg_echo('rssimport:invalid:content:type', array(elgg_echo($rssimport->import_into))));
  forward(REFERRER);
}

// get our feed
$feed = rssimport_simplepie_feed($rssimport->description);

$history = array();
$context = elgg_get_context();
elgg_set_context('rssimport_cron');
//iterate through and import anything with a matching ID
foreach ($feed->get_items() as $item) {
	if (in_array($item->get_id(true), $items)) {
		if (!rssimport_check_for_duplicates($item, $rssimport)) {
      // not a duplicate, selected for import - let's do it
			$history[] = rssimport_import_item($item, $rssimport);
		}
	}
}

elgg_set_context($context);
rssimport_add_to_history($history, $rssimport);

system_message(elgg_echo('rssimport:imported'));
forward(REFERRER);