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
		?>
		<div class="iris-group-header" style="background: #424B5F url('<?php echo $url . 'groups/file/'.$group->guid.'/banner'; ?>') no-repeat center/cover;">
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
				if (current_page_url() == $group->getURL()) {
					echo '<a href="' . $group->getURL() . '" class="elgg-state-selected">' . elgg_echo('theme_inria:group:presentation') . '</a>';
					echo '<a href="' . $url . 'groups/workspace/' . $main_group->guid . '" class="">' . $main_group->name . '</a>';
					if ($all_subgroups_guids) {
						foreach($all_subgroups_guids as $guid) {
							$ent = get_entity($guid);
							echo '<a href="' . $url . 'groups/workspace/' . $ent->guid . '" class="">' . $ent->name . '</a>';
						}
					}
				} else {
					echo '<a href="' . $group->getURL() . '" class="">' . elgg_echo('theme_inria:group:presentation') . '</a>';
					if ($main_group->guid == $group->guid) {
						echo '<a href="' . $url . 'groups/workspace/' . $main_group->guid . '" class="elgg-state-selected">' . $main_group->name . '</a>';
					} else {
						echo '<a href="' . $url . 'groups/workspace/' . $main_group->guid . '" class="">' . $main_group->name . '</a>';
					}
					if ($all_subgroups_guids) {
						foreach($all_subgroups_guids as $guid) {
							$ent = get_entity($guid);
							if ($ent->guid == $group->guid) {
								echo '<a href="' . $url . 'groups/workspace/' . $ent->guid . '" class="elgg-state-selected">' . $ent->name . '</a>';
							} else {
								echo '<a href="' . $url . 'groups/workspace/' . $ent->guid . '" class="">' . $ent->name . '</a>';
							}
						}
					}
				}
				// Group search
				if (elgg_is_active_plugin('search')) {
					echo '<a href="' . $group->getURL() . '" class="float-alt"><i class="fa fa-search"></i></a>';
				}
				// New subgroup (of level 1)
				echo '<a href="' . $url . 'groups/subgroups/add/' . $main_group->guid . '" class="float-alt">' . elgg_echo('theme_inria:group:workspace:add') . '</a>';
				?>
			</div>
		</div>
		<?php
	}
	?>
	
	
	<div class="<?php echo $class; ?>">
		
		<?php if ($has_group_layout) {
			
			if (empty($vars['sidebar'])) { $vars['sidebar'] = elgg_view('theme_inria/groups/sidebar', $vars); }
			if ($vars['sidebar']) { echo $vars['sidebar']; }
		
			echo '<div class="elgg-main elgg-body">';
				if (isset($vars['content'])) { echo $vars['content']; }
				echo elgg_view('page/layouts/elements/footer', $vars);
			echo '</div>';
			
			if ($vars['sidebar-alt']) {
				?>
				<div class="sidebar-alt iris-group-sidebar-alt">
					<div class="iris-sidebar-content">
						<?php echo $vars['sidebar-alt']; ?>
					</div>
				</div>
				<?php
			}
		
		} else {
			
			echo '<div class="iris-cols iris-group-main">';
			if (isset($vars['content'])) { echo $vars['content']; }
			echo '</div>';
		}
		?>
		
	</div>
	
</div>


