<?php

/**
 * Group edit form
 *
 * This view contains everything related to group access.
 * eg: how can people join this group, who can see the group, etc
 *
 * @package ElggGroups
 */

$entity = elgg_extract("entity", $vars, false);
$membership = elgg_extract("membership", $vars);
$visibility = elgg_extract("vis", $vars, ACCESS_DEFAULT);
$owner_guid = elgg_extract("owner_guid", $vars);
$content_access_mode = elgg_extract("content_access_mode", $vars);
// Iris : force default mode on restricted
if (!$entity) { $content_access_mode = ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY; }
// ESOPE : set default visibility to site default (instead of always public)
if (!elgg_instanceof($entity, 'group')) { $visibility = ACCESS_DEFAULT; }

// Iris : allow values that are neither Public/Members/Private (corrects behaviour from groups lib function : groups_prepare_form_vars)
// To allow *any* access level for groups, simply align visibility to access_id...
//$inria_access_id = theme_inria_get_inria_access_id();
//if (($visibility === 0) && ($entity->access_id == $inria_access_id)) { $visibility = $inria_access_id; }
if (($visibility === 0) && ($entity->access_id != $visibility)) { $visibility = $entity->access_id; }

//Iris v2 : workspaces
$translation_prefix = '';
$parent_group = elgg_extract("au_subgroup_of", $vars);
//if ($parent_group) { $translation_prefix = 'workspace:'; }

$opengroups_defaultaccess = elgg_get_plugin_setting('opengroups_defaultaccess', 'esope');
$closedgroups_defaultaccess = elgg_get_plugin_setting('closedgroups_defaultaccess', 'esope');
$open_default_access = elgg_echo('esope:groupdefaultaccess:' . $opengroups_defaultaccess);
$closed_default_access = elgg_echo('esope:groupdefaultaccess:' . $closedgroups_defaultaccess);


?>
<div class="groups-edit-field">
	<div class="groups-edit-label">
		<label for="groups-membership"><?php echo elgg_echo($translation_prefix."groups:membership"); ?></label>
	</div>
	<div class="groups-edit-input">
		<?php echo elgg_view("input/select", array(
			"name" => "membership",
			"id" => "groups-membership",
			"value" => $membership,
			"options_values" => array(
				ACCESS_PRIVATE => elgg_echo($translation_prefix."groups:access:private"),
				ACCESS_PUBLIC => elgg_echo($translation_prefix."groups:access:public"),
			)
		));
		?>
	</div>
</div>

<?php
// Group visibility
if (elgg_get_plugin_setting("hidden_groups", "groups") == "yes") {
	?>
	<div class="groups-edit-field">
		<div class="groups-edit-label">
			<label for="groups-vis"><?php echo elgg_echo($translation_prefix."groups:visibility"); ?></label>
		</div>
		<div class="groups-edit-input">
			<?php
			$visibility_options =  array(
				ACCESS_PRIVATE => elgg_echo($translation_prefix."groups:access:group"),
				ACCESS_LOGGED_IN => elgg_echo($translation_prefix."LOGGED_IN"),
				ACCESS_PUBLIC => elgg_echo($translation_prefix."PUBLIC"),
			);
			$inria_access_id = theme_inria_get_inria_access_id();
			if ($inria_access_id) {
				$visibility_options[$inria_access_id] = elgg_echo('profiletype:inria');
			}
			if (elgg_get_config("walled_garden")) {
				unset($visibility_options[ACCESS_PUBLIC]);
			}
		
			echo elgg_view("input/access", array(
				"name" => "vis",
				"id" => "groups-vis",
				"value" => $visibility,
				"options_values" => $visibility_options,
				'entity' => $entity,
				'entity_type' => 'group',
				'entity_subtype' => '',
			));
			echo '<span class="elgg-text-help">' . elgg_echo('Lorsque la visibilité du groupe est limitée aux membres du groupe (groupe privé), la visibilité des nouveaux contenus est forcée sur "Membres du groupe seulement".') . '</span>';
			?>
		</div>
	</div>
	<?php
}



// New content visibility
$access_mode_params = array(
	"name" => "content_access_mode",
	"id" => "groups-content-access-mode",
	"value" => $content_access_mode,
	"options_values" => array(
		ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY => elgg_echo($translation_prefix."groups:content_access_mode:membersonly"),
		ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED => elgg_echo($translation_prefix."groups:content_access_mode:unrestricted"),
	)
);
if ($entity) {
	if ($entity->getContentAccessMode() == ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED) {
		$access_mode_params['options_values'][ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY] .= ' &rarr; ' . $open_default_access;
	} else {
		$access_mode_params['options_values'][ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY] .= ' &rarr; ' . $closed_default_access;
	}
}
	
if ($entity) {
	// Disable content_access_mode field for hidden groups because the setting
	// will be forced to members_only regardless of the entered value
	if ($entity->access_id === $entity->group_acl) {
		$access_mode_params['disabled'] = 'disabled';
	}
}
?>
<div class="groups-edit-field">
	<div class="groups-edit-label">
		<label for="groups-content-access-mode"><?php echo elgg_echo($translation_prefix."groups:content_access_mode"); ?></label>
	</div>
	<div class="groups-edit-input">
		<?php
		echo elgg_view("input/select", $access_mode_params);

		echo '<span class="elgg-text-help">' . elgg_echo('groups:content_access_mode:details', array($open_default_access, $closed_default_access)) . '</span>';
		if ($entity && $entity->getContentAccessMode() == ElggGroup::CONTENT_ACCESS_MODE_UNRESTRICTED) {
			// Warn the user that changing the content access mode to more
			// restrictive will not affect the existing group content
			$access_mode_warning = elgg_echo($translation_prefix."groups:content_access_mode:warning");
			echo "<span class='elgg-text-help'>$access_mode_warning</span>";
		}
		?>
	</div>
</div>

<?php

if ($entity && ($owner_guid == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())) {
	$members = array();

	$options = array(
		"relationship" => "member",
		"relationship_guid" => $entity->getGUID(),
		"inverse_relationship" => true,
		"type" => "user",
		"limit" => 0,
	);

	$batch = new ElggBatch("elgg_get_entities_from_relationship", $options);
	foreach ($batch as $member) {
		$option_text = "$member->name (@$member->username)";
		$members[$member->guid] = htmlspecialchars($option_text, ENT_QUOTES, "UTF-8", false);
	}
	?>

	<div class="groups-edit-field">
		<div class="groups-edit-label">
			<label for="groups-owner-guid"><?php echo elgg_echo($translation_prefix."groups:owner"); ?></label>
		</div>
		<div class="groups-edit-input">
			<?php
			echo elgg_view("input/select", array(
				"name" => "owner_guid",
				"id" => "groups-owner-guid",
				"value" =>  $owner_guid,
				"options_values" => $members,
				"class" => "groups-owner-input",
			));

			if ($owner_guid == elgg_get_logged_in_user_guid()) {
				echo "<span class='elgg-text-help'>" . elgg_echo($translation_prefix."groups:owner:warning") . "</span>";
			}
		?>
		</div>
	</div>
<?php
}
