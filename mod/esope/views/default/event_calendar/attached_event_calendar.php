<?php 
$entity = elgg_extract('entity', $vars);

$organizer = '';
if ($entity->organizer) {
	$organizer = "\nORGANIZER;CN={$entity->organizer}\n";
}

if ($entity->description) {
	// make sure that we are using Unix line endings
	$description = str_replace("\r\n","\n",$entity->description);
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
UID:<?php echo elgg_get_site_url().'event_calendar/view/'.$entity->guid; ?>

URL:<?php echo elgg_get_site_url().'event_calendar/view/'.$entity->guid; ?>

DTSTAMP<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $entity->time_updated)?>

CREATED<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $entity->time_created)?>

LAST-MODIFIED<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $entity->time_updated)  ?>

DTSTART;VALUE=DATE-TIME<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $entity->start_date);  ?>

DTEND;VALUE=DATE-TIME<?php echo $tzid; ?>:<?php echo date("Ymd\THis", $entity->real_end_time);  ?>

SUMMARY:<?php echo $entity->title;  ?>

DESCRIPTION:<?php echo $description;  ?>

LOCATION:<?php echo $entity->venue;  ?><?php echo $organizer;  ?>

CATEGORIES:<?php if ($entity->tags) echo implode(",",$entity->tags);  ?>

END:VEVENT
