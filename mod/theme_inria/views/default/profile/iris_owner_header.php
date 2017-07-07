<?php
/**
 * Iris v2 profile header
 */

$user = elgg_get_page_owner_entity();
$own = elgg_get_logged_in_user_entity();

$profile_type = esope_get_user_profile_type($user);
if (empty($profile_type)) { $profile_type = 'external'; }

echo '<a href="' . $user->getURL() . '" title="' . elgg_echo('theme_inria:profile:back') . '">';
	?>
	<div class="iris-profile-icon <?php if (!empty($profile_type)) { echo 'profile-type-' . $profile_type; } ?>" style="background:url('<?php echo $user->getIconUrl(array('size' => 'large')); ?>') no-repeat center/cover;" />
	</div>

	<div class="iris-profile-title">
		<h2><?php echo $user->name; ?></h2>
		<?php echo strip_tags($user->briefdescription); ?>
	</div>
</a>

