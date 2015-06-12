<?php
/**
 * Wire add form body
 *
 * @uses $vars['post']
 */

elgg_load_js('elgg.thewire');

$post = elgg_extract('post', $vars);

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('thewire:reply');
}

echo '<div style="width:83%; float:left;">';
	echo elgg_echo('adf_platform:homewire:msg');
	echo elgg_view('input/plaintext', array(
		'name' => 'body',
		'class' => 'mtm',
		'id' => 'thewire-textarea',
	));
echo '</div>';

echo '<div style="width:16%; float:right;">';
	?>
	<div id="thewire-characters-remaining" style="margin-bottom:5px;">
		<span>140</span> <?php echo elgg_echo('adf_platform:thewire:charleft'); ?>
	</div>
	<div class="elgg-foot mts">
	<?php

	if ($post) {
		//echo '<div>' . elgg_echo('adf_platform:thewire:access') . elgg_view('output/access', array('entity' => $post)) . '</div>';
		echo '<div>' . elgg_view('output/access', array('entity' => $post)) . '</div>';
		echo elgg_view('input/hidden', array(
			'name' => 'parent_guid',
			'value' => $post->guid,
		));
	} else {
		// Niveau d'accès défini ssi pas une réponse
		$default_access = elgg_get_plugin_setting('thewire_default_access', 'adf_public_platform');
		// Skip any non-valid value and use default instead (is_int doesnt like negative numbers)
		if (empty($default_access) || ($default_access == 'default') || !is_int($default_access+2)) {
			$default_access = get_default_access();
		}
		$options_values = array('2' => elgg_echo('PUBLIC'), '1' => elgg_echo('LOGGED_IN'));
		//$access_input = elgg_view('input/groups_select', array('name' => 'group_guid', 'id' => 'group_guid'));
		echo '<div>' . elgg_view('input/access', array('name' => 'access_id', 'id' => 'access_id', 'options_values' => $options_values, 'value' => $default_access, 'js' => ' style="max-width:100%; min-width: 10ex;"')) . '</label></div>';
	}

	echo elgg_view('input/submit', array(
		'value' => $text,
		'class' => 'elgg-button elgg-button-action',
		'style' => 'padding:0 12px; margin-top: 2px;',
	));
	echo '</div>';
	?>
</div>
