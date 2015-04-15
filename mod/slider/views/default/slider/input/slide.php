<?php

// Use rawtext input if available (longtext with wysiwyg editor disabled at startup)
$longtext_input = 'input/plaintext';
if (elgg_view_exists('input/rawtext')) { $longtext_input = 'input/rawtext'; }

// Set default content
if (empty($vars['value'])) { $vars['value'] = '<div class="textSlide">' . "\n\n" . '</div>'; }

echo '<div class="slider-edit-slide">
		<a href="javascript:void(0);" class="slider-edit-delete-slide" title="' . elgg_echo('slider:edit:deleteslide') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>
		<label>' . elgg_echo('slider:edit:slide') . ' ' . elgg_view($longtext_input, array('name' => 'slides[]', 'value' => $vars['value'])) . '</label>
	</div>';


