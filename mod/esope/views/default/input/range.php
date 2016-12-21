<?php
/* Input range
 * Displays 2 separate input boxes + a range slider
 * Values can be set both with the input or the range slider
 * Input boxes can also be hidden
 * Vars notes :
 * $min, $max : array('name' => 'input_name', 'value' => $value)
 * $values : array('min' => $min_value, 'max' => $max_value)
 */
$min = elgg_extract('min', $vars, array('name' => 'min', 'value' => 0));
$max = elgg_extract('max', $vars, array('name' => 'max', 'value' => 100));
$values = elgg_extract('values', $vars, array('min' => $min['value'], 'max' => $max['value']));
$text = elgg_extract('text', $vars, '');
$class = elgg_extract('class', $vars, 'range');
$id = elgg_extract('id', $vars, 'slider-range-'.$min['name']); // Must be unique
$step = elgg_extract('step', $vars, 1);
$input_type = elgg_extract('input_type', $vars, false); // text, number, hidden
if (!in_array($input_type, array('text', 'number', 'hidden', 'date'))) { $input_type = 'number'; }

// Set some things once
global $inputRangeUIloaded;
if (!isset($inputRangeUIloaded)) {
	$css = elgg_load_css('jquery-ui');
	if (empty($css)) {
		elgg_register_css('jquery-ui', '//code.jquery.com/ui/1.8.24/themes/base/jquery-ui.css');
		elgg_load_css('jquery-ui');
	}
	echo '<style>
	.slider-range {  }
	.slider-range-input { margin: 0.5ex 3ex 0.5ex 2ex; }
	</style>';
	$inputRangeUIloaded = true;
}

if (empty($values['min'])) $values['min'] = $min['value'];
if (empty($values['max'])) $values['max'] = $max['value'];

// Set max input length + corresponding style
$maxlength = strlen($max['value']);
$input_width = $maxlength + 5 . "ex";

echo '<div class="slider-range">' . $text;

// Render min input
$params = array(
	'name' => $min['name'],
	'value' => $values['min'],
	'onChange' => '$("#' . $id . '").slider("values", 0, this.value);',
	'min' => $min['value'], 'max' => $max['value'], 'step' => $step,
	'maxlength' => $maxlength,
	'style' => "width:$input_width;",
	);
if (empty($min['text'])) { echo elgg_view("input/$input_type", $params); }
else { echo '<label>' . $min['text'] . elgg_view("input/$input_type", $params) . '</label>'; }

// Render max input
$params['name'] = $max['name'];
$params['value'] = $values['max'];
$params['onChange'] = '$("#' . $id . '").slider("values", 1, this.value);';
if (empty($max['text'])) { echo elgg_view("input/$input_type", $params); }
else { echo '<label>' . $max['text'] . elgg_view("input/$input_type", $params) . '</label>'; }

// Render slider
echo '<div id="' . $id . '" class="slider-range-input"></div>';
echo '<script>
$("#' . $id . '" ).slider({
	range: true,
	min: ' . $min['value'] . ',
	max: ' . $max['value'] . ',
	values: [' . $values['min'] . ',' .  $values['max']  . '],
	slide: function( event, ui ) {
		$("input[name=' . $min['name'] . ']").val(ui.values[0]);
		$("input[name=' . $max['name'] . ']").val(ui.values[1]);
	}
});
$("input[name=' . $min['name'] . ']").val($("#' . $id . '").slider("values", 0));
$("input[name=' . $max['name'] . ']").val($("#' . $id . '").slider("values", 1));
</script>';

echo '</div>';

