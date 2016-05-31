<?php
/**
 * Wire add form body
 *
 * @uses $vars['post']
 */

elgg_load_js('elgg.thewire');

$parent_post = elgg_extract('post', $vars);
$forced_access = elgg_extract('access_id', $vars, false);
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire');

$text = elgg_echo('post');
if ($parent_post) { $text = elgg_echo('thewire:reply'); }
//$chars_left = elgg_echo('thewire:charleft');
$chars_left = elgg_echo('esope:thewire:charleft');

// Access level : same as parent, or forced, custom
$parent_input = '';
$access_input = '';
if ($parent_post) {
	$parent_input = elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $parent_post->guid,
	));
	//$access_input .= '<div>' . elgg_echo('esope:thewire:access') . elgg_view('output/access', array('entity' => $parent_post)) . '</div>';
	$access_input .= elgg_view('output/access', array('entity' => $parent_post));
	
} else if ($forced_access) {
	// Check that forced access_id is valid, and default to valid value if needed
	if (!($collection = get_access_collection($forced_access))) {
		$forced_access = elgg_get_plugin_setting('thewire_default_access', 'esope', get_default_access());
		if (!($collection = get_access_collection($forced_access))) { $forced_access = get_default_access(); }
	}
	$access_input = elgg_view('input/hidden', array('name' => 'access_id', 'value' => $forced_access));
	$access_input .= elgg_view('output/access', array('value' => $forced_access));
	
} else {
	// Niveau d'accès défini ssi pas une réponse
	$options_values = array('2' => elgg_echo('PUBLIC'), '1' => elgg_echo('LOGGED_IN'));
	// Ajout valeur par défaut définie dans le thème
	$default_access = elgg_get_plugin_setting('thewire_default_access', 'esope', get_default_access());
	if ($default_access && !isset($options_values[$default_access])) {
		// Check that it is a valid access id
		if ((($default_access >= -2) && ($default_access <= 2)) || ($collection = get_access_collection($default_access))) {
			$options_values[$default_access] = get_readable_access_level($default_access);
		} else {
			$default_access = false;
		}
	}
	// If value is invalid, use site or user default
	if (!$default_access) { $default_access = get_default_access(); }
	//$access_input = elgg_view('input/groups_select', array('name' => 'group_guid', 'id' => 'group_guid'));
	$access_input .= elgg_view('input/access', array('name' => 'access_id', 'id' => 'access_id', 'options_values' => $options_values, 'value' => $default_access, 'js' => ' style="max-width:50%; min-width: 10ex;"')) . '</label>';
}

$count_down = "<span>$char_limit</span> $chars_left";
$num_lines = 3;
if ($char_limit == 0) {
	$num_lines = 4;
	$count_down = '';
} else if ($char_limit > 140) {
	$num_lines = 4;
}

//echo '<div class="home-static-container" style="width:83%; float:left;">';
//	echo elgg_echo('esope:homewire:msg');
//	echo elgg_view('input/plaintext', array(
$parent_post_input = elgg_view('input/plaintext', array(
		'name' => 'body',
		'class' => 'mtm',
		'id' => 'thewire-textarea',
		'rows' => $num_lines,
		'data-max-length' => $char_limit,
		'style' => "height:initial;",
	));
//echo '</div>';

$submit_button = elgg_view('input/submit', array(
	'value' => $text,
	'id' => 'thewire-submit-button',
));


// Render view
echo elgg_echo('esope:homewire:msg');
echo <<<HTML
$parent_post_input
<div id="thewire-characters-remaining">
	$count_down
</div>
<div class="elgg-foot mts">
	$parent_input
	$access_input
	$submit_button
</div>
HTML;
