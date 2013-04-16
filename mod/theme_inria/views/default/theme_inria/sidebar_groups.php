<?php $groups = elgg_get_entities_from_metadata(array(
'metadata_name' => 'featured_group',
'metadata_value' => 'yes',
'types' => 'group',
'limit' => 10,
));

if ($groups) {

elgg_push_context('widgets');
$body = '';
foreach ($groups as $group) {
$body .= elgg_view_entity_icon($group, 'tiny');
}
elgg_pop_context();

echo '<h3><a href="' . $vars['url'] . 'groups/all" >' . elgg_echo("groups:featured") . '</a></h3>' . $body;
}



