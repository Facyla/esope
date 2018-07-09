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

<div class="transalgo-login">
	<div>
		<label for="login_username"><?php echo elgg_echo('transalgo:login:email'); ?></label>
		<?php echo elgg_view('input/text', array(
			'name' => 'username',
			'autofocus' => true,
			'id' => "login_username", 
			'value' => $username,
			'required' => "required"
		));
		?>
	</div>
	<div>
		<label for="login_password"><?php echo elgg_echo('transalgo:login:password'); ?></label>
		<?php echo elgg_view('input/password', array(
			'name' => 'password', 
			'id' => 'login_password', 
			'required' => "required"
		));
	
		echo '<div class="clearfloat"></div>';
		?>
	</div>

	<?php
		// Toogler may only exist on homepage (this view is in a form, so can't insert a toggler here)
	//if ((current_page_url() == elgg_get_site_url()) || (current_page_url() == elgg_get_site_url() . 'forgotpassword') || (current_page_url() == elgg_get_site_url().'login')) {
	// Ok to add it here for login view - which can be added to forgotpassword view (if not, won't be displayed anyway), but care with login view !)
	if ((current_page_url() == elgg_get_site_url().'transalgo') || (current_page_url() == elgg_get_site_url() . 'forgotpassword')) {
		echo '<div><a href="javascript:void(0);" onclick="$(\'#transalgo-lostpassword\').toggle(); $(\'#lostpassword_username\').val($(\'#login_username\').val()); $(\'.elgg-form-user-requestnewpassword input#username\').focus();" class="transalgo-lostpassword-toggle">' . elgg_echo('transalgo:login:lostpassword') . '</a></div>';
	} else {
		echo '<div><a href="' . elgg_get_site_url() . 'forgotpassword" class="transalgo-lostpassword" class="transalgo-lostpassword-toggle">' . elgg_echo('transalgo:login:lostpassword') . '</a></div>';
	}

	echo elgg_view('login/extend'); ?>

	<div id="transalgo-persistent">
		<label for="persistent">
			<input type="checkbox" name="persistent" id="persistent" />
			<?php echo elgg_echo('transalgo:login:persistent'); ?>
		</label>
	</div>
	<div class="clearfloat"></div>

	<div class="elgg-foot">
		<?php
		echo elgg_view('input/securitytoken');
		echo elgg_view('input/submit', array('value' => elgg_echo('transalgo:login:submit')));
		
		if (isset($vars['returntoreferer'])) {
			echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
		}
		?>
	</div>

</div>

