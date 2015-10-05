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

$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// ESOPE : Add context class, for page differenciation
global $CONFIG;
foreach ($CONFIG->context as $context) {
	$class .= ' elgg-context-' . $context;
}
?>

<div class="<?php echo $class; ?>">
	<?php
	// ESOPE : nav is above main content (and group menu)
	echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
	
	// Add tab menu for groups (check view for setting))
	echo elgg_view('group/top_menu', array('entity' => $owner));
	?>
	
	<h2 class="invisible"><?php echo elgg_echo('accessibility:sidebar:title'); ?></h2>
	<div class="menu-sidebar-toggle"><i class="fa fa-bars"></i> <?php echo elgg_echo('esope:menu:sidebar'); ?></div>
	<div class="elgg-sidebar">
		<?php
			echo elgg_view('page/elements/sidebar', $vars);
		?>
	</div>

	<div class="elgg-main elgg-body">
		<?php
			echo elgg_view('page/layouts/elements/header', $vars);

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
