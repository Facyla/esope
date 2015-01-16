<?php
$an_id = $vars['annotation']->id;

$al = new AnnotationLike($an_id);
//echo $vars['annotation']->id . ' // ' . print_r($al, true);
if (!$al->isValid()) { return ''; }

?>
<p class="annotation-like">
	<?php if ($al->liked(elgg_get_logged_in_user_guid())) { ?>
		<a class="liked"
			 href="<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/cancel?id=' . $an_id); ?>"
			 title="<?php echo elgg_echo('likes:remove'); ?>"
			 data-href="<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/like?id=' . $an_id); ?>"
			 data-text="<?php echo elgg_echo('annotations:like'); ?>">
				<?php echo elgg_view_icon('thumbs-up-alt'); ?>
		</a>
	<?php } else { ?>
		<a class="like"
			 href="<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/like?id=' . $an_id); ?>"
			 title="<?php echo elgg_echo('likes:add'); ?>"
			 data-href="<?php echo elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/cancel?id=' . $an_id); ?>"
			 data-text="<?php echo elgg_echo('annotations:cancel_like'); ?>">
				<?php echo elgg_view_icon('thumbs-up'); ?>
		</a>
	<?php } ?>
	
	<span class="counter-holder">
		<?php
		$al_count = '<span class="counter">' . $al->count() .'</span>' ;
		if ($al_count > 1) {
			echo elgg_echo('likes:userslikedthis', array($al_count));
		} else {
			echo elgg_echo('likes:userlikedthis', array($al_count));
		}
		?>
	</span>
</p>
