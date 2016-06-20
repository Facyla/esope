<?php
/**
 * Wire add form body
 *
 * @uses $vars['post']
 */

elgg_load_js('elgg.thewire');

$parent_post = elgg_extract('post', $vars);
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire');

$text = elgg_echo('post');
if ($parent_post) { $text = elgg_echo('thewire:reply'); }

//echo '<div style="width:80%; float:left;">';
	echo elgg_view('input/plaintext', array(
		'name' => 'body',
		'class' => 'mtm',
		'id' => 'thewire-textarea',
		//'maxlength' => 140, // Do not block at 140, and use the warning
		'placeholder' => elgg_echo('theme_inria:thewire:placeholder'),
	));
//echo '</div>';

//echo '<div style="width:18%; float:right;">';
echo '<div class="elgg-foot mts">';
	if ($parent_post) {
		//echo '<div>' . elgg_echo('theme_inria:thewire:access') . elgg_view('output/access', array('entity' => $parent_post)) . '</div>';
		echo '<div style="display:inline-block;">' . elgg_view('output/access', array('entity' => $parent_post)) . '</div>';
		echo elgg_view('input/hidden', array('name' => 'parent_guid', 'value' => $parent_post->guid));
	} else {
		// Niveau d'accès défini ssi pas une réponse
		// Forcé sur valeur par défaut définie dans le thème
		$default_access = elgg_get_plugin_setting('thewire_default_access', 'esope', get_default_access());
		if ($default_access) {
			// Check that it is a valid access id
			if ((($default_access >= -2) && ($default_access <= 2)) || ($collection = get_access_collection($default_access))) {
				$options_values[$default_access] = get_readable_access_level($default_access);
			} else {
				$default_access = false;
			}
		}
		// If value is invalid, use site or user default
		if (!$default_access) { $default_access = get_default_access(); }
		// Forcé sur Membres du site
		echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => $default_access));
		//echo '<div style="display:inline-block;">' . elgg_view('output/access', array('value' => $default_access)) . '</div>';
	}

	?>
	<span style="float:right;">
		<span id="thewire-characters-remaining" style="margin-bottom:5px;"><span><?php echo $char_limit; ?></span></span> 
		<?php

		echo elgg_view('input/submit', array(
			'value' => $text,
			'id' => 'elgg-button elgg-button-submit',
			//'style' => 'padding:0 12px; margin-top: 2px;',
		));
		?>
	</span>
</div>

