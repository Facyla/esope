<?php
/**
 * Elgg topbar wrapper
 * Check if the user is logged in and display a topbar
 * ESOPE : display topbar only if not empty (can be displayed logged out) ?
 * @since 1.10 
 */

if (!elgg_is_logged_in()) {
	return true;
}

$topbar = elgg_view('page/elements/topbar', $vars);
if (empty($topbar)) { return true; }
?>
<div class="elgg-page-topbar">
	<div class="elgg-inner">
		<?php
		echo $topbar;
		?>
	</div>
</div>