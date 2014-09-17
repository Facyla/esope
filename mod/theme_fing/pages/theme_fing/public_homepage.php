<?php
/**
 * Public index page
 *
 */

global $CONFIG;

$site = elgg_get_site_entity();
$title = $site->name;


// Sliders : semi-automatique avec articles en Une sélectionnés
$slidercontent = elgg_get_plugin_setting('content', 'slider');
if (!empty($slidercontent)) {
	// Si on a un <ul> ou <ol> au début et </ul> ou </ol> à la fin de la liste
	$start_list = substr($slidercontent, 0, 4);
	if (in_array($start_list, array('<ol>', '<ul>'))) {
		$slidercontent = substr($slidercontent, 4);
		// Note : this technique avoids errors when an extra line was added after the list..
		if ($start_list == '<ul>') { $end_pos = strripos($slidercontent, '</ul>'); } else { $end_pos = strripos($slidercontent, '</ol>'); }
		if ($end_pos !== false) { $slidercontent = substr($slidercontent, 0, $end_pos); }
	}
}
// Now add content auto-loader after the configured elements
$selected_articles = theme_fing_get_pin_entities();
$pin_exclude = array(); // Liste les articles à ne pas reprendre dans l'autre listing des articles en Une
$i = 0;
foreach ($selected_articles as $ent) {
	$pin_exclude[] = $ent->guid;
	$i++;
	
	$title = $ent->title;
	// Image
	$image_url = '';
	if ($ent->icontime) { $image_url = $ent->getIconURL('large'); }
	// Forget empty or default image
	if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
		$image_url = esope_extract_first_image($ent->description, false);
	}
	// Last method if stil nothing : use author image
	if (empty($image_url)) {
		$container = $ent->getOwnerEntity();
		$image_url = $container->getIconURL('large');
	}
	$image = '<img src="' . $image_url . '" style="max-height:200px !important; width:auto !important;" />';
	// Excerpt
	$text = $ent->excerpt;
	if (empty($text)) $text = $ent->briefdescription;
	$text .= $ent->description;
	$text =  htmlspecialchars(html_entity_decode(strip_tags($text)), ENT_NOQUOTES, 'UTF-8');
	$excerpt = elgg_get_excerpt($text, 300);
	// Compose slider element
	$slidercontent .= '<li>';
	$slidercontent .= '<div class=""><table style="width: 100%;" style="border:0;"><tbody><tr>';
	$slidercontent .= '<td style="width:50%; text-align: center; height: 200px; vertical-align: middle;">' . $image . '</td>';
	$slidercontent .= '<td style="width:50%;"><div class="textSlide"><h3><a href="' . $ent->getURL() . '">' . $title . '</a></h3><div style="font-size: 16px;">' . $excerpt . '</div></div></td>';
	$slidercontent .= '</tr></table></div></li>';
	if ($i >= 3) { break; }
}
$slider_vars = array(
	'slidercontent' => $slidercontent,
	'width' => "100%",
	'height' => "250px",
);
$slider = elgg_view('slider/slider', $slider_vars);



// HOME PINS
// CONTENUS MIS EN AVANT (FONCTION "PIN") - sauf ceux explictement exclus car affichés dans le slider
$home_pins = '';
$i = 0;
// Note : limit should be set to nb_exclude+nb_todisplay, so N+3
$pin_max = 6;
$pin_limit = count($pin_exclude) + $pin_max;
$params = array('metadata_name' => 'highlight', 'types' => 'object', 'limit' => $pin_limit);
$recent_pins = elgg_get_entities_from_metadata($params);
if (is_array($recent_pins)) {
	foreach ($recent_pins as $ent) {
		// Affichés donc à ne pas réafficher plus tard (passés à la vue de listing des highlight)
		if (is_array($pin_exclude) && in_array($ent->guid, $pin_exclude)) { continue; }
		$i++;
		
		// Récupération icône du plus personnel (auteur) au moins pire (site courant)..
		if ($ent_for_icon = get_entity($ent->owner_guid)) {} 
		else if ($ent_for_icon = get_entity($ent->container_guid)) {}
		else if ($ent_for_icon = get_entity($ent->site_guid)) {}
		if ($ent_for_icon instanceof ElggEntity) { $icon = $ent_for_icon->getIcon("small"); }
	
		// Sous forme de vignettes avec extrait
		if (elgg_is_logged_in()) {
			$home_pins .= '<div class="home_pin search_listing" title="' . $ent->title . '">';
		} else {
			$home_pins .= '<div class="home_pin_public search_listing" title="' . $ent->title . '">';
		}
		$home_pins .= '<div class="home_pin_content">';
		$entitle = elgg_get_excerpt($ent->title, 60);
		$home_pins .= '<a href="' . $ent->getURL() . '"><img src="'.$icon.'" class="groupthumb" style="float:left; margin-right:5px; width:40px; height:40px;" /><strong>' . $entitle . '</strong></a><br />';
		// Petit résumé contenu
		if (!empty($ent->description)) {
			//$short = elgg_get_excerpt(strip_tags($ent->description, '<i><em><b><strong>'), 300, " ", false, true);
			$short = elgg_get_excerpt($ent->description, 300);
			$home_pins .= '<span style="font-size:11px;">' . $short . '<div class="clearfloat"></div>
				<p style="text-align:right;"><a href="' . $ent->getURL() . '">Lire la suite... </a></p></span>';
		}
		$home_pins .= '</div></div>'; // Fin bloc pour tirets de séparation en bas
		if ($i >= $pin_max) { break; }
	}
}


// Focus
$focus = elgg_view('cmspages/view',array('pagetype'=>"accueil-haut-milieu"));



// COMPOSE PAGE CONTENT
//$content .= elgg_view('cmspages/view',array('pagetype'=>"accueil-entete"));

// COLONNE 1 : accueil gauche, agenda des groupes, groupes à la Une, nouveaux membres
$content .= '<div style="width:28%; float:left;"><div style="padding:1ex;">';
		$intro = elgg_view('cmspages/view',array('pagetype'=>"accueil-haut-gauche"));
		if (!empty($intro)) $content .= $intro . '<div class="clearfloat"></div><br />';
	
		// Liste des groupes avec icônes
		$content .= '<div>';
			$content .= '<h2>Participer à nos Travaux</h2>';
			$groups = elgg_get_entities_from_metadata(array('types' => 'group', 'limit' => 0, 'metadata_name_value_pairs' => array('name' => 'featured_group', 'value' => 'yes')));
			shuffle($groups);
			foreach ($groups as $group) {
				$content .= '<a href="' . $group->getURL() . '">';
				$content .= '<h3>' . $group->name . '</h3>';
				$content .= '<div style="float:left; clear:left; padding-bottom:16px; width:100%;">';
				$content .= '<img src="' . $group->getIconURL('small') . '" style="float:left; margin:0 6px 4px 0;"/>';
				$content .= '<p style="font-size:11px;">' . $group->publicdescription . '</p>';
				$content .= '</div>';
				$content .= '</a>';
			}
		$content .= '</div>';
		
$content .= '</div></div>';


// COLONNE PRINCIPALE : intro, focus, pins, activité ?
$content .= '<div style="width:70%; float:right;"><div style="padding:1ex;">';
		$intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
		if (!empty($intro)) $content .= $intro . '<div class="clearfloat"></div>';
		
		// Slider
		$content .= '<div style="width:100%;" class="fing-slider">'
				. $slider
				//. elgg_view('cmspages', array('pagetype' => 'fing-accueil-connecte'))
			. '</div>
			<div class="clearfloat"></div><br /><br />';

		// FOCUS & PINS
		$content .= '<div>';
			// Suite de la liste de contenus épinglés
			if (!empty($home_pins)) {
				$content .= '<div id="home_pin_blocks">' . $home_pins . '</div>';
				$content .= '<div class="clearfloat"></div><br />';
			}
		$content .= '</div>';
		$content .= '<p><strong><a href="' . $CONFIG->url . 'mod/pin/index.php">Tous les articles choisis</a></strong></p>';
		$content .= '<div class="clearfloat"></div>';
		$content .= '<br />';
		
$content .= '</div></div>';

// Evénements : : agenda sous forme de timeline
if (elgg_is_active_plugin('event_calendar')) {
	elgg_load_library('elgg:event_calendar');
	/*
	elgg_load_library('elgg:event_calendar');
	$content .= '<h2>Agenda des groupes</h2>';
	$start_date = date('Y-m-d');
	$start_ts = strtotime($start_date);
	$end_ts = $start_ts + 50000000;
	$events_count = event_calendar_get_events_between($start_ts,$end_ts,true,3,0);
	$events = event_calendar_get_events_between($start_ts,$end_ts,false,3,0);
	if ($events) $content .= elgg_view_entity_list($events, $events_count, 0, 3, false, false);
	else $content .= '<p>Aucun événement public pour le moment.<br />Connectez-vous pour accéder aux événements réservés aux membres.</p>';
	*/
	
	elgg_push_context('widgets');
	$start_ts = time() - 24*3600; // Starting date
	$end_ts = $start_ts + 366*24*3600; // End date
	// @TODO : select only the need number of events ?
	$count_recent_events = event_calendar_get_events_between($start_ts,$end_ts,true,0,0,0,false);
	$recent_events = event_calendar_get_events_between($start_ts,$end_ts,false,$count_recent_events,0,0,false);
	/*
	// Tri des events de la timeine des autres : timeline si tag timeline, sinon agenda
	if ($recent_events) foreach ($recent_events as $ent) {
		if (in_array('timeline', $ent->tags) || ($ent->tags == 'timeline')) { $timeline_events[] = $ent; } else $agenda_events[] = $ent;
	}
	*/
	$timeline_events = $recent_events;
	// Timeline = 5 derniers events taggués "timeline"
	$timeline_events = array_slice($timeline_events, 0, 5);
	$timeline .= '<h2>Timeline</h2>';
	foreach ($timeline_events as $ent) {
		$timeline .= elgg_view("object/timeline_event_calendar",array('entity' => $ent));
	}
	$timeline .= '<div class="clearfloat"></div>';
	$content .= '<div class="clearfloat"></div><br />';
	$content .= '<div class="home-timeline">' . $timeline . '</div>';

	// Agenda = 3 derniers events sauf timeline
	/*
	$agenda_events = array_slice($agenda_events, 0, 3);
	$agenda = '<a class="viewall" href="' . $CONFIG->url . 'event_calendar/list">Tous les événements</a><h3>Agenda</h3><hr />';
	foreach ($agenda_events as $ent) {
		$agenda .= elgg_view("object/home_event_calendar",array('entity' => $ent));
	}
	$agenda .= '<div class="clearfloat"></div>';
	elgg_pop_context('widgets');
	$agenda = '<div class="elgg-homemodule home-agenda">' . $agenda . '</div>';
	*/
}



//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = '<div id="fing-homepage">' . $content . '<div class="clearfloat"></div></div>';



// Affichage
echo elgg_view_page($title, $body);

