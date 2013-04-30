<?php
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Load plugin model
require_once(dirname(__FILE__) . "/models/model.php");

$q = strtolower(get_input('q'));
if (!$q) return;

echo autocomplete_members_complete($q);

