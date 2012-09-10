<?php

// Load Elgg engine
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");

// Get callbacks
$vars['deck-river'] = array(
					'tab' => get_input('tab', 'false'),
					'column' => get_input('column', 'false'),
					'new' => get_input('new', 'false')
				);

echo elgg_view_form('deck_river/column_settings', array('class' => 'deck-river-form-column-settings'), $vars);
