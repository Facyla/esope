<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
?>

<p class="invisible"><?php echo elgg_echo('accessibility:allfieldsmandatory'); ?></p>

<div>
	<label for="login_username"><?php echo elgg_echo('loginusername'); ?>*</label>
	<?php echo elgg_view('input/text', array('name' => 'username', 'class' => 'elgg-autofocus', 'id' => "login_username", )); ?>
</div>
<div>
	<label for="login_password"><?php echo elgg_echo('password'); ?>*</label>
	<?php
	echo elgg_view('input/password', array('name' => 'password', 'id' => 'login_password'));
	
	echo '<div class="clearfloat"></div>';
	echo '<a href="javascript:void(0);" onclick="$(\'#adf-lostpassword\').toggle(); $(\'#lostpassword_username\').val($(\'#login_username\').val());" class="adf-lostpassword-link">' . elgg_echo('user:password:lost') . '</a>';
	?>
</div>

<?php echo elgg_view('login/extend'); ?>

<div id="adf-persistent">
	<label for="persistent">
		<input type="checkbox" name="persistent" id="persistent" checked="checked" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
</div>
<div class="clearfloat"></div>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('login'))); ?>
	
	<?php 
	if (isset($vars['returntoreferer'])) {
		echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
	}
  ?>
</div>

