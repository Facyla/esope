<?php
$group = elgg_extract('entity', $vars);
if (!elgg_instanceof($group, 'group')) { return; }

// Thin head should display main group > EDT, or only current group or EDT
$main_group = theme_inria_get_main_group($group);
$group_name = elgg_get_excerpt($group->name, 120);

$url = elgg_get_site_url();
$icon_field = $banner_field = '';

$banner_css = '#424B5F';
if (!empty($main_group->banner)) {
	//$banner_css = "linear-gradient(rgba(66, 75, 95, 0.45), rgba(66, 75, 95, 0.45)), #424B5F url('{$url}groups/file/{$main_group->guid}/banner') no-repeat center/cover";
	$banner_css = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), #424B5F url('{$url}groups/file/{$main_group->guid}/banner?icontime={$main_group->bannertime}') no-repeat center/cover";
}
?>
<div class="iris-group-header iris-group-header-thin" style="background: <?php echo $banner_css; ?>;">
	<?php echo $banner_field; ?>
	
	<div class="iris-group-image" style="background: white url('<?php echo $main_group->getIconURL(array('size' => 'large')); ?>') no-repeat center/cover;">
		<?php echo $icon_field; ?>
	</div>
	
	<div class="iris-group-title">
		
		<?php
		echo '<h2>' . $group_name . '</h2>';
		//echo '<span class="iris-group-subtitle">' . elgg_get_excerpt($group->briefdescription) . '</span>';
		/*
		echo '<div class="iris-group-rules">';
			// Community
			if (!empty($group->community)) { echo '<span class="iris-group-community">' . elgg_echo('community') . ' ' . $group->community . '</span>'; }
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
	
	<div class="iris-group-search">
	<?php
		// Group search
		if (elgg_is_active_plugin('search')) {
			echo '<a href="' . $url . 'groups/search/' . $group->guid . '" class="search float-alt"><i class="fa fa-search"></i></a>';
		}
	?>
	</div>
	
</div>

