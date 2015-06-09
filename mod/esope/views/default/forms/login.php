<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
$username = elgg_extract('username', $vars, get_input('u'));
?>

<p class="invisible"><?php echo elgg_echo('accessibility:allfieldsmandatory'); ?></p>

<div>
	<label for="login_username"><?php echo elgg_echo('loginusername'); ?>*</label>
	<?php echo elgg_view('input/text', array(
		'name' => 'username',
		'autofocus' => true,
		'id' => "login_username", 'value' => $username
		));
	?>
</div>
<div>
	<label for="login_password"><?php echo elgg_echo('password'); ?>*</label>
	<?php echo elgg_view('input/password', array('name' => 'password', 'id' => 'login_password'));
	
	echo '<div class="clearfloat"></div>';
	// Toogler may only exist on homepage (this view is in a form, so can't insert a toggler here)
	//if ((full_url() == elgg_get_site_url()) || (full_url() == elgg_get_site_url() . 'forgotpassword') || (full_url() == elgg_get_site_url().'login')) {
	// Ok to add it here for login view - which can be added to forgotpassword view (if not, won't be displayed anyway), but care with login view !)
	if ((full_url() == elgg_get_site_url()) || (full_url() == elgg_get_site_url() . 'forgotpassword')) {
		echo '<a href="javascript:void(0);" onclick="$(\'#esope-lostpassword\').toggle(); $(\'#lostpassword_username\').val($(\'#login_username\').val());" class="esope-lostpassword-toggle">' . elgg_echo('user:password:lost') . '</a> &nbsp; ';
	} else {
		echo '<a href="' . elgg_get_site_url() . 'forgotpassword" class="esope-lostpassword" class="esope-lostpassword-toggle">' . elgg_echo('user:password:lost') . '</a> &nbsp; ';
	}
	?>
</div>

<?php echo elgg_view('login/extend', $vars); ?>

<div class="elgg-foot">
	<label class="mtm float-alt">
		<input type="checkbox" name="persistent" value="true" />
		<?php echo elgg_echo('user:persistent'); ?>
	</label>

	<?php echo elgg_view('input/submit', array('value' => elgg_echo('login'))); ?>
	
	<?php 
	if (isset($vars['returntoreferer'])) {
		echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
	}
  ?>

	<?php
	echo elgg_view_menu('login', array(
		'sort_by' => 'priority',
		'class' => 'elgg-menu-general elgg-menu-hz mtm',
	));
	?>
</div>
