<?php
/**
 * Content filter for river
 *
 * @uses $vars[]
 */

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
echo '<div><label>' . "Types d'activité " . elgg_view('input/select', $params) . '</label><div class="clearfloat"></div></div>';

elgg_load_js('elgg.ui.river');



// Filtre par date
$date_filter = get_input('date_filter', 'all');
$date_filter_opt = array(
		'all' => "Tout",
		'today' => "Aujourd'hui seulement",
		'yesterday' => "Hier seulement",
		'lastweek' => "La semaine dernière",
		'lastlogin' => "Depuis ma dernière connexion",
	);
echo '<div><label>' . "Dates (NON FONCTIONNEL) " . elgg_view('input/select', array('name' => 'date_filter', 'value' => $date_filter, 'options_values' => $date_filter_opt)) . '</label><div class="clearfloat"></div></div>';


