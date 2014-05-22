<?php
/**
 * Button area for showing the add widgets panel
 */
global $CONFIG;
$imgurl = $CONFIG->url . 'mod/theme_cocon/graphics/';
?>
<div class="elgg-widget-add-control">
	<div class="cocon-widget-add-control">
		<?php
			echo elgg_view('output/url', array(
				'href' => '#widgets-add-panel',
				'text' => '<img src="' . $imgurl . 'pictos/widgets_edit.png" />&nbsp;' . elgg_echo('widgets:add'),
				'class' => 'cocon-widget-add-button',
				'rel' => 'toggle',
			));
		?>
	</div>
	<div class="clearfloat"></div>
</div>

