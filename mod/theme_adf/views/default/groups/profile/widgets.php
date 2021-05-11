<?php
/**
* Profile widgets/tools
*/

$group = elgg_extract('entity', $vars);

echo '<div class="group-details">';
if ($group->canAccessContent()) {
	echo elgg_view('groups/sidebar/search', ['entity' => $group]);
	echo elgg_view('groups/sidebar/owner', ['entity' => $group]);
	echo elgg_view('groups/sidebar/members', ['entity' => $group]);
} else {
	echo elgg_view('groups/sidebar/owner', ['entity' => $group]);
}
echo '</div>';


//echo '<div style="display: flex; flex-wrap: wrap;">';
	//echo elgg_view("groups/profile/module/activity", ['tool' => 'activity'] + $vars);
	use Elgg\Activity\GroupRiverFilter;
	use Elgg\Database\QueryBuilder;
	$all_link = elgg_view('output/url', [
		'href' => elgg_generate_url('collection:river:group', ['guid' => $group->guid,]),
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	]);
	elgg_push_context('widgets');
	echo elgg_view('output/url', [
	'href' => elgg_generate_url('collection:river:group', ['guid' => $group->guid]),
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
	'class' => 'float-alt',
]);
	echo '<h3>' . elgg_echo('collection:river:group') . '</h3>';
	echo elgg_list_river([
		'wheres' => [ new GroupRiverFilter($group) ],
		'no_results' => elgg_echo('river:none'),
	]);
	elgg_pop_context();
	
	// Autres modules : cf. vue car on n'en affiche que certains.
	$modules = elgg_view('groups/profile/modules', $vars);
	echo elgg_format_element('div', [
		'id' => 'groups-tools',
	], $modules);
//echo '</div>';

