<?php

$event = elgg_extract("entity", $vars);
if (!$event) {
	return;
}

$link = elgg_view('output/url', [
	'class' => 'elgg-button elgg-button-action',
	'href' => $event->getURL(),
	'text' => elgg_view_icon("calendar", "float mrs") . elgg_echo("event_manager:event:menu:title:add_to_calendar")
]);

$location = $event->location;
if (empty($location)) {
	$location = $event->venue;
}

$start = date('d/m/Y', $event->start_day) . " " . date('H', $event->start_time) . ":" . date('i', $event->start_time) . ":00";

if ($event->end_ts) {
	$end = date('d/m/Y H:i:00', $event->end_ts);
} else {
	$end_ts = mktime(date('H', $event->start_time), date('i', $event->start_time), 0,date('m', $event->start_day), date('d', $event->start_day), date('Y', $event->start_day));
	$end_ts = $end_ts + 3600;
	$end = date('d/m/Y H:i:00', $end_ts);
}

$title = $event->title;
$description = elgg_get_excerpt($event->description, 500);
$organizer = $event->organizer;

?>
<span class="addthisevent">
	<?php echo $link; ?>
	<div class='hidden'>
		<span class="start"><?php echo $start; ?></span>
		<span class="end"><?php echo $end; ?></span>
		<span class="title"><?php echo $title; ?></span>
		<span class="description"><?php echo $description; ?></span>
		<span class="location"><?php echo $location; ?></span>
		<span class="organizer"><?php echo $organizer;?></span>
		<span class="date_format">DD/MM/YYYY</span>
	</div>
</span>
