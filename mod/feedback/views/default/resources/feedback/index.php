<?php
elgg_gatekeeper();

$base_url = elgg_get_site_url() . 'feedback/';
$site = elgg_get_site_entity();

elgg_set_context('feedback');
elgg_push_breadcrumb('feedback', $base_url);

// Admin gatekeeper - Allow members to read feedbacks ?
$memberview = elgg_get_plugin_setting("memberview", "feedback");
if ($memberview != 'yes') { admin_gatekeeper(); }

// Group gatekeeper
$feedbackgroup = elgg_get_plugin_setting('feedbackgroup', 'feedback');
if (!empty($feedbackgroup) && ($feedbackgroup != 'no') && ($feedbackgroup != 'grouptool')) {
	if ($group = get_entity($feedbackgroup)) {
		elgg_set_page_owner_guid($feedbackgroup);
		//$base_url .= 'group/' . $feedbackgroup;
		if (elgg_in_context('feedback')) {
			elgg_set_page_owner_guid($site->guid);
		} else {
			$limit = get_input('limit', 3);
		}
	}
}


// Useful vars
$counts = [];
// Form select options (+ add allowed values)
$status_opt = ['' => elgg_echo('feedback:status:nofilter')];


// Filters and params
$limit = get_input('limit', 10);

// Status
$status = get_input('status', ''); // Status filter
$allowed_status_values = array('open', 'closed');
foreach ($allowed_status_values as $name) {
	$counts[$name] = 0;
	$status_opt[$name] = elgg_echo("feedback:status:$name");
}
if ($status && !in_array($status, $allowed_status_values)) { $status = false; }

// About filter - Catégories de feedback
$about_enabled = feedback_is_about_enabled();
if ($about_enabled) {
	$about = get_input('about', false);
	$allowed_about_values = feedback_about_values();
	$about_opt = ['' => elgg_echo('feedback:about:nofilter')];
	// Init all "about" counters (so we can have a 0 value instead of nothing)
	foreach ($allowed_about_values as $name) {
		$counts[$name] = 0;
		$about_opt[$name] = elgg_echo("feedback:about:$name");
	}
	// @TODO Ajouter filtre pour feedback sans about défini
	//$about_opt['notset'] = elgg_echo("feedback:about:undefined");
	if ($about && !in_array($about, $allowed_about_values)) { $about = false; }
}

// Mood filter
$mood_enabled = feedback_is_mood_enabled();
if ($mood_enabled) {
	$mood = get_input('mood', false);
	$allowed_mood_values = feedback_mood_values();
	$mood_opt = ['' => elgg_echo('feedback:mood:nofilter')];
	foreach ($allowed_mood_values as $name) {
		$counts[$name] = 0;
		$mood_opt[$name] = elgg_echo("feedback:search:mood:$name");
	}
	// @TODO Ajouter filtre pour feedback sans mood défini
	//$mood_opt['notset'] = elgg_echo("feedback:mood:undefined");
	if ($mood && !in_array($mood, $allowed_mood_values)) { $mood = false; }
}


// Feedback search form
$content .= '<form method="GET" action="' . elgg_get_site_url() . 'feedback">';
	$content .= '<label>Statut ' . elgg_view('input/select', ['name' => 'status', 'value' => $status, 'options_values' => $status_opt]) . '</label>';
	if ($about_enabled) {
		$content .= '<label>Catégorie ' . elgg_view('input/select', ['name' => 'about', 'value' => $about, 'options_values' => $about_opt]) . '</label>';
	}
	if ($mood_enabled) {
		$content .= '<label>Humeur ' . elgg_view('input/select', ['name' => 'mood', 'value' => $mood, 'options_values' => $mood_opt]) . '</label>';
	}
	$content .= elgg_view('input/submit', ['text' => "Rechercher les feedbacks"]);
$content .= '</form>';


// FEEDBACKS LIST
$options = [
	'type' => 'object', 'subtype' => 'feedback', 
	'limit' => $limit,
	'full_view' => false, 
	'list_type_toggle' => false, 
	'pagination' => true
];

// Add status filter (metadata is always set)
if ($status) {
	$options['metadata_name_value_pairs'][] = ['name' => 'status', 'value' => $status];
}

// Add mood filter (optional metadata)
if ($mood) {
	if ($mood == 'other') {
		// Get feedbacks without mood
		$dbprefix = elgg_get_config('dbprefix');
		$options['wheres'][] = "NOT EXISTS (SELECT 1 FROM {$dbprefix}metadata md WHERE md.entity_guid = e.guid AND md.name = 'mood')";
	} else {
		$options['metadata_name_value_pairs'][] = ['name' => 'mood', 'value' => $mood];
	}
}
// Add about filter
if ($about) {
	if ($about == 'other') {
		// Get feedback without about
		$dbprefix = elgg_get_config('dbprefix');
		$options['wheres'][] = "NOT EXISTS (SELECT 1 FROM {$dbprefix}metadata md WHERE md.entity_guid = e.guid AND md.name = 'about')";
	} else {
		$options['metadata_name_value_pairs'][] = ['name' => 'about', 'value' => $about];
	}
}

//$content .= '<pre>' . print_r($options, true) . '</pre>';
$count = elgg_get_entities(['count' => true] + $options);
$content .= elgg_list_entities($options);
$content .= '<div class="clearfloat"></div>';


// Sidebar menu - Menu latéral
$sidebar = elgg_view('feedback/sidebar');



// Titre de la page
$title = '<i class="fa fa-bullhorn"></i> ' . elgg_echo('feedback:admin:title');
// + filtre "status"
if ($status && ($status != 'total')) {
	$title .= ' ' . strtolower(elgg_echo('feedback:status:'.$status));
}
// + filtre "about"
if ($about) {
	$title .= ' ' . elgg_echo('feedback:about') . ' &laquo;&nbsp;' . elgg_echo('feedback:about:'.$about) . '&nbsp;&raquo;';
}
$title .= " ($count)";


$body = elgg_view_layout('default', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

echo elgg_view_page(strip_tags($title), $body);

