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
	<label for="lostpassword_username"><?php echo elgg_echo('loginusername'); ?></label> 
	<?php
	$value = ''; // @todo : à récupérer du champ email de connexion en JS
	echo elgg_view('input/text', array(
		'name' => 'username',
		'id' => 'lostpassword_username',
		'class' => 'elgg-autofocus',
		'value' => $value,
		));
	?>
</div>
<?php echo elgg_view('input/captcha'); ?>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('accessibility:requestnewpassword'))); ?>
</div>
