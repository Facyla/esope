<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/vendors/iCalcreator.class.php' );	// iCal class library

// Generic parameters

/* Get the plugin settings */
// Titre par défaut peut être défini via le fichier de langues
$title = elgg_get_plugin_setting('calendartitle', 'ical_viewer');
if (empty($title)) $title = elgg_echo('ical_viewer:title');

// Main calendar URL
$calendar = get_input('ical', false);
if (!$calendar) { $calendar = elgg_get_plugin_setting('defaulturl', 'ical_viewer'); }
if (empty($calendar)) {
	$calendar = 'http://www.google.com/calendar/ical/e_2_en%23weeknum%40group.v.calendar.google.com/public/basic.ics';
}

/*
// How many events should be displayed
$num_items = elgg_get_plugin_setting('num_items', 'ical_viewer');

// Timeframe for valid events
$timeframe_before = elgg_get_plugin_setting('timeframe_before', 'ical_viewer');
if (!isset($timeframe_before)) { $timeframe_before = 7; }
$timeframe_after = elgg_get_plugin_setting('timeframe_after', 'ical_viewer');
if (!isset($timeframe_after)) { $timeframe_after = 366; }
*/



$vcalendar = new vcalendar();	// create a new calendar instance
$vcalendar->setConfig( 'unique_id', $SERVER['SERVER_NAME']);	// set Your unique id, required if any component UID is missing

/*
// Properties required of some calendar software :
$vcalendar->setProperty( 'method', 'PUBLISH' );
$vcalendar->setProperty( "x-wr-calname", "Innovation Democratic" );
$vcalendar->setProperty( "X-WR-CALDESC", $title);
$vcalendar->setProperty( "X-WR-TIMEZONE", "Europe/Paris" );
*/

// Set input files
//	$vcalendarcalendar->setConfig( "filename", "file.ics" );	// Local filename
//	$vcalendar->setConfig( 'url', 'http://fing.org/?page=ical' );	// Remote files
$vcalendar->setConfig( 'url', $calendar );	// Remote file

$vcalendar->parse();
$vcalendar->sort();	// ensure start date order

/*
parse example 1
$vcalendar = new vcalendar();
$vcalendar->setConfig( "unique_id", "domain.com" );
$vcalendar->setConfig( "filename", "file.ics" );
$vcalendar->parse();

parse example 2
$vcalendar = new vcalendar();
$vcalendar->setConfig( "unique_id", "domain.com" );
$vcalendar->setConfig("url", "http://www.ical.net/calendars/calendar.ics");
$vcalendar->parse();

merge example
$vcalendar = new vcalendar();
$vcalendar->setConfig( "unique_id", "domain.com" );
$vcalendar->setConfig( "directory", "import" );
$vcalendar->setConfig( "filename",	"file1.ics" );
$vcalendar->parse();
$vcalendar->setConfig( "filename",	"file2.ics" );
$vcalendar->parse();
$vcalendar->sort();
$vcalendar->setConfig( "directory", "export" );
$vcalendar->setConfig( "filename",	"icalmerge.ics" );
$vcalendar->saveCalendar(); 


Format de selectComponents :
selectComponents ([int startYear, int startMonth, int startDay [, int endYear, int endMonth, int endDay [, mixed cType [, bool flat [, bool any [, bool split]]]]]])
Paramètres :
startYear : start year of date period (4*digit), default current year
startMonth : start month of date period (1-2*digit), def. current month
startDay : start day of date period (1-2*digit), def. current day
endYear : end year of date period (4*digit), def. startYear
endMonth : end month of date period (-2*digit), def. startMonth
endDay : end day of date period (1-2*digit), def. StartDay
cType : calendar component type(-s), default (FALSE) all else string/array type(-s) (vevent, vtodo, vjournal, vfreebusy)
flat : FALSE (default) => output : array[Year][Month][Day][] TRUE => output : array[] (ignores split)
any : TRUE (default) - select component that occurs within period FALSE - only components that starts (DTSTART) within period
split : TRUE - (default) one component copy for every day it occurs within the period (implies flat=FALSE) FALSE - one occurance of component in output array, start date/recurrence date 

Boucle d'affichage :
$events_arr = $vcalendarcalendar->selectComponents( 2007,11,1,2007,11,30,'vevent'); // select events
foreach( $events_arr as $year => $year_arr ) {
foreach( $year_arr as $month => $month_arr ) {
	foreach( $month_arr as $day => $day_arr ) {
		foreach( $day_arr as $event ) {
			$currddate = $event->getProperty( 'x-current-dtstart' );
			// if member of a recurrence set,returns
			// array('x-current-dtstart'
			// , <(string) date("Y-m-d [H:i:s][timezone/UTC offset]")>)
			$startdate = $event->getProperty( 'dtstart' );
			$summary = $event->getProperty( 'summary' );
			$description = $event->getProperty( 'description' )
		}
	}
}
}

*/

// SET : timeframe
$day_ts = 24*3600;
$startyear = date('Y', time()-7*$day_ts);	// current year - 1 week
$startmonth = date('n', time()-7*$day_ts);	// current month - 1 week
$startday = date('j', time()-7*$day_ts);	// current day - 1 week
$endyear = date('Y', time()+366*$day_ts);	// current year + 1 full year
$endmonth = date('n', time()+366*$day_ts);	// current month + 1 full year
$endday = date('j', time()+366*$day_ts);	// current day + 1 full year
$event_type = "vevent";

// Select events
$events_arr = $vcalendar->selectComponents($startyear,$startmonth,$startday,$endyear,$endmonth,$endday,$event_type);

$content = "";
// Generate content
if ($events_arr) foreach( $events_arr as $year => $year_arr ) {
	if ($year_arr) foreach( $year_arr as $month => $month_arr ) {
		if ($month_arr) foreach( $month_arr as $day => $day_arr ) {
			if ($day_arr) foreach( $day_arr as $event ) {
//					$currddate = $event->getProperty('x-current-dtstart');
				// if member of a recurrence set, returns array('x-current-dtstart', <(string) date("Y-m-d [H:i:s][timezone/UTC offset]")>)
				$startdate = $event->getProperty('dtstart');
//					if ($endate = $event->getProperty('dtend')) {} else { $endate = $startdate; }
				$summary = $event->getProperty('summary');
//					$description = $event->getProperty('description');
				
//					$body .= sprintf(elgg_echo('icalcreator:vevent:display'), $startdate, $endate, $summary, $description);
//					$content .= '<p class="vevent">Date de début : ' . $startdate['day'] . " " . $startdate['month'] . "<!--" . $startdate['year'] . $startdate['hour'] . $startdate['min'] . "<br />date de fin : $endate<br />Résumé //--> : $summary<!--<br />Description : $description//--></p><br />";
				
				$month = $startdate['month'];
				$num_months = array('/01/', '/02/', '/03/', '/04/', '/05/', '/06/', '/07/', '/08/', '/09/', '/10/', '/11/', '/12/');
				$fr_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
//					$en_months = array('/January/', '/February/', '/March/', '/April/', '/May/', '/June/', '/July/', '/August/', '/September/', '/October/', '/November/', '/December/');
//					$en_days = array('/Monday/', '/Tuesday/', '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/');
//					$fr_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi','Dimanche');
				$month = preg_replace($num_months, $fr_months, $month);
				
				$summary = parse_urls($summary);
				$content .= '<p class="vevent">' . $startdate['day'] . " " . $month . " : $summary</p><br />\n";
				//$content .= print_r($event, true);
			}
		}
	}
}


// Setup page
$body = elgg_view_layout('one_sidebar', array(
	'filter_context' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => '',
	'class' => 'calendar',
));

// Display page
echo elgg_view_page($title, $body);

