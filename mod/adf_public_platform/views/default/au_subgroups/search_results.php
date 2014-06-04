<?php

if ($vars['subgroup_guid']) {
	$subgroup_guid = $vars['subgroup_guid'];
	$subgroup = get_entity($subgroup_guid);
}
else {
	$subgroup = elgg_get_page_owner_entity();
}

elgg_load_js('au_subgroups_edit.js');

$dbprefix = elgg_get_config('dbprefix');

$limit = 20;

$options = array(
	'type' => 'group',
	'limit' => $limit,
	'joins' => array("JOIN {$dbprefix}groups_entity g ON e.guid = g.guid")
);

if (strlen($vars['q']) > 2) {
	$query = sanitize_string($vars['q']);
	//$options['selects'] = array("MATCH(g.name, g.description) AGAINST('$query') as relevance");
	//$options['wheres'][] = "MATCH(g.name, g.description) AGAINST('$query')";
	// Iris : matching is cool but requires 4 letters and basically to know the name of searched group
	// plus it returns less results than a basic like search. So we'll use rather a basic search, 
	// even without pertinence but using multiple keywords (in no particular order)
	$wheres = '';
	$queries = explode(' ', $query);
	foreach ($queries as $query) {
		if (strlen($query) < 3) continue;
		if (!empty($wheres)) $wheres .= ' AND ';
		$wheres .= "((g.name LIKE '%$query%') OR (g.description LIKE '%$query%'))";
	}
	$options['wheres'][] = $wheres;
	$options['order_by'] = "g.name ASC";
	$groups = elgg_get_entities($options);
}


$context = elgg_get_context();
elgg_set_context('widgets'); // use widgets context so no entity menu is used
if ($groups) {
	echo '<div class="au-subgroups-result-col">';
	
	if (count($groups) >= ($limit - 1)) {
		echo '<p>' . elgg_echo('theme_inria:subgroups:search:overmax', array($limit)) . '</p>';
	}
	
	for ($i=0; $i<count($groups); $i++) {
		// break results into 2 columns of 5
		if (au_subgroups_can_move_subgroup($subgroup, $groups[$i])) {
			$class = 'au-subgroups-parentable';
		}
		else {
			$class = 'au-subgroups-non-parentable';
		}
	
		$action_url = elgg_get_site_url() . 'action/au_subgroups/move?parent_guid=' . $groups[$i]->guid;
		$action_url = elgg_add_action_tokens_to_url($action_url);
		echo "<div class=\"{$class}\" data-action=\"{$action_url}\">";
		echo elgg_view_entity($groups[$i], array('full_view' => false));
		echo "</div>";
	}
	
	echo '</div>';
}
else {
	echo elgg_echo('au_subgroups:search:noresults');
	if (empty($wheres)) echo '<p>' . elgg_echo('theme_inria:subgroups:search:details') . '</p>';
}
elgg_set_context($context);
