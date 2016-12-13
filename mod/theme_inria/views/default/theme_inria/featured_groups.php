<?php
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
		//$body .= elgg_view_entity_icon($group, 'small');
		$body .= '<a href="' . $group->getURL() . '"><img src="' . $group->getIconURL('small') . '" style="margin:1px 6px 3px 0;" title="' . $group->name . '" /></a>';
	}
	elgg_pop_context();

	echo '<div id="sidebar-featured-groups">
		<h3><a href="' . elgg_get_site_url() . 'groups/all?filter=featured" title="' . elgg_echo('theme_inria:groups:featured:tooltip') . '">' . elgg_echo("inria:groups:featured") . '<span style="float:right;">&#9654;</span></a></h3>
		' . $body . '
		</div>';
}

