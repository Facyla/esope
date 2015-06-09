<?php
/**
 * Elgg one-column layout
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 */

$class = 'elgg-layout elgg-layout-one-column clearfix';
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
	// ESOPE : nav is above main content
	echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
	?>
	<div class="elgg-body elgg-main">
	<?php
		echo elgg_view('page/layouts/elements/header', $vars);

		echo $vars['content'];
		
		// @deprecated 1.8
		if (isset($vars['area1'])) {
		echo $vars['area1'];
		}

		echo elgg_view('page/layouts/elements/footer', $vars);
	?>
	</div>
</div>