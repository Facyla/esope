<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

$password = $password2 = '';
$username = get_input('u');
$email = get_input('e');
$name = get_input('n');

if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}

?>
<h2><?php echo elgg_echo('register'); ?></h2>

<div>
  <?php
  if (elgg_is_active_plugin('adf_registration_filter')) {
    // Get and prepare valid domain config array from plugin settings
    $whitelist = elgg_get_plugin_setting('whitelist', 'adf_registration_filter');
    // Add csv support - cut also on ";" and ","
    $whitelist = str_replace(array(' ', '<p>', '</p>'), '', $whitelist); // Clean list - delete all white spaces
    $whitelist = preg_replace('/\r\n|\r/', ", ", $whitelist);
    $whitelist = str_replace(array(';'), ", ", $whitelist);
    $whitelist_intro = substr($whitelist, 0, 185);
    $whitelist_end = '<span id="adf-register-whitelist" style="display:none;">' . substr($whitelist, 185) . '</span>';
    echo elgg_echo('registration_filter:register:whitelist') . $whitelist_intro . '<a href="javascript:void(0);" onclick="$(\'#adf-register-whitelist\').toggle(); this.innerHTML=\'\';">.. Lire la suite</a>' . $whitelist_end;
  }
  ?>
</div>

<hr class="adf-strongseparator" />

<p class=""><?php echo elgg_echo('accessibility:allfieldsmandatory'); ?></p>

<div class="mtm">
  <?php if (elgg_is_active_plugin('adf_registration_filter')) { ?>
	  <label for="register_name"><?php echo elgg_echo('name'); ?>*</label> 
	  <?php echo elgg_view('input/text', array('name' => 'name', 'id' => 'register_name', 'value' => $name, 'class' => 'elgg-autofocus')); ?>
  <?php } else { ?>
	  <label for="register_username"><?php echo elgg_echo('username'); ?>*</label> 
	  <?php echo elgg_view('input/text', array('name' => 'username', 'id' => 'register_username', 'value' => $username, 'class' => 'elgg-autofocus')); ?>
  <?php } ?>
</div>

<div>
	<label for="register_email"><?php echo elgg_echo('email'); ?>*</label> 
	<?php echo elgg_view('input/text', array('name' => 'email', 'id' => 'register_email', 'value' => $email )); ?>
</div>

<hr class="adf-lightseparator" />

<div>
	<label for="register_password"><?php echo elgg_echo('password'); ?>*</label> 
	<?php echo elgg_view('input/password', array('name' => 'password', 'id' => 'register_password', 'value' => $password )); ?>
</div>
<div>
	<label for="register_password2"><?php echo elgg_echo('passwordagain'); ?>*</label> 
	<?php echo elgg_view('input/password', array('name' => 'password2', 'id' => 'register_password2', 'value' => $password2 )); ?>
</div>

<?php if (!elgg_is_active_plugin('adf_registration_filter')) { ?>
  <label for="register_name"><?php echo elgg_echo('name'); ?>*</label> 
  <?php echo elgg_view('input/text', array('name' => 'name', 'id' => 'register_name', 'value' => $name, 'class' => 'elgg-autofocus')); ?>
<?php } ?>

<hr class="adf-lightseparator" />

<div class="clearfloat"></div>

<?php
// view to extend to add more fields to the registration form
echo elgg_view('register/extend');

// Add captcha hook
echo elgg_view('input/captcha');

echo '<br />';
echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('register')));
echo '</div>';
?>

<hr class="adf-strongseparator" />

