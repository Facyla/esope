<?php
/**
 * Elgg pages widget edit
 *
 * @package ElggPages
 */

$widget_id = $vars['entity']->guid;

$login = elgg_view('input/text', array('name' => 'params[login]', 'value' => $vars['entity']->login));
$password = elgg_view('input/text', array('name' => 'params[password]', 'value' => $vars['entity']->password));

?>
<p>
	<label for="login_<?php echo $widget_id; ?>">Login: <?php echo $login; ?></label>
</p>

<p>
	<label for="password_<?php echo $widget_id; ?>">Password: <?php echo $password; ?></label>
</p>

<?php
// set default value
/*
if (!isset($vars['entity']->pages_num)) {
	$vars['entity']->pages_num = 4;
}

$params = array(
	'name' => 'params[pages_num]',
	'id' => 'num_display_'.$widget_id,
	'value' => $vars['entity']->pages_num,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
);
$dropdown = elgg_view('input/dropdown', $params);

?>
<div>
	<label for="num_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('pages:num'); ?>:</label>
	<?php echo $dropdown; ?>
</div>
*/
?>
<p>Réglages pour Partage</p>

