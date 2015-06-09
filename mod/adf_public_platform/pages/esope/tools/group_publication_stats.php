<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


admin_gatekeeper();

$title = "Statistiques sur les publications dans un groupe";
$content = '';
$sidebar = '';

$group_guid = get_input('group_guid', false);
$group = get_entity($group_guid);


// Group switch form
$content .= '<form method="POST">';
$content .= '<fieldset>';
$content .= elgg_view('input/securitytoken');
$content .= '<p><label>Choix du groupe ' . elgg_view('input/groups_select', array('name' => 'group_guid', 'value' => $group_guid)) . '</label></p>';
$content .= '<p>' . elgg_view('input/submit') . '</p>';
$content .= '</fieldset>';
$content .= '</form>';



if (elgg_instanceof($group, 'group')) {
	$options = array('types' => 'object', 'container_guid' => $group->guid, 'limit' => false);
	$all_objects = elgg_get_entities($options);
	$content .= "Le groupe {$group->name} comporte actuellement  " . count($all_objects) . " publications.<br /><br />";

	$content .= '<style>
	#group-publications-table, #group-publications-table tr, #group-publications-table th, #group-publications-table td { border:1px solid black; }
	#group-publications-table th { padding:4px 2px; text-align:center; }
	#group-publications-table td { padding:1px 4px; }
	</style>';


	$objects_stats = array();
	$users_stats = array();
	$subtypes = array();
	foreach ($all_objects as $ent) {
		$subtype = $ent->getSubtype();
		$user_guid = $ent->owner_guid;
		// List distinct subtypes
		if (!in_array($subtype, $subtypes)) { $subtypes[] = $subtype; }
		// Count objects per subtype
		if (!isset($objects_stats[$subtype])) { $objects_stats[$subtype] = 0; }
		$objects_stats[$subtype] = $objects_stats[$subtype] + 1;
		// Count objects per user (per subtype)
		if (!isset($users_stats[$user_guid])) { $users_stats[$user_guid] = array(); }
		if (!isset($users_stats[$user_guid][$subtype])) { $users_stats[$user_guid][$subtype] = 0; }
		$users_stats[$user_guid][$subtype] = $users_stats[$user_guid][$subtype] + 1;
	}
	
	//$content .= '<pre>' . print_r($objects_stats, true) . '</pre>';
	//$content .= '<pre>' . print_r($users_stats, true) . '</pre>';
	
	// Affichage par membre
	if ($users_stats) {
		$content .= '<h3>Tableau des publications par membre du groupe</h3>';
		$content .= '<div style="width:96%; overflow:auto;">';
		$content .= '<table id="group-publications-table">';
		$content .= '<tr><th rowspan="2">Membre</th><th colspan="' . count($subtypes) . '">Type de publication</th><th rowspan="2">Total</th></tr>';
		$content .= '<tr>';
		foreach ($subtypes as $subtype) { $content .= '<td>' . $subtype . '</td>'; }
		$content .= '</tr>';
		foreach ($users_stats as $user_guid => $user_stats) {
			$user = get_entity($user_guid);
			$content .= '<tr>';
			$content .= '<td><a href="' . $user->getURL() . '">' . $user->name . '</a></td>';
			//$content .= '<td rowspan="' . sizeof($user_stats) . '"><a href="' . $user->getURL() . '">' . $user->name . '</a></td>';
			$user_total = 0;
			foreach ($subtypes as $subtype) {
				$count = 0;
				if ($user_stats[$subtype]) { $count = $user_stats[$subtype]; }
				$user_total += $count;
				$content .= '<td>' . $count . '</td>';
			}
			$content .= '<td><strong>' . $user_total . '</strong></td>';
			/* Alternative display : merged cells for each member
			$new_row = false;
			foreach ($user_stats as $subtype => $count) {
				if ($new_row) { $content .= '</tr><tr>'; } else { $new_row = true; }
				$content .= '<td>' . $subtype . '</td>';
				$content .= '<td>' . $count . '</td>';
			}
			$content .= '</tr>';
			*/
		}
		$content .= '<tr>';
		$content .= '<th>Total</th>';
		foreach ($subtypes as $subtype) {
			$content .= '<td><strong>' . $objects_stats[$subtype] . '</strong></td>';
		}
		$content .= '</tr>';
		$content .= '</table>';
		$content .= '</div>';
		$content .= '<br />';
	}
}


$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


