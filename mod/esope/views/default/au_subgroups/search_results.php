<?php

namespace AU\SubGroups;

if ($vars['subgroup_guid']) {
	$subgroup_guid = $vars['subgroup_guid'];
	$subgroup = get_entity($subgroup_guid);
}
else {
	$subgroup = elgg_get_page_owner_entity();
}

elgg_require_js('au_subgroups/edit');

$dbprefix = elgg_get_config('dbprefix');

$limit = get_input('limit', 20);

$options = array(
	'type' => 'group',
	'limit' => $limit,
	'joins' => array("JOIN {$dbprefix}groups_entity g ON e.guid = g.guid")
);

//if (empty($vars['q'])) {
// ESOPE : use at least 2 letters queries
if (strlen($vars['q']) < 3) {
	$options['order_by'] = "g.name ASC";
} else {
	$query = sanitize_string($vars['q']);
	/* ESOPE : search *any query word in both group title and description
	 * $options['selects'] = array("MATCH(g.name, g.description) AGAINST('$query') as relevance");
	 * $options['wheres'][] = "MATCH(g.name, g.description) AGAINST('$query')";
	 * Note on MATCH : matching is cool but requires 4 letters, and so basically to know the name of searched group
	 * plus it returns less results than a basic like search. So we'll use rather a basic search, 
	 * even without pertinence but using multiple keywords (in no particular order)
	 */
	$wheres = '';
	$queries = explode(' ', $query);
	foreach ($queries as $query) {
		if (strlen($query) < 3) continue;
		if (!empty($wheres)) $wheres .= ' AND ';
		$wheres .= "((g.name LIKE '%$query%') OR (g.description LIKE '%$query%'))";
	}
	$options['wheres'][] = $wheres;
	$options['order_by'] = "g.name ASC";
	
	// ESOPE : we do NOT want to list all groups before any search
	$groups = elgg_get_entities($options);
}


elgg_push_context('widgets'); // use widgets context so no entity menu is used
if ($groups) {
	echo '<div class="au-subgroups-result-col">';
	
	if (count($groups) >= ($limit - 1)) {
		echo '<p>' . elgg_echo('esope:subgroups:search:overmax', array($limit)) . '</p>';
	}
	
	for ($i=0; $i<count($groups); $i++) {
		// break results into 2 columns of 5
		// ESOPE : removed columns
		/*
		if ($i == 5) {
		  echo '</div>';
		  echo '<div class="au-subgroups-result-col">';
		}
		*/

	if (can_move_subgroup($subgroup, $groups[$i])) {
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
	// ESOPE : add search details
	if (empty($wheres)) echo '<p>' . elgg_echo('esope:subgroups:search:details') . '</p>';
}
elgg_pop_context();
