<?php

// get our form inputs
$feedid = get_input('feedid');
$rssimport = get_entity($feedid);
$itemidstring = get_input('id');
$method = get_input('method');
$items = explode(',', $itemidstring);

if ($method == "delete") {
  rssimport_add_to_blacklist($items, $rssimport);
  system_message(elgg_echo('rssimport:blacklisted'));
  forward(REFERRER);
}

if ($method == "undelete") {
  rssimport_remove_from_blacklist($items, $rssimport);
  system_message(elgg_echo('rssimport:unblacklisted'));
  forward(REFERRER);
}

forward(REFERRER);