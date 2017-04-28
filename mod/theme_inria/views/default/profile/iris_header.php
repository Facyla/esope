<?php
/**
 * Iris v2 profile header
 */

$user = elgg_get_page_owner_entity();
$own = elgg_get_logged_in_user_entity();

?>
<div class="iris-profile-icon" style="background:url('<?php echo $user->getIconUrl(array('size' => 'large')); ?>') no-repeat center/contain;" />
	<?php

	if ($user->canEdit()) {
		echo '<a href="' . elgg_get_site_url() . 'avatar/edit/' . $user->username . '" class="iris-profile-editavatar"><i class="fa fa-camera"></i><br />' . elgg_echo('edit') . '</a>';
	}
	if (true || $user->guid != $own->guid) {
		echo elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/friends/add?friend=' . $user->guid, 
				'text' => '<i class=" fa fa-user-plus"></i></a>',
				'class' => 'iris-profile-addfriend', 'is_action' => true
			));
		echo '<a href="' . elgg_get_site_url() . 'messages/compose?send_to=' . $user->guid . '" class="iris-profile-sendmessage"><i class=" fa fa-envelope"></i></a>';
	}

	?>
</div>

<div class="iris-profile-title">
	<h2><?php echo $user->name; ?></h2>
	<?php echo strip_tags($user->briefdescription); ?>
</div>


