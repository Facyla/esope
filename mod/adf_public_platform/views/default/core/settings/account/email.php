<?php
/**
 * Provide a way of setting your email
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

if ($user) {
?>
<div class="elgg-module elgg-module-info">
	<div class="elgg-head">
		<h3><?php echo elgg_echo('email:settings'); ?></h3>
	</div>
	<div class="elgg-body">
		<p>
			<label for="email"><?php echo elgg_echo('email:address:label'); ?>:</label>
			<?php
			echo elgg_view('input/email',array('name' => 'email', 'value' => $user->email));
			?>
		</p>
	</div>
</div>
<?php
}
