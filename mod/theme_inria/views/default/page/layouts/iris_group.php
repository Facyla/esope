<?php
/**
 * Iris v2 layout for groups and content display in group
 * Home page + edit + workspaces : interface with header and left sidebar
 * Other in-group pages : raw interface without header
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is added to the sidebar
 * @uses $vars['sidebar-alt'] Optional content that is added to the 2nd sidebar
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 * @uses $vars['class']   Additional class to apply to layout
 */

$class = 'elgg-layout elgg-layout-group clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// ESOPE : Add context class, for page differenciation
foreach(elgg_get_context_stack() as $context) {
	$class .= ' elgg-context-' . $context;
}

// navigation defaults to breadcrumbs
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));


// Change layout for groups - but only show if group can be seen
// Determine main group and current workspace (subgroup)
$group = elgg_get_page_owner_entity();
if (!elgg_instanceof($group, 'group')) { forward(); }

$main_group = theme_inria_get_main_group($group);

// Espaces de travail : groupe principal + sous-groupes
// Note : on prend tous les sous-groupes qq soit le niveau - mais on ne pourra créer de nouveaux sous-groupes qu'au 1er niveau
//$group = AU\SubGroups\get_subgroups($group, 0);
$all_subgroups_guids = AU\SubGroups\get_all_children_guids($main_group);



// Home page + edit (if guid) + members, invites, workspaces : interface with header and left sidebar
// Other in-group pages : raw interface without header
$url = elgg_get_site_url();

// There may be no page owner (eg. new group)
$has_group_layout = get_input('group_layout_header', false);
if ($has_group_layout != 'yes') { $has_group_layout = false; } else { $has_group_layout = true; }

// @TODO group operators should use group layout

/*
if (elgg_instanceof($group, 'group')) {
	switch(current_page_url()) {
		case $group->getURL():
		case $url.'groups/invite/' . $group->guid:
		case $url.'groups/members/' . $group->guid:
		case $url.'groups/edit/' . $group->guid:
		case $group:
			$has_group_layout = true;
			break;
		default:
			//$has_group_layout = false;
	}
}
*/


?>
<div class="iris-group">
	
	<?php
	if ($has_group_layout) {
		$banner_css = '#424B5F';
		if (!empty($user->banner)) {
			//$banner_css = "linear-gradient(rgba(66, 75, 95, 0.45), rgba(66, 75, 95, 0.45)), #424B5F url('{$url}groups/file/{$group->guid}/banner') no-repeat center/cover";
			$banner_css = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), #424B5F url('{$url}groups/file/{$group->guid}/banner') no-repeat center/cover";
		}
		?>
		<div class="iris-group-header" style="background: <?php echo $banner_css; ?>;">
			
			<div class="iris-group-image" style="background: white url('<?php echo $group->getIconURL(array('size' => 'large')); ?>') no-repeat center/cover;"></div>
			
			<div class="iris-group-title">
				<?php
				echo '<div class="iris-group-community">';
				if (!empty($group->community)) { echo elgg_echo('community') . ' ' . $group->community; }
				echo '</div>';
				echo '<h2>' . $group->name . '</h2>';
				echo '<div class="iris-group-subtitle">' . $group->briefdescription . '</div>';
				echo '<div class="iris-group-rules">';
					// Access
					echo '<span class="group-access">' .elgg_echo('theme_inria:access:groups') . '&nbsp;: ' . elgg_view('output/access', array('entity' => $group)) . '</span>';
					echo ' - ';
					// Membership
					echo elgg_echo('theme_inria:groupmembership') . '&nbsp;: ';
					if ($group->membership == ACCESS_PUBLIC) {
						echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . ' - ' . elgg_echo("theme_inria:groupmembership:open:details");
					} else {
						echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . ' - ' . elgg_echo("theme_inria:groupmembership:closed:details");
					}
					echo '</span>';
				echo '</div>';
				?>
			</div>
			
			<div class="iris-group-menu">
				<?php
				// Espaces de travail : si > 3 onglets, on en affiche 2 et le reste en sous-menu + limitation longueur du titre
				$max_title = 30;
				$max_title_more = 50;
				$more_tabs_threshold = 1; // Tabs in addition to main workspace tab (index)
				$add_more_tab = (sizeof($all_subgroups_guids) > $more_tabs_threshold+1);
				$more_tabs = '';
				$more_selected = false;
				
				// Current group home page
				if (current_page_url() == $group->getURL()) {
					echo '<a href="' . $group->getURL() . '" class="tab elgg-state-selected">' . elgg_echo('theme_inria:group:presentation') . '</a>';
				} else {
					echo '<a href="' . $group->getURL() . '" class="tab">' . elgg_echo('theme_inria:group:presentation') . '</a>';
				}
				
				// Main workspace
				$tab_class = '';
				if (($main_group->guid == $group->guid) && (current_page_url() != $group->getURL())) { $tab_class .= " elgg-state-selected"; }
				echo '<a href="' . $url . 'groups/workspace/' . $main_group->guid . '" class="tab' . $tab_class . '" title="' . $main_group->name . '">' . elgg_get_excerpt($main_group->name, $max_title) . '</a>';
				
				// Workspaces
				if (current_page_url() == $group->getURL()) {
					if ($all_subgroups_guids) {
						foreach($all_subgroups_guids as $k => $guid) {
							$ent = get_entity($guid);
							if ($add_more_tab && ($k >= $more_tabs_threshold)) {
								$more_tabs .= '<a href="' . $url . 'groups/workspace/' . $ent->guid . '" class="tab" title="' . $ent->name . '">' . elgg_get_excerpt($ent->name, $max_title_more) . '</a>';
							} else {
								echo '<a href="' . $url . 'groups/workspace/' . $ent->guid . '" class="tab" title="' . $ent->name . '">' . elgg_get_excerpt($ent->name, $max_title) . '</a>';
							}
						}
					}
				} else {
					// Workspaces
					if ($all_subgroups_guids) {
						foreach($all_subgroups_guids as $k => $guid) {
							$ent = get_entity($guid);
							$workspace_url = $url . 'groups/workspace/' . $ent->guid;
							$tab_class = '';
							if ($ent->guid == $group->guid) { $tab_class .= " elgg-state-selected"; $more_selected = true; }
							$title_excerpt = elgg_get_excerpt($ent->name, $max_title);
							if ($add_more_tab && ($k >= $more_tabs_threshold)) {
								$title_excerpt = elgg_get_excerpt($ent->name, $max_title_more);
								$more_tabs .= '<a href="' . $workspace_url . '" class="tab' . $tab_class . '" title="' . $ent->name . '">' . $title_excerpt . '</a>';
							} else {
								echo '<a href="' . $workspace_url . '" class="tab' . $tab_class . '" title="' . $ent->name . '">' . $title_excerpt . '</a>';
							}
						}
					}
				}
				if ($add_more_tab) {
					if ($more_selected) {
						echo '<span class="tab tab-more active">';
					} else {
						echo '<span class="tab tab-more">';
					}
					echo '<a href="javascript:void(0);" onClick="javascript:$(\'.iris-group-menu .tab-more-content\').toggleClass(\'hidden\')">' . elgg_echo('theme_inria:workspaces:more', array((sizeof($all_subgroups_guids) - $more_tabs_threshold))) . '</a>
							<div class="tab-more-content hidden">' . $more_tabs . '</div>
					</span>';
				}
				
				// Group search
				if (elgg_is_active_plugin('search')) {
					echo '<a href="' . $group->getURL() . '" class="search float-alt"><i class="fa fa-search"></i></a>';
				}
				
				// New subgroup (of level 1)
				echo '<a href="' . $url . 'groups/subgroups/add/' . $main_group->guid . '" class="add float-alt">+&nbsp;' . elgg_echo('theme_inria:group:workspace:add') . '</a>';
				?>
			</div>
			
		</div>
		
		<?php
	}
	?>
	
	
	<div class="<?php echo $class; ?>">
		
		<?php
		// Left sidebar
		if (!elgg_in_context('groups_edit')) {
			if (!elgg_in_context('workspace')) {
				if ($has_group_layout) {
					$vars['sidebar'] = elgg_view('theme_inria/groups/sidebar', $vars);
				} else {
					// Existing sidebar is wrapped into new sidebar (until sidebar is fully integrated)
					$vars['sidebar'] = elgg_view('theme_inria/groups/sidebar_content', $vars);
				}
			}
			if ($vars['sidebar']) { echo $vars['sidebar']; }
		}
		
		
		// Main content
		echo '<div class="elgg-main elgg-body">';
			// Retour vers page listing
			if (!$has_group_layout && !elgg_in_context('group_content')) {
				echo '<div class="group-content-back">';
					// Plein écran
					echo '<a href="javascript:void(0);" onClick="javascript:$(\'body\').toggleClass(\'full-screen\')" class="elgg-button elgg-button-action float-alt">' . '<i class="fa fa-arrows-alt"></i>' . '</a>';
					$subtype_context = elgg_get_context();
					if ($subtype_context == 'event_calendar:view') { $subtype_context = 'event_calendar'; }
					$back_list_url = $url . 'groups/content/' . $group->guid . '/' . $subtype_context . '/all';
					// Edition d'un contenu : retour vers affichage (bouton croix)
					$current_guid = get_input('guid');
					$current_entity = get_entity($current_guid);
					if (elgg_instanceof($current_entity, 'object')) {
						$back_entity_url = $current_entity->getURL();
						if (current_page_url() != $back_entity_url) {
							echo '<a href="' . $back_entity_url . '" class="back"><i class="fa fa-caret-left"></i> &nbsp; ' . elgg_echo('theme_inria:backtocontent') . '</a>';
						} else {
							// Retour au listing
							echo '<a href="' . $back_list_url . '" class="back"><i class="fa fa-caret-left"></i> &nbsp; ' . elgg_echo('theme_inria:backtocontents') . '</a>';
						}
					} else {
						// Retour au listing
						echo '<a href="' . $back_list_url . '" class="back"><i class="fa fa-caret-left"></i> &nbsp; ' . elgg_echo('theme_inria:backtocontents') . '</a>';
						// Nouvelle publication
						// @TODO
						//echo '<a href="" class="add elgg-button elgg-button-action float-alt">' . elgg_echo('create') . '</a>';
					}
					echo '<div class="clearfloat"></div>';
				echo '</div>';
			}
			
			if (isset($vars['content'])) { echo $vars['content']; }
			echo elgg_view('page/layouts/elements/footer', $vars);
		echo '</div>';
		
		
		// Right sidebar
		if ($vars['sidebar-alt']) {
			?>
			<div class="sidebar-alt iris-group-sidebar-alt">
				<div class="iris-sidebar-content">
					<?php echo $vars['sidebar-alt']; ?>
				</div>
			</div>
			<?php
		}
		?>
		
	</div>
	
</div>


