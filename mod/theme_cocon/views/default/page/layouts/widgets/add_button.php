<?php
/**
 * Button area for showing the add widgets panel
 */
?>
<div class="elgg-widget-add-control">
	<div class="cocon-widget-add-control">
		<?php
			echo elgg_view('output/url', array(
				'href' => '#widgets-add-panel',
				'text' => elgg_echo('widgets:add'),
				'class' => 'cocon-widget-add-button',
				'rel' => 'toggle',
			));
		?>
	</div>
	<div class="clearfloat"></div>
</div>

