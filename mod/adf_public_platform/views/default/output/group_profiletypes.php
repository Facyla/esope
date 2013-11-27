<?php
// Lists all existing profile types and allows a multi select in the list
$profiletypes = esope_get_profiletypes();

foreach ($vars['value'] as $id) {
	$profiles[] = elgg_echo('profile:types:'.$profiletypes[$id]);
}

echo implode(', ', $profiles);

