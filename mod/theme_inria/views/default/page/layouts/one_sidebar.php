<?php
/**
 * Layout for main column with one sidebar
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is added to the sidebar
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 * @uses $vars['class']   Additional class to apply to layout
 */

// Iris v2 : switch to custom layout if group page owner
$page_owner = elgg_get_page_owner_entity();
if (elgg_in_context('groups_add')) {
	echo elgg_view('page/layouts/iris_group_add', $vars);
	return;
} else if (elgg_instanceof($page_owner, 'group')) {
	echo elgg_view('page/layouts/iris_group', $vars);
	return;
}


$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// ESOPE : Add context class, for page differenciation
foreach(elgg_get_context_stack() as $context) {
	$class .= ' elgg-context-' . $context;
}

// navigation defaults to breadcrumbs
//$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
$nav = elgg_extract('nav', $vars, '');

// Change layout for groups - but only show if group can be seen
$owner = elgg_get_page_owner_entity();
if (elgg_instanceof($owner, 'group') && has_access_to_entity($owner)) {
	$topmenu = elgg_view('group/topmenu', array('entity' => $owner));
}
?>

<div class="<?php echo $class; ?>">
	
	<?php
	// Inria : show nav and topmenu together here, and not above
	if ($topmenu) {
		echo $nav . '<br >';
		echo $topmenu;
	}
	?>
	
	<?php
	//echo elgg_view('page/layouts/elements/header', $vars);
	//if (!empty($vars['title'])) { echo '<h2>' . $vars['title'] . '</h2>'; }
	?>
	<h2 class="invisible"><?php echo elgg_echo('accessibility:sidebar:title'); ?></h2>
	<div class="menu-sidebar-toggle"><i class="fa fa-th-large"></i> <?php echo elgg_echo('esope:menu:sidebar'); ?></div>
	<div class="elgg-sidebar">
		<?php
		if (!empty($vars['title'])) { echo '<h2>' . $vars['title'] . '</h2>'; }
		echo elgg_view('page/elements/sidebar', $vars);
		?>
	</div>

	<div class="elgg-main elgg-body">
		<?php
			if (!$topmenu) { echo $nav; }
			
			//echo elgg_view('page/layouts/elements/header', $vars);
			
			// @todo deprecated so remove in Elgg 2.0
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
			if (isset($vars['content'])) {
				echo $vars['content'];
			}
			echo elgg_view('page/layouts/elements/footer', $vars);
		?>
	</div>


</div>

