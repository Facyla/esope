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

echo '<div style="width:80%; float:left;">';
	echo elgg_view('input/plaintext', array(
		'name' => 'body',
		'class' => 'mtm',
		'id' => 'thewire-textarea',
		'maxlength' => 140,
	));
echo '</div>';

echo '<div style="width:18%; float:right;">';
	?>
	<div id="thewire-characters-remaining" style="margin-bottom:5px;">
		<span>140</span> <?php echo elgg_echo('theme_cocon:thewire:charleft'); ?>
	</div>
	<div class="elgg-foot mts">
	<?php

	if ($post) {
		echo '<div>' . elgg_view('input/hidden', array('name' => 'access_id', 'value' => $post->access_id)) . '</div>';
		echo '<div>' . elgg_view('output/access', array('entity' => $post)) . '</div>';
		echo elgg_view('input/hidden', array('name' => 'parent_guid', 'value' => $post->guid));
	} else {
		// Niveau d'accès forcé sur Membres du site
		echo '<div>' . elgg_view('input/hidden', array('name' => 'access_id', 'value' => 1)) . '</div>';
	}

	echo elgg_view('input/submit', array(
		'value' => $text,
		'id' => 'elgg-button elgg-button-submit',
		//'style' => 'padding:0 12px; margin-top: 2px;',
	));
	echo '</div>';
	?>
</div>

