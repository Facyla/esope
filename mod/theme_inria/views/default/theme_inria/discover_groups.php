<?php

// @TODO Types de groupes

/*
$groups = elgg_get_entities_from_metadata(array(
		'types' => 'group',
		'metadata_name' => 'featured_group',
		'metadata_value' => 'yes',
		'limit' => 12,
	));

if ($groups) {
	elgg_push_context('widgets');
	$body = '';
	foreach ($groups as $group) {
		$body .= '<div class="iris-home-group-category">' . elgg_view_entity_icon($group, 'medium') . '</div>';
		//$body .= '<a href="' . $group->getURL() . '"><img src="' . $group->getIconURL('small') . '" style="margin:1px 6px 3px 0;" title="' . $group->name . '" /></a>';
	}
	elgg_pop_context();

	echo '<div id="sidebar-featured-groups">
		<h3><a href="' . elgg_get_site_url() . 'groups/all" title="' . elgg_echo('theme_inria:groups:discover:tooltip') . '">' . elgg_echo("theme_inria:groups:discover") . ' &nbsp; &#9654;</a></h3>
		' . $body . '
		</div>';
}
*/


echo '<h3><a href="' . elgg_get_site_url() . 'groups/discover" title="' . elgg_echo('theme_inria:groups:discover:tooltip') . '">' . elgg_echo("theme_inria:groups:discover") . ' &nbsp; &#9654;</a></h3>';

//$group_categories = ['work' => "Métiers", 'exchange' => "Echanges & Vie pro", 'tools' => "Outils", '' => "Loisirs", 'planstrategique' => "Plan stratégique"];

$field_settings = elgg_get_entities_from_metadata(array('types' => 'object', 'subtype' => 'custom_group_field', 'metadata_names' => 'metadata_name', 'metadata_values' => 'community'));
if ($field_settings) {
	foreach($field_settings[0]->getOptions() as $community => $label) {
		if (empty($label)) { continue; }
		$community = elgg_get_friendly_title($community);
		$group_categories[$community] = $label;
	}
}

foreach($group_categories as $community => $name) {
	echo '<div class="iris-home-group-category">
		<a href="' . elgg_get_site_url() . 'groups/discover/' . $community . '">
			<img src="' . elgg_get_site_url() . 'mod/theme_inria/graphics/communities/' . $community . '_100.png" />
			<br />
			' . $name . '
		</a>
	</div>';
}


