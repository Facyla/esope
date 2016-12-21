<?php
// Note : this version uses vendors/colorpicker : full featured but requires some rewriting to fit AMD

/* This should be always loaded (start.php)
elgg_require_js('jquery.ui');
elgg_load_css('jquery.ui');
elgg_load_css('jquery.ui.theme');
*/

elgg_load_css('jquery.colorpicker');
elgg_require_js('jquery.colorpicker');
elgg_require_js('jquery.colorpicker-i18n');
elgg_require_js('jquery.colorpicker-pantone');
elgg_require_js('jquery.colorpicker-crayola');
elgg_require_js('jquery.colorpicker-ral-classic');
elgg_require_js('jquery.colorpicker-x11');
elgg_require_js('jquery.colorpicker-rgbslider');
elgg_require_js('jquery.colorpicker-memory');
elgg_require_js('jquery.colorpicker-swatchesswitcher');
elgg_require_js('jquery.colorpicker-cmyk');
elgg_require_js('jquery.colorpicker-cmyk-percentage');


$vars['class'] .= $vars['class'] ? " elgg-color-picker" : "elgg-color-picker";

$id = esope_unique_id('');
if (empty($vars['id'])) { $vars['id'] = "elgg-colorpicker-$id"; } else { $vars['id'] = $vars['id'] . " elgg-colorpicker-$id"; }

echo elgg_view('input/text', $vars);
echo '<span id="elgg-colorpicker-' . $id . '-formats"></span>';
?>

<script>
require(["jquery.colorpicker"], function() {
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

