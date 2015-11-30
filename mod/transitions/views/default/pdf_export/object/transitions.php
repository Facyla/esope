<?php
$transitions = elgg_extract('entity', $vars);

if (elgg_instanceof($transitions, 'object', 'transitions')) {
	/*
	elgg_push_context('widgets');
	echo elgg_view_entity($transitions, array('full_view' => true, 'list_type' => 'list'));
	elgg_pop_context();
	*/
	
	$title = $transitions->title;
	if (empty($title)) $title = $transitions->name;
	if (empty($title)) $title = elgg_echo('untitled');
	
	echo elgg_view_title($title);
	if ($transitions->icontime) { echo elgg_view_entity_icon($transitions, 'master', array()); }
	
		echo '<span class="transitions-' . $transitions->category . '" style="float:left; margin-right:1em;">';
	if (!empty($transitions->category)) echo elgg_echo('transitions:category:' . $transitions->category);
	if (($transitions->category == 'actor') && !empty($transitions->actor_type)) echo '&nbsp;: ' . elgg_echo('transitions:actortype:' . $transitions->actor_type) . '';
	echo '</span>';
	
	if (!empty($transitions->excerpt)) echo '<p><strong><em>' . $transitions->excerpt . '</em></strong></p>';
	
	// Territory : actor|project|event only
	if (in_array($transitions->category, array('actor', 'project', 'event')) && !empty($transitions->territory)) {
		echo '<span style="float:right">' . elgg_view('transitions/location_map', array('entity' => $transitions, 'width' => '300px', 'height' => '150px;')) . '</span>';
		echo '<p><i class="fa fa-map-marker"></i> ' . elgg_echo('transitions:territory') . '&nbsp;: ' . $transitions->territory . '</p>';
	}
	
	// Dates : projects and events only
	if (in_array($transitions->category, array('project', 'event'))) {
		if (!empty($transitions->start_date) || !empty($transitions->end_date)) {
			echo '<p><i class="fa fa-calendar-o"></i> ';
		}
		if ($transitions->category == 'project') {
			// Format : MM YYYY [- MM YYYY]
			$date_format = elgg_echo('transitions:dateformat');
			if (!empty($transitions->start_date) && !empty($transitions->end_date)) {
				echo date($date_format, $transitions->start_date) . ' - ' . date($date_format, $transitions->end_date);
			} else if (!empty($transitions->start_date)) {
				echo date($date_format, $transitions->start_date);
			} else if (!empty($transitions->end_date)) {
				echo date($date_format, $transitions->end_date);
			}
		} else {
			$date_format = elgg_echo('transitions:dateformat:time');
			// Format : from DD MM YYYY [until DD MM YYYY]
			if (!empty($transitions->start_date) && !empty($transitions->end_date)) {
				echo elgg_echo('transitions:date:since') . ' ' . date($date_format, $transitions->start_date);
				echo ' ' . elgg_echo('transitions:date:until') . ' ' . date($date_format, $transitions->end_date);
			} else if (!empty($transitions->start_date)) {
				echo elgg_echo('transitions:date:since') . ' ' . date($date_format, $transitions->start_date);
			} else if (!empty($transitions->end_date)) {
				echo elgg_echo('transitions:date:until') . ' ' . date($date_format, $transitions->end_date);
			}
		}
		if (!empty($transitions->start_date) || !empty($transitions->end_date)) { echo '</p>'; }
	}
	
	// URL et PJ
	if (!empty($transitions->url)) echo '<p><i class="fa fa-external-link"></i> ' . elgg_echo('transitions:url') . '&nbsp;: <a href="' . $transitions->url . '" target="_blank">' . $transitions->url . '</a>';
	if (!empty($transitions->attachment)) echo '<p><i class="fa fa-download"></i> ' . elgg_echo('transitions:attachment') . '&nbsp;: <a href="' . $transitions->getAttachmentURL() . '" target="_blank">' . $transitions->getAttachmentName() . '</a></p>';
	
	// Languages
	if (!empty($transitions->lang) || !empty($transitions->resource_lang)) {
		echo '<p>';
		if (!empty($transitions->lang)) {
			echo '<i class="fa fa-flag"></i> ' . elgg_echo('transitions:lang'). '&nbsp;: ' . elgg_echo($transitions->lang) . ' &nbsp; ';
		}
		if (!empty($transitions->resource_lang)) {
			echo '<i class="fa fa-flag-o"></i> ' . elgg_echo('transitions:resourcelang'). '&nbsp;: ' . elgg_echo($transitions->resource_lang);
		}
		echo '</p>';
	}
	
	echo '<div class="clearfloat"></div>';
	
	echo elgg_view('output/longtext', array('value' => $transitions->description));
}

