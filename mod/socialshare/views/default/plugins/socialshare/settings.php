<p><label><?php echo elgg_echo('socialshare:extendviews'); ?></label><br />
	<?php echo elgg_echo('socialshare:extendviews:help'); ?>
	<?php echo elgg_view('input/plaintext', array( 'name' => 'params[extendviews]', 'value' => $vars['entity']->extendviews, 'js' => ' style="min-height:300px;"' )); ?>
</p>

