<?php
/**
 * Content filter for river
 *
 * @uses $vars[]
 */

// Iris : désactivation du JS car on a maintenant 2 champs de recherche et donc on veut pouvoir cliquer sur le bouton d'envoi
// Note : impact sur passage des paramètres + le select doit avoir un name si JS désactivé
//elgg_load_js('elgg.ui.river');

$filter = '';

$page_type = get_input('page_type');
$type = get_input('type');
$subtype = get_input('subtype');
$action_types = get_input('action_types');

// Build activity type selector
/*
$selector = array();
if (!empty($type)) { $selector[] = "type=$type"; }
if (!empty($subtype)) { $selector[] = "subtype=$subtype"; }
if (!empty($action_types)) { $selector[] = "action_types=$action_types"; }
$vars['selector'] = implode('&', $selector);
*/
$params = array(
	'id' => 'elgg-river-selector',
	'options_values' => $options,
);
$selector = $vars['selector'];
if ($selector) { $params['value'] = urldecode($selector); }

// Filtres composites
$options = array();
$options['type=all'] = elgg_echo('theme_inria:activity_filter:all');
$options["type=object&subtype=blog"] = elgg_echo('theme_inria:activity_filter:blog');
$options["type=object&subtype=comment"] = elgg_echo('theme_inria:activity_filter:comments');
$options["type=site&action_types=join"] = elgg_echo('theme_inria:activity_filter:users');
$options["type=user&action_types=update"] = elgg_echo('theme_inria:activity_filter:profile');
//$options["type=user&action_types=friend"] = elgg_echo('theme_inria:activity_filter:friends');
$options["type=group"] = elgg_echo('theme_inria:activity_filter:groups');


// create selection array
$exclude_subtypes = array('groupforumtopic', 'discussion_reply');
// Some subtypes are reserved for admins
if (!elgg_is_admin_logged_in()) {
	$exclude_subtypes[] = 'cmspage';
	$exclude_subtypes[] = 'feedback';
}
//$options = array();
//$options['type=all'] = elgg_echo('river:select', array(elgg_echo('all')));
$registered_entities = elgg_get_config('registered_entities');
if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $subtypes) {
		// Skip groups (option already exists)
		//if ($type == 'group') { continue; }
		if ($type != 'object') { continue; }
		
		// subtype will always be an array.
		if (!count($subtypes)) {
			$label = elgg_echo('river:select', array(elgg_echo("item:$type")));
			$options["type=$type"] = $label;
		} else {
			foreach ($subtypes as $subtype) {
				// Skip unwanted subtypes
				if (in_array($subtype, $exclude_subtypes)) { continue; }
				// Merge pages
				if (in_array($subtype, array('page_top', 'page'))) { $subtype = 'pages'; }
				$label = elgg_echo('river:select', array(elgg_echo("item:$type:$subtype")));
				$options["type=$type&subtype=$subtype"] = $label;
			}
			// Ajout réponses dans forum
			/*
			if ($type == 'object') {
				$label = elgg_echo('river:select', array(elgg_echo("item:object:discussion_reply")));
				$options["type=$type&subtype=discussion_reply"] = $label;
			}
			*/
		}
	}
}

$params['options_values'] = $options;
$params['name'] = 'river_selector';

$filter .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . elgg_echo('theme_inria:activity_type') . elgg_view('input/select', $params) . '</label><div class="clearfloat"></div></div>';


// Filtre par date
// Dernier login : si aucun, depuis la création du site
$site = elgg_get_site_entity();
$own = elgg_get_logged_in_user_entity();
$last_login = $own->prev_last_login;
if ($last_login < 1) { $last_login = $own->last_login; }
if ($last_login < 1) { $last_login = $site->time_created; }
$last_login = date('d-m-Y H:i', $last_login);
$date_filter = get_input('date_filter', 'all');
$date_filter_opt = array(
		'all' => elgg_echo('theme_inria:date_filter:all'),
		'today' => elgg_echo('theme_inria:date_filter:today'),
		'yesterday' => elgg_echo('theme_inria:date_filter:yesterday'),
		'lastweek' => elgg_echo('theme_inria:date_filter:lastweek'),
		'lastlogin' => elgg_echo('theme_inria:date_filter:last_login', array($last_login)),
	);
$filter .= '<div class="esope-search-metadata esope-search-metadata-select">
		<label>' . elgg_echo('theme_inria:date_filter') . elgg_view('input/select', array('name' => 'date_filter', 'value' => $date_filter, 'options_values' => $date_filter_opt)) . '</label>
		<div class="clearfloat"></div>
	</div>';


// Submit
$filter .= elgg_view('input/submit');



echo '<form class="esope-date-filter" id="esope-search-form">
		' . $filter . '
	</form>';

