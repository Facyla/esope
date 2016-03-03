<?php
elgg_load_js('elgg.full_calendar');

$events = $vars['events'];

$event_array = array();
$times_supported = elgg_get_plugin_setting('times','event_calendar') != 'no';

// Use new header version ? (should default to no, but be set to yes)
$new_version = get_input('new', true);

foreach($events as $e) {
	$event_item = array(
		'guid' => $e->guid,
		//'title' => '<a href="'.$e->url.'">'.$e->title.'</a>',
		'title' => $e->title,
		'url' => $e->getURL(),
		'start_date' => $e->start_date,
		'end_date' => $e->real_end_time,
	);
	if ($times_supported) {
		$event_item['allDay'] = FALSE;
	} else {
		$event_item['allDay'] = TRUE;
	}

	$event_array[] = $event_item;
}

$json_events_string = json_encode($event_array);

// TODO: is there an easy way to avoid embedding JS?

// Facyla note : nav buttons don't work because only current elements are loaded, 
// so use rather html to navigate with HTML links
?>
<script>

handleEventClick = function(event) {
	if (event.url) {
		window.location.href = event.url;
		return false;
	}
};

handleEventDrop = function(event,dayDelta,minuteDelta,allDay,revertFunc) {

	if (!confirm("Are you sure about this change?")) {
			revertFunc();
	} else {
		elgg.action('event_calendar/modify_full_calendar',
			{
				data: {event_guid: event.guid,dayDelta: dayDelta, minuteDelta: minuteDelta},
				success: function (res) {
					var success = res.success;
					var msg = res.message;
					if (!success) {
						elgg.register_error(msg,2000);
						revertFunc()
					}
				}
			}
		);
	}
};

$(document).ready(function() {
	var events = <?php echo $json_events_string; ?>;
	var cal_events = [];
	for (var i = 0; i < events.length; i++) {
		cal_events.push({
			guid: events[i].guid,
			title : events[i].title,
			url: events[i].url,
			start : new Date(1000*events[i].start_date),
			end : new Date(1000*events[i].end_date),
			allDay: events[i].allDay
		});
	}
	
	$('#calendar').fullCalendar({
		header: {
		<?php
		// We don't want header : not usable, but need to keep some sort of backward compat meanwhile
		if ($new_version) { ?>
			left:'',
			center:'',
			right:'',
		<?php } else { ?>
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay',
		<?php } ?>
		},
		editable: true,
		slotMinutes: 15,
		eventDrop: handleEventDrop,
		eventClick: handleEventClick,
		events: cal_events,
		
		// Additions for some additional settings & translations
		firstDay: 1,
		// time formats
		titleFormat: {
			month: '<?php echo elgg_echo('event_calendar:title:format:month'); ?>',
			week: "<?php echo elgg_echo('event_calendar:title:format:week'); ?>",
			day: '<?php echo elgg_echo('event_calendar:title:format:day'); ?>'
		},
		columnFormat: {
			month: '<?php echo elgg_echo('event_calendar:column:format:month'); ?>',
			week: '<?php echo elgg_echo('event_calendar:column:format:week'); ?>',
			day: '<?php echo elgg_echo('event_calendar:column:format:day'); ?>'
		},
		timeFormat: { // for event elements
			'': '<?php echo elgg_echo('event_calendar:time:format'); ?>' // default
		},
		// locale
		monthNames: ['<?php echo elgg_echo('event_calendar:month:january'); ?>','<?php echo elgg_echo('event_calendar:month:february'); ?>','<?php echo elgg_echo('event_calendar:month:march'); ?>','<?php echo elgg_echo('event_calendar:month:april'); ?>','<?php echo elgg_echo('event_calendar:month:may'); ?>','<?php echo elgg_echo('event_calendar:month:june'); ?>','<?php echo elgg_echo('event_calendar:month:july'); ?>','<?php echo elgg_echo('event_calendar:month:august'); ?>','<?php echo elgg_echo('event_calendar:month:september'); ?>','<?php echo elgg_echo('event_calendar:month:october'); ?>','<?php echo elgg_echo('event_calendar:month:november'); ?>','<?php echo elgg_echo('event_calendar:month:december'); ?>'],
		monthNamesShort: ['<?php echo elgg_echo('event_calendar:month:short:january'); ?>','<?php echo elgg_echo('event_calendar:month:short:february'); ?>','<?php echo elgg_echo('event_calendar:month:short:march'); ?>','<?php echo elgg_echo('event_calendar:month:short:april'); ?>','<?php echo elgg_echo('event_calendar:month:short:may'); ?>','<?php echo elgg_echo('event_calendar:month:short:june'); ?>','<?php echo elgg_echo('event_calendar:month:short:july'); ?>','<?php echo elgg_echo('event_calendar:month:short:august'); ?>','<?php echo elgg_echo('event_calendar:month:short:september'); ?>','<?php echo elgg_echo('event_calendar:month:short:october'); ?>','<?php echo elgg_echo('event_calendar:month:short:november'); ?>','<?php echo elgg_echo('event_calendar:month:short:december'); ?>'],	
		dayNames: ['<?php echo elgg_echo('event_calendar:day:sunday'); ?>','<?php echo elgg_echo('event_calendar:day:monday'); ?>','<?php echo elgg_echo('event_calendar:day:tuesday'); ?>','<?php echo elgg_echo('event_calendar:day:wednesday'); ?>','<?php echo elgg_echo('event_calendar:day:thursday'); ?>','<?php echo elgg_echo('event_calendar:day:friday'); ?>','<?php echo elgg_echo('event_calendar:day:saturday'); ?>'],
		dayNamesShort: ['<?php echo elgg_echo('event_calendar:day:short:sunday'); ?>','<?php echo elgg_echo('event_calendar:day:short:monday'); ?>','<?php echo elgg_echo('event_calendar:day:short:tuesday'); ?>','<?php echo elgg_echo('event_calendar:day:short:wednesday'); ?>','<?php echo elgg_echo('event_calendar:day:short:thursday'); ?>','<?php echo elgg_echo('event_calendar:day:short:friday'); ?>','<?php echo elgg_echo('event_calendar:day:short:saturday'); ?>'],
		buttonText: {
			prev: '&nbsp;&#9668;&nbsp;',
			next: '&nbsp;&#9658;&nbsp;',
			prevYear: '&nbsp;&lt;&lt;&nbsp;',
			nextYear: '&nbsp;&gt;&gt;&nbsp;',
			today: '<?php echo elgg_echo('event_calendar:today'); ?>',
			month: '<?php echo elgg_echo('event_calendar:month'); ?>',
			week: '<?php echo elgg_echo('event_calendar:week'); ?>',
			day: '<?php echo elgg_echo('event_calendar:day'); ?>'
		},

	});
});
</script>

<?php
if ($new_version) {
$prev_link = '&nbsp;&#9668;&nbsp;';
$next_link = '&nbsp;&#9658;&nbsp;';
$today_link = elgg_echo('event_calendar:today');
$month_link = elgg_echo('event_calendar:month');
$week_link = elgg_echo('event_calendar:week');
$day_link = elgg_echo('event_calendar:day');
$displayed_date = date('m Y'); // 'Mars 2014';
echo '
<table class="fc-header" style="width:100%">
	<tbody>
		<tr>
			<td class="fc-header-left">
				<span class="fc-button fc-button-prev fc-state-default fc-corner-left">
					<span class="fc-button-inner">
						<span class="fc-button-content">' . $prev_link . '</span>
						<span class="fc-button-effect"><span></span></span>
					</span>
				</span>
				<span class="fc-button fc-button-next fc-state-default fc-corner-right">
					<span class="fc-button-inner">
						<span class="fc-button-content">' . $next_link . '</span>
						<span class="fc-button-effect"><span></span></span>
					</span>
				</span>
				<span class="fc-header-space"></span>
				<span class="fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right fc-state-disabled">
					<span class="fc-button-inner">
						<span class="fc-button-content">' . $today_link . '</span>
						<span class="fc-button-effect"><span></span></span>
					</span>
				</span>
			</td>
			<td class="fc-header-center">
				<span class="fc-header-title"><h2>' . $displayed_date . '</h2></span>
			</td>
			<td class="fc-header-right">
				<span class="fc-button fc-button-month fc-state-default fc-corner-left fc-state-active">
					<span class="fc-button-inner">
						<span class="fc-button-content">' . $month_link . '</span>
						<span class="fc-button-effect"><span></span></span>
					</span>
				</span>
				<span class="fc-button fc-button-agendaWeek fc-state-default">
					<span class="fc-button-inner">
						<span class="fc-button-content">' . $week_link . '</span>
						<span class="fc-button-effect"><span></span></span>
					</span>
				</span>
				<span class="fc-button fc-button-agendaDay fc-state-default fc-corner-right">
					<span class="fc-button-inner">
						<span class="fc-button-content">' . $day_link . '</span>
						<span class="fc-button-effect"><span></span></span>
					</span>
				</span>
			</td>
		</tr>
	</tbody>
</table>
';
}
?>

<div id='calendar'>
</div>

