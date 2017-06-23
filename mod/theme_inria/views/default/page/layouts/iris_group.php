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
		echo elgg_view('theme_inria/groups/group_header', array('entity' => $group, 'main_group' => $main_group));
	}
	?>
	
	
	<div class="<?php echo $class; ?>">
		
		<?php
		// Left sidebar
		if (!elgg_in_context('groups_edit')) {
			if (!elgg_in_context('workspace') && !elgg_in_context('search')) {
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
		if (!empty($vars['sidebar-alt'])) {
			?>
			<div class="sidebar-alt iris-group-sidebar-alt">
				<?php echo $vars['sidebar-alt']; ?>
			</div>
			<?php
		}
		?>
		
	</div>
	
</div>


