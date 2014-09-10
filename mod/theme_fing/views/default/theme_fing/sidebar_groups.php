<?php $groups = elgg_get_entities_from_metadata(array(
    'metadata_name' => 'featured_group',
    'metadata_value' => 'yes',
    'types' => 'group',
    'limit' => 0,
  ));

if ($groups) {
  elgg_push_context('widgets');
  $body = '';
  foreach ($groups as $group) {
    //$body .= elgg_view_entity_icon($group, 'small');
    $body .= '<a href="' . $group->getURL() . '" title="' . $group->name . '"><img src="' . $group->getIconURL('small') . '" style="margin:1px 6px 3px 0;" /></a>';
  }
  elgg_pop_context();

  echo '<div id="sidebar-featured-groups"><h3><a href="' . $vars['url'] . 'groups/all">' . elgg_echo("theme_fing:homegroups:featured") . '</a></h3>' . $body . '</div>';
}

