<?php
/**
 * Layout for main column with one sidebar
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is displayed in the sidebar
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     HTML of the page nav (override) (default: breadcrumbs)
 */

$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// Add context class, for page differenciation
global $CONFIG;
foreach ($CONFIG->context as $context) {
	$class .= ' elgg-context-' . $context;
}

// navigation defaults to breadcrumbs
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));

// Change layout for groups
$owner = elgg_get_page_owner_entity();
if (elgg_instanceof($owner, 'group')) {
	$topmenu = elgg_view('group/topmenu', array('entity' => $owner));
}
?>

<div class="<?php echo $class; ?>">
	
	<?php
	if ($topmenu) echo $nav . '<br >';
	echo $topmenu;
	?>
	
	<h2 class="invisible"><?php echo elgg_echo('accessibility:sidebar:title'); ?></h2>
	<div class="elgg-sidebar">
		<?php
			echo elgg_view('page/elements/sidebar', $vars);
		?>
	</div>

	<div class="elgg-main elgg-body">
		<?php
			if (!$topmenu) echo $nav;
			
			if (isset($vars['title'])) {
				echo elgg_view_title($vars['title']);
			}
			// @todo deprecated so remove in Elgg 2.0
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
			if (isset($vars['content'])) {
				echo $vars['content'];
			}
		?>
	</div>
</div>
