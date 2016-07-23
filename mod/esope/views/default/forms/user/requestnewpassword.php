<?php
/**
 * Elgg forgotten password.
 *
 * @package Elgg
 * @subpackage Core
 */
?>

<div class="mtm">
	<?php echo elgg_echo('user:password:text'); ?>
</div>
<div>
	<label><?php echo elgg_echo('loginusername'); ?>
		<?php echo elgg_view('input/text', array(
			'name' => 'username',
			'autofocus' => true,
			));
		?>
	</label>
</div>
<?php echo elgg_view('input/captcha'); ?>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('accessibility:requestnewpassword'))); ?>
</div>
