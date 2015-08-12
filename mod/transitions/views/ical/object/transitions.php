<?php
// ICAL version of some transitions objects using dates
$entity = elgg_extract('entity', $vars);

// the iCal date format. Note the Z on the end indicates a UTC timestamp.
//define('DATE_ICAL', 'Ymd\THis\Z');

$lang = get_language();
$prodid = '//Transitions²//NONSGML Elgg ' . get_version(true) . '//' . strtoupper($lang);

?>
BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-<?php echo $prodid; ?>

<?php echo elgg_view('transitions/transitions_event', array('entity' => $entity)); ?>

END:VCALENDAR

