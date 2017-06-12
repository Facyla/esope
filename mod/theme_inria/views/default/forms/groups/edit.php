<?php
/**
 * Group edit form
 *
 * @package ElggGroups
 */

/* @var ElggGroup $entity */
$entity = elgg_extract("entity", $vars, false);

// context needed for input/access view
elgg_push_context("group-edit");

// build the group profile fields
$profile_fields = elgg_view("groups/edit/profile", $vars);

// build the group access options
$access_fields = elgg_view("groups/edit/access", $vars);

// build the group tools options
$tools_fields = elgg_view("groups/edit/tools", $vars);

// display the save button and some additional form data
$form_footer = '<div class="elgg-foot">';

if ($entity) {
	$form_footer .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $entity->getGUID()));
}

$form_footer .= elgg_view("input/submit", array("value" => elgg_echo("save"), 'class' => "elgg-button elgg-button-submit float-alt"));
$form_footer .= '<div class="clearfloat"></div>';

if ($entity) {
	$form_footer .= '<div class="iris-group-delete">';
		$form_footer .= '<div class="group-delete-label">';
			$form_footer .= '<h3>' . elgg_echo('theme_inria:group:delete') . '</h3>';
			$form_footer .= '<p>' . elgg_echo('theme_inria:group:delete:details') . '</p>';
		$form_footer .= '</div>';
	
		$delete_url = "action/groups/delete?guid=" . $entity->getGUID();
		$form_footer .= elgg_view("output/url", array(
			"text" => elgg_echo("groups:delete"),
			"href" => $delete_url,
			"confirm" => elgg_echo("groups:deletewarning"),
			"class" => "elgg-button elgg-button-delete float-alt",
		));
	$form_footer .= '</div>';
}
$form_footer .= '</div>';

elgg_pop_context();


// Use custom layout for new groups
if (elgg_instanceof($entity, 'group')) {
	echo $profile_fields . $access_fields . $tools_fields . $form_footer;
	return;
}



$icon_field = '<label for="icon">
		<i class="fa fa-camera"></i><br />' . elgg_echo('groups:icon:inline') . '
	</label>';
$banner_field = '<label for="banner">
		<i class="fa fa-camera"></i><br />' . elgg_echo('groups:banner:inline') . '
	</label>';


echo <<<HTML
<div class="iris-cols form-groups-add">

	<div class="sidebar iris-group-sidebar">
		<div class="iris-sidebar-content">
			$icon_field
		</div>
	</div>

	<div class="elgg-main">
		$profile_fields
		$access_fields
		$tools_fields
		$form_footer
	</div>

	<div class="sidebar-alt iris-group-sidebar-alt">
		<div class="iris-group-image-input">
			$banner_field
		</div>
	</div>

</div>
HTML;

