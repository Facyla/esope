<?php

/**
 * Layout sidebar
 *
 * @uses $vars['sidebar'] Sidebar view
 */

$sidebar = elgg_extract('sidebar', $vars);
if (empty($sidebar)) {
	return;
}
?>
<div class="elgg-sidebar elgg-layout-sidebar clearfix">
	<div class="elgg-sidebar-nav">
		<a href="javascript: void(0);" onClick="$('.elgg-sidebar-collapse').slideToggle();" class="elgg-sidebar-button float"><span></span><span></span><span></span></a>
	</div>
	<div class="elgg-sidebar-collapse">
		<?php echo $sidebar; ?>
	</div>
</div>
