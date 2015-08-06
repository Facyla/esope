<?php

$transitions = elgg_extract('entity', $vars);

if (!elgg_instanceof($transitions, 'object', 'transitions') || !in_array($transitions->category, array('project', 'event'))) { return; }

$description = $transitions->excerpt;
if (empty($description)) {
	$description = elgg_get_excerpt($transitions->description, 137);
}
// Limit to max chars
if (strlen($description) >= 140) { $description = elgg_get_excerpt($description, 137); }
// make sure that we are using Unix line endings
$description = str_replace("\r\n","\n",$description);
$description = str_replace("\r","\n",$description);
// now convert to icalendar format
$description = str_replace("\n",'\n',$description);
$description = wordwrap($description,75,"\r\n ",TRUE);

/* Not available (yet ?)
if ($transitions->organizer) {
	$organizer = "\nORGANIZER;CN={$transitions->organizer}\n";
} else {
	$organizer = '';
}
*/

$geo = $transitions->getLatitude() . ';' . $transitions->getLongitude();

// Timezone info
$tzid = ";TZID=" . date('e');

?>

BEGIN:VEVENT
UID:<?php echo elgg_get_site_url().'transitions/view/'.$transitions->guid; ?>

URL:<?php echo elgg_get_site_url().'transitions/view/'.$transitions->guid; ?>

DTSTAMP<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $transitions->time_updated)?>

CREATED<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $transitions->time_created)?>

LAST-MODIFIED<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $transitions->time_updated) ?>

DTSTART;VALUE=DATE-TIME<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $transitions->start_date); ?>

DTEND;VALUE=DATE-TIME<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $transitions->end_date); ?>

SUMMARY:<?php echo $transitions->title; ?>

DESCRIPTION:<?php echo $description; ?>

LOCATION:<?php echo $transitions->territory; ?>

GEO: <?php echo $geo; ?>

CATEGORIES:<?php if ($transitions->tags) echo implode(",",$transitions->tags); ?>

END:VEVENT
