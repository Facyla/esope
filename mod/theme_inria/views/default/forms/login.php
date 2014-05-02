<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
?>

<p class="invisible"><?php echo elgg_echo('accessibility:allfieldsmandatory'); ?></p>

<?php
global $CONFIG;

// Hide form only on homepage
$default_hide = '';
//if ($CONFIG->url == full_url()) $default_hide = 'display:none;';
$default_hide = 'display:none;'; // Toujours masqué par défaut

echo '<p>' . elgg_echo('elgg_cas:login:details') . '</p>';
?>

<div class="inria-login">
	<a href="<?php echo $CONFIG->url; ?>cas_auth" class="elgg-button elgg-button-action cas-login"><?php echo elgg_echo('theme_inria:caslogin'); ?></a>
	<?php if (!empty($default_hide)) { ?>
		<a href="javascript:void(0);" onclick="$('#inria-basiclogin').toggle();"  class="basic-login-toggle"><?php echo elgg_echo('theme_inria:basiclogin'); ?></a>
	<?php } else { ?>
		<a href="javascript:void(0);" onclick="$('#inria-basiclogin').toggle();"  class="basic-login-toggle"><?php echo elgg_echo('theme_inria:basiclogin'); ?></a>
	<?php } ?>
</div>
<div class="clearfloat"></div>

<div id="inria-basiclogin" style="<?php echo $default_hide; ?>">
	<div>
		<label for="login_username"><?php echo elgg_echo('loginusername'); ?>*</label>
		<?php echo elgg_view('input/text', array('name' => 'username', 'class' => 'elgg-autofocus', 'id' => "login_username", )); ?>
	</div>
	<div>
		<label for="login_password"><?php echo elgg_echo('password'); ?>*</label>
		<?php
		echo elgg_view('input/password', array('name' => 'password', 'id' => 'login_password'));
	
		echo '<div class="clearfloat"></div>';
		// Toogler may only exist on homepage (this view is in a form, so can't insert a toggler here)
		//if ((full_url() == elgg_get_site_url()) || (full_url() == elgg_get_site_url() . 'forgotpassword') || (full_url() == elgg_get_site_url().'login')) {
		// Ok to add it here for login view - which can be added to forgotpassword view (if not, won't be displayed anyway), but care with login view !)
		if ((full_url() == elgg_get_site_url()) || (full_url() == elgg_get_site_url() . 'forgotpassword')) {
			echo '<a href="javascript:void(0);" onclick="$(\'#adf-lostpassword\').toggle(); $(\'#lostpassword_username\').val($(\'#login_username\').val());" class="adf-lostpassword-toggle">' . elgg_echo('user:password:lost') . '</a> &nbsp; ';
		} else {
			echo '<a href="' . elgg_get_site_url() . 'forgotpassword" class="adf-lostpassword" class="adf-lostpassword-toggle">' . elgg_echo('user:password:lost') . '</a> &nbsp; ';
		}
		?>
	</div>
	
	<?php echo elgg_view('login/extend'); ?>

	<div id="adf-persistent">
		<label for="persistent">
			<input type="checkbox" name="persistent" id="persistent" />
			<?php echo elgg_echo('user:persistent'); ?>
		</label>
	</div>
	<div class="clearfloat"></div>

	<div class="elgg-foot">
		<?php
		echo elgg_view('input/securitytoken');
		echo elgg_view('input/submit', array('value' => elgg_echo('login')));
		?>
	
		<?php 
		if (isset($vars['returntoreferer'])) {
			echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
		}
		?>
	</div>

</div>

