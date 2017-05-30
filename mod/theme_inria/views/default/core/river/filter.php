<?php
/**
 * Content filter for river
 *
 * @uses $vars[]
 */

elgg_load_js('elgg.ui.river');

$filter = '';

// create selection array
$options = array();
$options['type=all'] = elgg_echo('river:select', array(elgg_echo('all')));
$registered_entities = elgg_get_config('registered_entities');

if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $subtypes) {
		// subtype will always be an array.
		if (!count($subtypes)) {
			$label = elgg_echo('river:select', array(elgg_echo("item:$type")));
			$options["type=$type"] = $label;
		} else {
			foreach ($subtypes as $subtype) {
				$label = elgg_echo('river:select', array(elgg_echo("item:$type:$subtype")));
				$options["type=$type&subtype=$subtype"] = $label;
			}
		}
	}
}

$params = array(
	'id' => 'elgg-river-selector',
	'options_values' => $options,
);
$selector = $vars['selector'];
if ($selector) {
	$params['value'] = $selector;
}
$filter .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . elgg_echo('theme_inria:activity_type') . elgg_view('input/select', $params) . '</label><div class="clearfloat"></div></div>';



// Filtre par date
$date_filter = get_input('date_filter', 'all');
$date_filter_opt = array(
		'all' => elgg_echo('theme_inria:date_filter:all'),
		'today' => elgg_echo('theme_inria:date_filter:today'),
		'yesterday' => elgg_echo('theme_inria:date_filter:yesterday'),
		'lastweek' => elgg_echo('theme_inria:date_filter:lastweek'),
		'lastlogin' => elgg_echo('theme_inria:date_filter:yesterday', array(date('d-m-Y H:i:s', $own->prev_last_login))),
	);
$filter .= '<div class="esope-search-metadata esope-search-metadata-select">
		<label>' . elgg_echo('theme_inria:date_filter') . elgg_view('input/select', array('name' => 'date_filter', 'value' => $date_filter, 'options_values' => $date_filter_opt)) . '</label>
		<div class="clearfloat"></div>
	</div>';


// Submit
$filter .= elgg_view('input/submit');



echo '<form class="esope-date-filter">
		' . $filter . '
	</form>';

