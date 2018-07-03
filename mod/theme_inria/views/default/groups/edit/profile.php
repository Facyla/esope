<?php
/**
* Profile Manager
*
* Overrules group edit form to support options (radio, dropdown, multiselect)
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$group = elgg_extract("entity", $vars);

//Iris v2 : workspaces
$translation_prefix = '';
$parent_group = elgg_extract("au_subgroup_of", $vars);
if ($parent_group) { $translation_prefix = 'workspace:'; }
$workspace_exclude_fields = array('community', 'briefdescription');

$name_limit = elgg_get_plugin_setting("group_limit_name", "profile_manager");
$description_limit = elgg_get_plugin_setting("group_limit_description", "profile_manager");

if (!elgg_instanceof($group, 'group')) {
	echo '<h3>' . elgg_echo($translation_prefix.'groups:about') . '</h3>';
} else {
	$workspace_name = $group->workspace_name;
	$operators_edit_only = $group->operators_edit_only;
}



if (!$parent_group) {
	echo '<div class="groups-edit-field">
		<div class="groups-edit-label">
			<label>' . elgg_echo($translation_prefix."groups:banner") . '</label>
		</div>
		<div class="groups-edit-input">
			' . elgg_view("input/file", array("name" => "banner")) . '
		</div>
	</div>';
}

if (!$parent_group) {
	echo '<div class="groups-edit-field">';
		echo '<div class="groups-edit-label">';
			echo "<label>" . elgg_echo($translation_prefix."groups:icon") . "</label>";
		echo '</div>';
		echo '<div class="groups-edit-input">';
			echo elgg_view("input/file", array('name' => 'icon'));
		echo '</div>';
	echo '</div>';
}

echo '<div class="groups-edit-field">';
	echo '<div class="groups-edit-label">';
		echo "<label>" . elgg_echo($translation_prefix."groups:name") . "</label>";
	echo '</div>';
	echo '<div class="groups-edit-input">';
			$show_input = false;
			if (empty($group) || ($name_limit === NULL) || ($name_limit === "") || elgg_is_admin_logged_in()) { $show_input = true; }
			if (!$show_input && !empty($group) && (!empty($name_limit) || ($name_limit == "0"))) {
				$name_limit = (int) $name_limit;
				$name_edit_count = (int) $group->getPrivateSetting("profile_manager_name_edit_count");
				if ($name_edit_count < $name_limit) { $show_input = true; }
				$name_edit_num_left = $name_limit - $name_edit_count;
			}
			if ($show_input) {
				echo elgg_view("input/text", array('name' => 'name', 'value' => elgg_extract('name', $vars), 'required' => true));
				if (!empty($name_edit_num_left)) {
					echo "<div class='elgg-subtext'>" . elgg_echo($translation_prefix."profile_manager:group:edit:limit", array("<strong>" . $name_edit_num_left . "</strong>")) . "</div>";
				}
			} else {
				// show value
				echo elgg_view("output/text", array('value' => elgg_extract('name', $vars)));
	
				// add hidden so it gets saved and form checks still are valid
				echo elgg_view("input/hidden", array('name' => 'name', 'value' => elgg_extract('name', $vars)));
			}
	echo '</div>';
echo '</div>';

// Workspace title (main group only)
if (!$parent_group) {
	echo '<div class="groups-edit-field">';
		echo '<div class="groups-edit-label">';
			echo "<label>" . elgg_echo("groups:workspace_name") . "</label>";
		echo '</div>';
		echo '<div class="groups-edit-input">';
				echo elgg_view("input/text", array('name' => 'workspace_name', 'value' => $workspace_name, 'placeholder' => elgg_echo('theme_inria:workspace:main')));
				echo '<br /><em>' . elgg_echo('groups:workspace_name:details') . '</em>';
		echo '</div>';
	echo '</div>';
}


// Option so operators only can publish in group (main group only)
if (!$parent_group) {
	echo '<div class="groups-edit-field">';
		echo '<div class="groups-edit-label">';
			echo "<label>" . elgg_echo("groups:operators_edit_only") . "</label>";
		echo '</div>';
		echo '<div class="groups-edit-input">';
				echo elgg_view("input/select", array('name' => 'operators_edit_only', 'value' => $operators_edit_only, 'options_values' => ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')]));
				echo '<br /><em>' . elgg_echo('groups:operators_edit_only:details') . '</em>';
		echo '</div>';
	echo '</div>';
}



// retrieve group fields
$group_fields = profile_manager_get_categorized_group_fields();

if (count($group_fields["fields"]) > 0) {
	$group_fields = $group_fields["fields"];
	
	foreach ($group_fields as $field) {
		$metadata_name = $field->metadata_name;
		
		// Exclude fields that are not relevant for workspaces
		if ($parent_group && in_array($metadata_name, $workspace_exclude_fields)) { continue; }
		
		// get options
		$options = $field->getOptions();
		$placeholder = $field->getPlaceholder();
		
		// get type of field
		$valtype = $field->metadata_type;
		
		// get title
		$title = $field->getTitle();
		if ($field->metadata_name == $field->getTitle()) {
			$title = elgg_echo($field->getTitle());
		}
		
		// get value
		$value = elgg_extract($metadata_name, $vars);
		
		echo '<div class="groups-edit-field">';
		
		// Label and hints
		echo '<div class="groups-edit-label">';
			echo '<label>' . $title . "</label>";
		
		// Use translated hints first
		$translated_hint = theme_inria_get_translation('groups:hint:'.$metadata_name);
		if ($translated_hint) {
			echo '<span class="custom_fields_more_info" id="more_info_' . $metadata_name . '"></span>';
			echo '<span class="hidden" id="text_more_info_' . $metadata_name . '">' . $translated_hint . '</span>';
		} else if ($hint = $field->getHint()) {
			echo '<span class="custom_fields_more_info" id="more_info_' . $metadata_name . '"></span>';
			echo '<span class="hidden" id="text_more_info_' . $metadata_name . '">' . $hint . '</span>';
		}
		echo '</div>';
		
		// Input
		echo '<div class="groups-edit-input">';
		$field_output_options = array(
			'name' => $metadata_name,
			'value' => $value,
		);

		if ($options) {
			$field_output_options['options'] = $options;
		}

		if ($placeholder) {
			$field_output_options['placeholder'] = $placeholder;
		}

		if ($metadata_name == "description") {
		
			$show_input = false;
			if (empty($group) || ($description_limit === NULL) || ($description_limit === "") || elgg_is_admin_logged_in()) {
				$show_input = true;
			}
			
			$edit_num_left = 0;
			
			if (!$show_input && !empty($group) && (!empty($description_limit) || ($description_limit == "0"))) {
				$description_limit = (int) $description_limit;
				$field_edit_count = (int) $group->getPrivateSetting("profile_manager_description_edit_count");
			
				if ($field_edit_count < $description_limit) {
					$show_input = true;
				}
				
				$edit_num_left = $description_limit - $field_edit_count;
			}
			
			if ($show_input) {
				// Editeur simplifié pour les EDT
				//if ($parent_group) { $valtype = 'plaintext'; }
				if ($parent_group) { $field_output_options['class'] = 'elgg-input-longtext-basic'; }
				echo '<div class="groups-edit-input">';
				echo elgg_view("input/{$valtype}", $field_output_options);
				
				if (!empty($edit_num_left)) {
					echo "<div class='elgg-subtext'>" . elgg_echo($translation_prefix."profile_manager:group:edit:limit", array("<strong>" . $edit_num_left . "</strong>")) . "</div>";
				}
				echo '</div>';
			} else {
				// show value
				echo elgg_view("output/{$valtype}", array('value' => $value, 'required' => true));
					
				// add hidden so it gets saved and form checks still are valid
				echo elgg_view("input/hidden", array('name' => $metadata_name, 'value' => $value));
			}
		} else {
			echo elgg_view("input/{$valtype}", $field_output_options);
		}
		
		echo '</div>';
		
		echo '</div>';
	}
}
