<?php
// From : Lorea - https://gitorious.org/lorea/microthemes
elgg_load_css('elgg.input.colorpicker');
elgg_load_js('elgg.input.colorpicker');
$vars['class'] = $vars['class'] ? " elgg-color-picker" : "elgg-color-picker";
echo elgg_view('input/text', $vars);

