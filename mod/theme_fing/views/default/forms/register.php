<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

$password = $password2 = '';
$username = elgg_extract('username', $vars, get_input('u'));
$email = elgg_extract('email', $vars, get_input('e'));
$name = elgg_extract('name', $vars, get_input('n'));

if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}

/*
// must accept terms
if($accept_terms = elgg_get_plugin_setting("registration_terms", "profile_manager")){
	$link_begin = '<a target="_blank" href="' . $accept_terms . '">';
	$link_end = '</a>';
	
	$terms = '<div class="mandatory register-fullwidth">';
	$terms .= '<label for="register-accept_terms" class="register-fullwidth">';
	$terms .= '<input id="register-accept_terms" type="checkbox" name="accept_terms" value="yes" /> ';
	$terms .= elgg_echo("profile_manager:registration:accept_terms", array($link_begin, $link_end));
	$terms .= '</label>';
	$terms .= '</div>';
}
*/

$terms .= elgg_get_plugin_setting("registration_free_text", "profile_manager")
//$terms .= elgg_echo("theme_fing:register:terms");




echo '<div id="profile_manager_register_left" class="home-static-container">';
echo '<h3 class="fing-register-title">' . elgg_echo('theme_fing:register:3minutes') . '</h3>';

echo '<center>';
echo '<p class="fing-register-instructions">' . elgg_echo('theme_fing:register:prefill') . '</p
>';
echo '</center>';

echo elgg_view('hybridauth/register', $vars);

echo '<hr class="adf-lightseparator" />';

echo '<p class="fing-register-instructions">' . elgg_echo('theme_fing:register:createwithmail') . '</p>';

$show_hints = false;
//if(elgg_get_plugin_setting("show_account_hints", "profile_manager") == "yes") { $show_hints = true; }
?>

<fieldset>
	<div class="mtm mandatory">
		<label for='register-name'><?php echo elgg_echo('name'); ?></label>
		<?php if($show_hints){ ?>
			<span class='custom_fields_more_info' id='more_info_name'></span> 
			<span class='custom_fields_more_info_text' id='text_more_info_name'><?php echo elgg_echo("profile_manager:register:hints:name")?></span>
		<?php } ?>
		
		<div class='profile_manager_register_input_container'>
		<?php echo elgg_view('input/text', array('id' => 'register-name', 'name' => 'name', 'value' => $name, 'class' => 'elgg-autofocus', 'required' => 'required')); ?>
		</div>
	</div>
	
	<div class="mandatory">
		<label for='register-email'><?php echo elgg_echo('theme_fing:register:email'); ?></label>
		<?php if($show_hints){ ?>
			<span class='custom_fields_more_info' id='more_info_email'></span>
			<span class='custom_fields_more_info_text' id='text_more_info_email'><?php echo elgg_echo("profile_manager:register:hints:email")?></span>
		<?php } ?>
		
		<div class='profile_manager_register_input_container'>
			<?php echo elgg_view('input/text', array('id' => 'register-email', 'name' => 'email', 'value' => $email, 'required' => 'required')); ?>
			<span class="elgg-icon profile_manager_validate_icon"></span>
		</div>
	</div>
	
	<div class="mandatory">
		<label for='register-password'><?php echo elgg_echo('password'); ?></label>
		<?php if ($show_hints) { ?>
			<span class='custom_fields_more_info' id='more_info_password'></span>
			<span class='custom_fields_more_info_text' id='text_more_info_password'><?php echo elgg_echo("profile_manager:register:hints:password")?></span>
		<?php } ?>
		
		<div class='profile_manager_register_input_container'>
			<?php echo elgg_view('input/password', array('id' => 'register-password', 'name' => 'password', 'value' => $password, 'required' => 'required')); ?>
			<span class='elgg-icon profile_manager_validate_icon'></span>
		</div>
	</div>
	
	<?php /*
	<div class="mandatory">
		<label for='register-password2'><?php echo elgg_echo('passwordagain'); ?></label>
		
		<?php if($show_hints){ ?>
			<span class='custom_fields_more_info' id='more_info_passwordagain'></span>
			<span class='custom_fields_more_info_text' id='text_more_info_passwordagain'><?php echo elgg_echo("profile_manager:register:hints:passwordagain")?></span>
		<?php } ?>
		<div class='profile_manager_register_input_container'>
			<?php echo elgg_view('input/password', array('id' => 'register-password2', 'name' => 'password2', 'value' => $password2, 'required' => 'required')); ?>
			<span class="elgg-icon profile_manager_validate_icon"></span>
		</div>
	</div>
	*/ ?>
	
	<div class="mandatory">
		<label for='register-username'><?php echo elgg_echo('theme_fing:register:usernameurl'); ?></label>
		<?php if($show_hints){ ?>
			<span class='custom_fields_more_info' id='more_info_username'></span>
			<span class='custom_fields_more_info_text' id='text_more_info_username'><?php echo elgg_echo("profile_manager:register:hints:username")?></span>
		<?php } ?>
		<div class='profile_manager_register_input_container'>
			<?php echo elgg_view('input/text', array('id' => 'register-username', 'name' => 'username', 'value' => $username, 'required' => 'required')); ?>
			<div class='elgg-icon profile_manager_validate_icon'></div>
		</div>
	</div>
	
	<?php echo $terms; ?>
	
</fieldset>

<?php
// view to extend to add more fields to the registration form
echo elgg_view('register/extend');

// Add captcha hook
echo elgg_view('input/captcha');

echo "<div class='clearfloat'></div>";
//echo '<br />';
echo "<div class='elgg-foot'>";
echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('register'), 'class' => "fing-register-submit"));
//echo "<div class='elgg-subtext mtm'>" . elgg_echo("profile_manager:register:mandatory") . "</div>";

echo "</div>";


// Right column
echo '<div id="profile_manager_register_right" class="fing-register-groups home-static-container">' .elgg_view("register/extend_side");
	echo '<h3 class="fing-register-title">' . elgg_echo('theme_fing:register:discoverwork') . '</h3>';
	
	echo '<p class="fing-register-instructions">' . elgg_echo('theme_fing:register:choosegroups') . '</p>';
	
	echo elgg_view('forms/groups/register_join_groups', $vars);
echo '</div>';


//echo '<hr class="adf-lightseparator" />';

echo "</div>";
?>

<hr class="adf-strongseparator" />

