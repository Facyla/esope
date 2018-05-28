<?php
/**
 * Wire add form body
 *
 * @uses $vars['post']
 */

elgg_load_js('elgg.thewire');

$parent_post = elgg_extract('post', $vars);
$forced_access = elgg_extract('access_id', $vars, false);
// Iris v2 : soft limit (real limit = plugin settings)
//$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire', 140);
$char_limit = 140;
$own = elgg_get_logged_in_user_entity();

$id = 'thewire-textarea';
$counter_id = 'thewire-textarea-remaining';

$text = elgg_echo('post');
if ($parent_post) {
	$text = elgg_echo('thewire:reply');
	$id = 'thewire-textarea-' . $parent_post->guid;
	$counter_id = 'thewire-textarea-remaining-' . $parent_post->guid;
}
//$chars_left = elgg_echo('thewire:charleft');
$chars_left = elgg_echo('esope:thewire:charleft');

// Access level : same as parent, or forced, custom
$parent_input = '';
$access_input = '';
if ($parent_post) {
	//$access_input .= '<div>' . elgg_echo('theme_inria:thewire:access') . elgg_view('output/access', array('entity' => $parent_post)) . '</div>';
	$access_input .= '<div style="display:inline-block;">' . elgg_view('output/access', array('entity' => $parent_post)) . '</div>';
	$parent_input .= elgg_view('input/hidden', array('name' => 'parent_guid', 'value' => $parent_post->guid));
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
	//$access_input .= elgg_view('input/hidden', array('name' => 'access_id', 'value' => $default_access));
	//$access_input .= '<div style="display:inline-block;">' . elgg_view('output/access', array('value' => $default_access)) . '</div>';
	$inria_access_id = theme_inria_get_inria_access_id();
	// Only Inria only can select access (defaults to Inria only))
	if ($inria_access_id && (esope_get_user_profile_type() == 'inria')) {
		$access_id = elgg_extract('access_id', $vars, $inria_access_id);
		$access_opt = array(
				$inria_access_id => elgg_echo('profiletype:inria'),
				'1' => elgg_echo('LOGGED_IN'),
			);
		$access_input .= elgg_view('input/select', array('name' => 'access_id', 'value' => $access_id, 'options_values' => $access_opt));
	} else {
		$access_input .= elgg_view('input/hidden', array('name' => 'access_id', 'value' => ACCESS_LOGGED_IN));
	}
}

$count_down = "<span>$char_limit</span> $chars_left";
$num_lines = 3;
if ($char_limit == 0) {
	$num_lines = 4;
	$count_down = '';
} else if ($char_limit > 140) {
	$num_lines = 4;
}

$user_img = '<img src="' . $own->getIconUrl(array('size' => 'small')) . '" alt="' . $own->name . '" />';

$post_input = elgg_view('input/plaintext', array(
		'name' => 'body',
		'class' => 'mtm',
		'id' => $id,
		'class' => 'thewire-textarea',
		'rows' => $num_lines,
		'data-max-length' => $char_limit,
		'data-counter-id' => $counter_id,
		//'style' => "height:initial;",
		//'maxlength' => 140, // Do not block at 140, and use the warning
		'placeholder' => elgg_echo('theme_inria:thewire:placeholder', array($char_limit)),
	));

$submit_button = elgg_view('input/submit', array(
	'value' => $text,
	'id' => 'thewire-submit-button',
	//'style' => 'padding:0 12px; margin-top: 2px;',
));

echo <<<HTML
<div class="wire-input">
	$user_img
	$post_input
</div>
<div class="elgg-foot mts">
	$access_input
	$parent_input
	<span style="float:right;">
		<div id="$counter_id" class="thewire-characters-remaining" style="margin-bottom:5px;">$count_down</div>
		$submit_button
	</span>
</div>
HTML;

