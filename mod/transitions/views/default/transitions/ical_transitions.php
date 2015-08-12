<?php
// ICAL version of some transitions objects using dates
$entities = elgg_extract('entities', $vars);

// the iCal date format. Note the Z on the end indicates a UTC timestamp.
//define('DATE_ICAL', 'Ymd\THis\Z');

$lang = get_language();
$prodid = '//Transitions²//NONSGML Elgg ' . get_version(true) . '//' . strtoupper($lang);

?>
BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-<?php echo $prodid; ?>

<?php
foreach ($entities as $ent) {
	echo elgg_view('transitions/ical_transitions_event', array('entity' => $ent));
}
?>

END:VCALENDAR

