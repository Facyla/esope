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
		'class' => '',
		'id' => 'thewire-textarea',
	));
echo '</div>';

echo '<div style="width:16%; float:right;">';
	?>
	<div id="thewire-characters-remaining">
		<span>140</span> <?php echo elgg_echo('adf_platform:thewire:charleft'); ?>
	</div>
	<div class="elgg-foot">
	<?php

	if ($post) {
		//echo '<div>' . elgg_echo('adf_platform:thewire:access') . elgg_view('output/access', array('entity' => $post)) . '</div>';
		echo '<div>' . elgg_view('output/access', array('entity' => $post)) . '</div>';
		echo elgg_view('input/hidden', array(
			'name' => 'parent_guid',
			'value' => $post->guid,
		));
	} else {
		echo elgg_view('input/hidden', array('name' => 'access_id', 'id' => 'access_id', 'value' => 1));
	}

	echo elgg_view('input/submit', array(
		'value' => $text,
		'id' => 'elgg-button elgg-button-action',
		'style' => 'padding:0.5ex 1ex; margin-top: 1ex;',
	));
	echo '</div>';
	?>
</div>
