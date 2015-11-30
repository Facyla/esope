<?php
/*
// From : Lorea - https://gitorious.org/lorea/microthemes
elgg_load_css('elgg.input.colorpicker');
elgg_load_js('elgg.input.colorpicker');
*/

elgg_load_css('jquery.colorpicker');
elgg_load_js('jquery.colorpicker');
elgg_load_js('jquery.colorpicker-i18n');
elgg_load_js('jquery.colorpicker-pantone');
elgg_load_js('jquery.colorpicker-rgbslider');
elgg_load_js('jquery.colorpicker-memory');
elgg_load_js('jquery.colorpicker-cmyk');
elgg_load_js('jquery.colorpicker-cmyk-percentage');


$vars['class'] = $vars['class'] ? " elgg-color-picker" : "elgg-color-picker";

$id = esope_unique_id('');
if (empty($vars['id'])) $vars['id'] = "elgg-colorpicker-$id";
else $vars['id'] = $vars['id'] . " elgg-colorpicker-$id";

echo elgg_view('input/text', $vars);
echo '<span id="elgg-colorpicker-' . $id . '-formats"></span>';

?>
<script>
$(function() {
	$('#elgg-colorpicker-<?php echo $id; ?>').colorpicker({
		alpha:          true,
		//colorFormat: 'RGBA',
		colorFormat: ['EXACT', '#HEX3', 'RGB', 'RGBA'],
		regional: 'fr',
		parts:          'full',
		//showOn:         'both',
		//buttonColorize: true,
		showNoneButton: true,
		altField: "#elgg-colorpicker-<?php echo $id; ?>",
		altProperties: 'background-color',
		altAlpha: true,
		init: function(event, color) {
			$('#elgg-colorpicker-<?php echo $id; ?>-formats').text(color.formatted);
		},
		select: function(event, color) {
			$('#elgg-colorpicker-<?php echo $id; ?>-formats').text(color.formatted);
		},
	});
});
</script>

