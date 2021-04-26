<?php
$group = elgg_get_page_owner_entity();
if (!$group instanceof ElggGroup) { return; }

// Skip on main group page
if (current_page_url() == $group->getURL()) { return; }

$group_name = elgg_get_excerpt($group->name, 120);

$url = elgg_get_site_url();
$icon_field = $banner_field = '';

$banner_css = '#FFFFFF';
if (!empty($group->banner)) {
	//$banner_css = "linear-gradient(rgba(66, 75, 95, 0.45), rgba(66, 75, 95, 0.45)), #424B5F url('{$url}groups/file/{$group->guid}/banner') no-repeat center/cover";
	$banner_css = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), #424B5F url('{$url}groups/file/{$group->guid}/banner?icontime={$group->bannertime}') no-repeat center/cover";
}
?>
<div class="group-header group-header-thin" style="background: <?php echo $banner_css; ?>;">
	<?php echo $banner_field; ?>
	
	<div class="group-image" style="background: white url('<?php echo $group->getIconURL(array('size' => 'large')); ?>') no-repeat center/cover; display: flex;">
		<?php echo '<a href="' . $group->getURL() . '">' . $icon_field . '</a>'; ?>
	</div>
	
	<div class="group-title">
		
		<?php
		echo '<h2><a href="' . $group->getURL() . '">' . $group_name . '</a></h2>';
		//echo '<span class="group-subtitle">' . elgg_get_excerpt($group->briefdescription) . '</span>';
		/*
		echo '<div class="group-rules">';
			// Community
			if (!empty($group->community)) { echo '<span class="group-community">' . elgg_echo('community') . ' ' . $group->community . '</span>'; }
			// Access
			echo '<span class="group-access">' . elgg_echo('theme_inria:access:groups') . '&nbsp;: ' . elgg_view('output/access', array('entity' => $group)) . '</span>';
			// Membership
			echo '<span class="group-membership">' . elgg_echo('theme_inria:groupmembership') . '&nbsp;: ';
			if ($group->membership == ACCESS_PUBLIC) {
				//echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . ' - ' . elgg_echo("theme_inria:groupmembership:open:details");
				echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . '</span>';
			} else {
				//echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . ' - ' . elgg_echo("theme_inria:groupmembership:closed:details");
				echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . '</span>';
			}
			echo '</span>';
		echo '</div>';
		*/
		
		?>
	</div>
	
	<div class="group-search">
	<?php
		// Group search
		if (elgg_is_active_plugin('search')) {
			echo '<a href="' . $url . 'search?container_guid=' . $group->guid . '" class="search float-alt"><i class="fa fa-search"></i></a>';
		}
	?>
	</div>
	
</div>

