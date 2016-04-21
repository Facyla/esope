<?php
// Note : this version uses vendors/jquery-colorpicker : works nicely but no transparency support

elgg_load_css('jquery.colorpicker');
elgg_require_js('jquery.colorpicker');

$vars['class'] .= $vars['class'] ? " elgg-color-picker" : "elgg-color-picker";

$vars['style'] = "background-color:{$vars['value']}";

$id = esope_unique_id('');
if (empty($vars['id'])) { $vars['id'] = "elgg-colorpicker-$id"; }
else { $vars['id'] = $vars['id'] . " elgg-colorpicker-$id"; }

echo elgg_view('input/text', $vars);

?>
<script>
require(["jquery.colorpicker"], function() {
	$('#elgg-colorpicker-<?php echo $id; ?>').ColorPicker({
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		},
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#elgg-colorpicker-<?php echo $id; ?>').css('backgroundColor', '#' + hex);
		}
	});
});
</script>

