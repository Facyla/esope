<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 

$group = $vars['entity'];
$url = elgg_get_site_url();

// ESOPE : disable widget tools if asked too
$disable_widgets = false;
$disable_group_widgets = elgg_get_plugin_setting('groups_disable_widgets', 'adf_public_platform');
if (elgg_is_logged_in()) {
	if (in_array($disable_group_widgets, array('yes', 'both', 'loggedin'))) { $disable_widgets = true; }
} else {
	if (in_array($disable_group_widgets, array('yes', 'both', 'public'))) { $disable_widgets = true; }
}

// Define a custom group homepage for Pôle group (only)
$pole = theme_afparh_is_pole($group);
if ($pole) {
	// Groupes du Pôle - Get pole workgroups and GUIDs
	$workgroups = theme_afparh_get_pole_groups($pole, true); // Work groups only
	$group_guids = theme_afparh_get_pole_groups_guids($pole); // Tous les groupes du Pôle (y compris Pôle et Départements)
	
	// Tabs <=> rubrique dans l'accueil du groupe (publish|groups)
	$rubrique = get_input('rubrique', false);
	switch($rubrique) {
		
		case 'publish':
			$content .= '<div id="group-tool-tabs">';
			$add_form = true;
			// ESOPE : add publication tools if asked
			if ($group->blog_enable == 'yes') {
				if ($add_form) $content .= '<a href="javascript:void(0);" onclick="javascript:$(\'.group-tool-tab-content\').hide(); $(\'#group-tool-tab-blog\').toggle();" ';
				else $content .= '<a href="' . $url . 'blog/add/' . $group->guid . '"';
				$content .= ' class="group-tool-tab" title="' . elgg_echo('blog:add') . '">' . elgg_echo('esope:icon:blog');
				if ($add_text) $content .= '<br />' . elgg_echo('blog:add');
				$content .=  '</a>';
				$tabs[] = $content;
				if ($add_form) $add_forms .= '<div class="group-tool-tab-content" id="group-tool-tab-blog" style="display:none;"><h3>' . elgg_echo('blog:add') . '</h3>' . elgg_view_form('blog/save', $vars) . '</div>';
			}
			if ($group->file_enable == 'yes') {
				if ($add_form) $content .= '<a href="javascript:void(0);" onclick="javascript:$(\'.group-tool-tab-content\').hide(); $(\'#group-tool-tab-file\').toggle();" ';
				else $content .= '<a href="' . $url . 'file/add/' . $group->guid . '"';
				$content .= ' class="group-tool-tab" title="' . elgg_echo('file:add') . '">' . elgg_echo('esope:icon:file');
				if ($add_text) $content .= '<br />' . elgg_echo('file:add');
				$content .=  '</a>';
				$tabs[] = $content;
				if ($add_form) $add_forms .= '<div class="group-tool-tab-content" id="group-tool-tab-file" style="display:none;"><h3>' . elgg_echo('file:add') . '</h3>' . elgg_view_form('file/upload', $vars) . '</div>';
			}
			if ($group->bookmarks_enable == 'yes') {
				if ($add_form) $content .= '<a href="javascript:void(0);" onclick="javascript:$(\'.group-tool-tab-content\').hide(); $(\'#group-tool-tab-bookmarks\').toggle();" ';
				else $content .= '<a href="' . $url . 'bookmarks/add/' . $group->guid . '"';
				$content .= ' class="group-tool-tab" title="' . elgg_echo('bookmarks:add') . '">' . elgg_echo('esope:icon:bookmarks');
				if ($add_text) $content .= '<br />' . elgg_echo('bookmarks:add');
				$content .=  '</a>';
				$tabs[] = $content;
				if ($add_form) $add_forms .= '<div class="group-tool-tab-content" id="group-tool-tab-bookmarks" style="display:none;"><h3>' . elgg_echo('bookmarks:add') . '</h3>' . elgg_view_form('bookmarks/save', $vars) . '</div>';
			}
			$content .= '<div class="clearfloat"></div>';
			$content .= $add_forms;
			$content .= '</div>';
			
			// Dernières publications déposées dans le Pôle
			$content .= '<h3>' . elgg_echo('theme_afparh:pole:publications') . '</h3>';
			elgg_push_context('widgets');
			$content .= elgg_list_entities(array('type' => 'object', 'container_guids' => $group_guids, 'limit' => 10, 'pagination' => true, 'full_view' => false));
			//$content .= elgg_list_entities(array('type' => 'object', 'container_guids' => $group->guid, 'limit' => 5, 'pagination' => true, 'full_view' => false));
			elgg_pop_context();
			break;
		
		case 'groups':
			// Groupes du Pôle
			$content .= elgg_view('cmspages/view', array('pagetype' => 'aide-creer-groupe-de-travail'));
			$content .= '<p><a href="' . $url . 'groups/add/' . elgg_get_logged_in_user_guid() . '?poles_rh=' . $pole . '" class="elgg-button elgg-button-action">' . elgg_echo('theme_afparh:groups:new') . '</a></p>';
			$content .= '<br />';
			$content .= '<h3>' . elgg_echo('theme_afparh:pole:groups') . '</h3>';
			$groups_params = $vars;
			foreach ($workgroups as $ent) {
				$groups_params['entity'] = $ent;
				elgg_push_context('search');
				$content .= '<div class="groups-pole-group">' . elgg_view_entity($ent);
				$content .= elgg_view('group/elements/group_admins', $groups_params);
				$content .= '</div>';
				elgg_pop_context();
			}
			break;
		
		default:
			// Présentation et activité récente du Pôle
			$content .= '<h3>' . elgg_echo('theme_afparh:pole:news') . '</h3>';
			$db_prefix = elgg_get_config('dbprefix');
			if ($group_guids) {
				$pole_group_in = implode(',', $group_guids);
				$content .= elgg_list_river(array(
						'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
						'wheres' => array("(e1.container_guid IN ($pole_group_in))"),
						//'wheres' => array("(e1.container_guid = {$group->guid})"),
						'limit' => 10, 'pagination' => true,
					));
			}
			/*
			// Dernières publications déposées dans le Pôle
			$content .= '<h3>' . elgg_echo('theme_afparh:pole:publications') . '</h3>';
			elgg_push_context('widgets');
			$content .= elgg_list_entities(array('type' => 'object', 'container_guids' => $group_guids, 'limit' => 10, 'pagination' => true, 'full_view' => false));
			elgg_pop_context();
			*/
	}
	$content .= '<div class="clearfloat"></div>';
	$content .= '<br />';
	
	echo $content;
	
} else {
	// Esope-setting default behaviour
	
	// tools widget area
	echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';
	
	if (!$disable_widgets) {
		// enable tools to extend this area
		echo elgg_view("groups/tool_latest", $vars);
	}

	// backward compatibility
	$right = elgg_view('groups/right_column', $vars);
	$left = elgg_view('groups/left_column', $vars);
	if ($right || $left) {
		elgg_deprecated_notice('The views groups/right_column and groups/left_column have been replaced by groups/tool_latest', 1.8);
		echo $left;
		echo $right;
	}
	echo "</ul>";

	// ESOPE : add publication tools if asked
	echo elgg_view('groups/profile/group_publish_tools', $vars);

	// ESOPE : add activity if asked
	echo elgg_view('groups/profile/group_activity', $vars);
}


