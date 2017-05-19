<?php
/**
 * Iris v2 layout for new groups and new workspaces
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

$class = 'elgg-layout elgg-layout-group-add clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// ESOPE : Add context class, for page differenciation
foreach(elgg_get_context_stack() as $context) {
	$class .= ' elgg-context-' . $context;
}
?>

<div class="iris-group">
	
	<div class="<?php echo $class; ?>">
		<div class="iris-cols iris-group-main">
			<?php echo $vars['content']; ?>
		</div>
	</div>
	
</div>


