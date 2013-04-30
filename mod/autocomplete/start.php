<?php
require_once(dirname(__FILE__) . "/models/model.php");

function autocomplete_init() {
	elgg_extend_view('css','autocomplete/css');
	elgg_extend_view('page/elements/head','autocomplete/metatags'); // Facyla
}

elgg_register_event_handler('init','system','autocomplete_init');

