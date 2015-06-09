<?php
require_once(elgg_get_plugins_path() . '/ical_viewer/vendors/iCalcreator.class.php');	// iCal class library

// @TODO : Mise en cache des fichiers iCal, au moins une heure ou une journée

if ($entity = $vars['entity']) {
	// Paramètres passés à cette vue
	$title = $entity['title'];
	$calendar = $entity['calendar_url'];
	$timeframe_before = $entity['timeframe_before'];
	$timeframe_after = $entity['timeframe_after'];
	$num_items = $entity['num_items'];
}
$full = $vars['full'];

/* Paramètres par défaut du plugin */
if (!isset($title)) { $title = "Agenda"; }
if (!isset($calendar)) { $calendar = 'http://www.google.com/calendar/ical/e_2_en%23weeknum%40group.v.calendar.google.com/public/basic.ics'; }
if (!isset($timeframe_before)) { $timeframe_before = 7; }
if (!isset($timeframe_after)) { $timeframe_after = 366; }
if (!isset($num_items)) { $num_items = 3; }
if (!is_int($num_items) || ($num_items < 1)) { $num_items = false; }
$title = '<span style="float:right;"><a href="' . $calendar . '" class="ical" title="Télécharger le fichier ical"><img src="' . $CONFIG->url. 'mod/ical_viewer/graphics/ical16green.png" alt="ical" style="border:0; padding:0: margin:3px 0 3px 3px; background:transparent;"> iCal</a></span>';

// Gestion du décalage horaire en fonction de la timezone définie : O donne le décalage de timezone en heures, Z en secondes..
// On ne garde que la partie qui nous intéresse, sans le +
//	$offset = (int) substr(date("O",time()), 1, 2);

// Intervalle de temps concerné pour affichage
$day_ts = 24*3600;
$startyear = date('Y', time()-$timeframe_before*$day_ts);
$startmonth = date('n', time()-$timeframe_before*$day_ts);
$startday = date('j', time()-$timeframe_before*$day_ts);
$endyear = date('Y', time()+$timeframe_after*$day_ts);
$endmonth = date('n', time()+$timeframe_after*$day_ts);
$endday = date('j', time()+$timeframe_after*$day_ts);
$event_type = "vevent";

$vcalendar = new vcalendar();	// create a new calendar instance
$vcalendar->setConfig( 'unique_id', $SERVER['SERVER_NAME']);	// Unique id, based on site domain (required if any component UID is missing)
$vcalendar->setConfig( 'url', $calendar );	// Remote input file
$vcalendar->setConfig( 'language', 'fr' );	// Remote input file
$vcalendar->setProperty( "X-WR-TIMEZONE", "Europe/Paris" );
date_default_timezone_set('Europe/Paris');

/*
$vcalendar->setProperty( 'method', 'PUBLISH' );
$vcalendar->setProperty( "x-wr-calname", "Evénements" );
$vcalendar->setProperty( "X-WR-CALDESC", $title);
*/
$vcalendar->parse();
$vcalendar->sort();	// Ensure start date order

// Select events
$events_arr = $vcalendar->selectComponents($startyear,$startmonth,$startday,$endyear,$endmonth,$endday,$event_type);

$eventcount = 0;
$undouble_events = array();

$content = "";
if ($full) {
	$content .= $title;
	if ($num_items == 1) $content .= "Affichage de $num_items élément";
	else if ($num_items > 1) $content .= "Affichage de $num_items éléments";
	else $content .= "Affichage de tous les éléments";
	$content .= ", entre J-$timeframe_before et J+$timeframe_after.<br /><br />";
}

// Wrappers and templates elements
$wrap1 = '<h3 style="display:inline;">';
$wrap2 = '</h3>';
$separator = '<div class="clearfloat"></div><br />';
$fr_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');


// Generate content
if ($events_arr) foreach( $events_arr as $year => $year_arr ) {
	if ($year_arr) foreach( $year_arr as $month => $month_arr ) {
		if ($month_arr) foreach( $month_arr as $day => $day_arr ) {
			if ($day_arr) foreach( $day_arr as $event ) {
				$start = null; $end = null; $startdate = null; $enddate = null;
				$event_string = null;
				$startdate = $event->getProperty('dtstart');
				$enddate = $event->getProperty('dtend');
				
				// Gestion du décalage horaire en fonction de la timezone définie : O donne le décalage de timezone en heures, Z en secondes..
				// "Z" = date notée en GMT = pas de décalage dans l'heure donc application du offset (sinon offset = 0)
				if ($startdate['tz'] != "Z") { $offset	= 0; } else { $offset = (int) substr(date("O",time()), 1, 2); }
				
				/* Filtrage possible mais pas utilisé car impacterait d'autres vues, + parseur variable selon les fichiers ('\n') + à implémenter dans une autre vue "déployée", et dans la configuration
				$categories = explode('\n', $event->getProperty('categories'));
				$categories = $categories[0];
				if ($categories != "Correspondants") break;
				*/
				// Vue complète (attention, vue par défaut utilisée pour listing)
				if ($full) {
					$description = $event->getProperty('description');
					$search_a = array(
						'\n ', '\n', '\r\n', '\n\n', '\r ', '\r', 
						'\"', "DQUOTE", '"');
					$replace_a = array(
						"", " <br>", " <br>", " <br>", "", " <br>", 
						"&quot;", "&quot;", "&quot;");
					if (!empty($description)) {
						$description = str_replace(array("\r ", "\r"), '', $description); // Nécessaire pour pouvoir parser correctement le contenu (CR + un espace)
						$description = '' . str_replace($search_a, $replace_a, $description);
						$description = '<div class="description">' . $description . '</div>';
					}
					// Location
					$location = $event->getProperty('location');
					if (!empty($location)) {
						// Nécessaire pour pouvoir parser correctement le contenu (CR + un espace)
						$location = str_replace(array("\r ", "\r"), '', $location);
						$location = '<br /><em><span class="location">' . $location . '</span></em><br />';
					}
					$url = $event->getProperty('url');
					if (!empty($url)) {
						$url = 'Lien : <a href="' . $url . '">' . $url . '</a><br />';
					}
				}
				$summary = $event->getProperty('summary');
				if (!empty($summary)) {
					// Nécessaire pour pouvoir parser correctement le contenu (CR + un espace)
					$summary = str_replace(array("\r ", "\r", '\"'), array('', '', '"'), $summary);
					$summary = str_replace('DQUOTE', '"', $summary);
				}
				$month = $startdate['month'];
				$endmonth = $enddate['month'];
				$month = $fr_months[(int)$month-1];
				$endmonth = $fr_months[(int)$endmonth-1];
				// Parse links
				$summary = parse_urls($summary);
				$description = parse_urls($description);
				// Affichage clean des dates et heures : on affiche certaines infos minimales, en évitant de doublonner si possible
				// On affiche l'année SSI elle diffère
				if ($enddate["year"] != $startdate["year"]) {
					$start = ' ' . $startdate["year"];
					$end = ' ' . $enddate["year"];
					$addmonth = true;
				}
				// On affiche le jour, et le jour de fin SSI il diffère
				$start = $startdate["day"] . $start;
				if ($addday || ($enddate["day"] != $startdate["day"])) {
					$start .= '-' . $enddate["day"];
					//$end .= $enddate["day"] . $end;
					$addhour = true;
				}
				// On affiche le mois, et le mois de fin SSI il diffère
				$start .= ' ' . $month;
				if ($addmonth || ($endmonth != $month)) {
					$end = ' ' . $endmonth . $end;
					$addday = true;
				}
				// On affiche l'heure, et l'heure de fin SSI elle diffère
				$start .= ', ' . ($startdate["hour"] + $offset) . "h{$startdate["min"]}";
				//if ($addhour) { $end .= ', '; }
				if ($enddate["hour"] != $startdate["hour"]) {
					$end .= ($enddate["hour"] + $offset) . "h{$enddate["min"]}";
				}
				if (!empty($end)) $end = ' - ' . $end;
				$event_string = '<div class="vevent">' 
					. '<span class="dtstart" style="display:none;">' . "{$startdate["year"]}-{$startdate["month"]}-{$startdate["day"]}T" . ($startdate["hour"] + $offset) . ":{$startdate["min"]}:{$startdate["sec"]}" . '</span>' 
					. '<span class="dtend" style="display:none;">' . "{$enddate["year"]}-{$enddate["month"]}-{$enddate["day"]}T" . ($enddate["hour"] + $offset) . ":{$enddate["min"]}:{$enddate["sec"]}" . '</span>' 
					. $wrap1 . $start . $end . ' : ' . $wrap2 
//						. '<span class="summary">' . $wrap1 . $summary . $wrap2 . "</span>\n" 
					. '<span class="summary">' . $wrap1 . $summary . $wrap2 . "</span>\n" 
					. $location 
					. $url
					. $description 
					. "</div>\n";
				
				if (!in_array($event_string, $undouble_events)) { $content .= $event_string . $separator; }
				$undouble_events[] = $event_string; // Dédoublonnage
				$eventcount++;
				
				// Break if a max number of items was defined
				if ($num_items && ($eventcount >= $num_items)) break 4;
			}
		}
	}
}

// Displays the content
echo $content;

