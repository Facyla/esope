<?php 
$event = $vars['entity'];
if ($event->organizer) {
	$organizer = "\nORGANIZER;CN={$event->organizer}\n";
} else {
	$organizer = '';
}

if ($event->description) {
	// make sure that we are using Unix line endings
	$description = str_replace("\r\n","\n",$event->description);
	$description = str_replace("\r","\n",$description);
	
	// now convert to icalendar format
	$description = str_replace("\n",'\n',$description);
	$description = wordwrap($description,75,"\r\n ",TRUE);
} else {
	$description = '';
}
// Timezone info
$tzid = ";TZID=" . date('e');

?>
BEGIN:VEVENT
UID:<?php echo elgg_get_site_url().'event_calendar/view/'.$event->guid; ?>

URL:<?php echo elgg_get_site_url().'event_calendar/view/'.$event->guid; ?>

DTSTAMP<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $event->time_updated)?>

CREATED<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $event->time_created)?>

LAST-MODIFIED<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $event->time_updated)  ?>

DTSTART;VALUE=DATE-TIME<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $event->start_date);  ?>

DTEND;VALUE=DATE-TIME<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $event->real_end_time);  ?>

SUMMARY:<?php echo $event->title;  ?>

DESCRIPTION:<?php echo $description;  ?>

LOCATION:<?php echo $event->venue;  ?><?php echo $organizer;  ?>

CATEGORIES:<?php if ($event->tags) echo implode(",",$event->tags);  ?>

END:VEVENT
