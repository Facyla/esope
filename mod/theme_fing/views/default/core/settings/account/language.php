<?php
/**
 * Provide a way of setting your language prefs
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

// Force setting
if ($user->language != 'fr') { $user->language = 'fr'; }
// Feed the settings with something so it doesn't complain when not set at all
echo elgg_view("input/hidden", array('name' => 'language', 'value' => $user->language));

/*
// English (default) only

if ($user) {
?>
<div class="elgg-module elgg-module-info">
	<div class="elgg-head">
		<h3><?php echo elgg_echo('user:set:language'); ?></h3>
	</div>
	<div class="elgg-body">
		<p>
			<label for="language"><?php echo elgg_echo('user:language:label'); ?>:</label>
			<?php
			echo elgg_view("input/dropdown", array(
				'name' => 'language',
				'value' => $user->language,
				'options_values' => get_installed_translations()
			));
			?>
		</p>
	</div>
</div>
<?php
}
*/

