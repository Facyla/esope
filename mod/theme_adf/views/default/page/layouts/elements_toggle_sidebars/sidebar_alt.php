<?php

/**
 * Second layout sidebar
 *
 * @uses $vars['sidebar_alt'] Sidebar view
 */

$sidebar_alt = elgg_extract('sidebar_alt', $vars);
if (empty($sidebar_alt)) {
	return;
}
?>
<div class="elgg-sidebar-alt elgg-layout-sidebar-alt clearfix">
	<div class="elgg-sidebar-alt-nav">
		<a href="javascript: void(0);" onClick="$('.elgg-sidebar-alt-collapse').slideToggle();" class="elgg-sidebar-button float-alt"><span></span><span></span><span></span></a>
	</div>
	<div class="elgg-sidebar-alt-collapse">
		<?php echo $sidebar_alt; ?>
	</div>
</div>
