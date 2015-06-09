<?php

// Use prefered editor if set, rawtext if available, and plaintext otherwise
// Prefered editor
if (!empty($vars['editor']) && elgg_view_exists('input/' . $vars['editor'])) {
	$longtext_input = 'input/' . $vars['editor'];
} else if (elgg_view_exists('input/rawtext')) {
	// Default editor, if available (longtext with wysiwyg editor disabled at startup)
	$longtext_input = 'input/rawtext';
} else {
	// Failsafe editor
	$longtext_input = 'input/plaintext';
	// Note : plain text editing should be used when adding new slides, 
	// to avoid adding tinymce editor with the same id (which would break editor toggle feature)
}

// Set default content
if (empty($vars['value'])) { $vars['value'] = '<div class="textSlide">' . "\n\n" . '</div>'; }

echo '<div class="slider-edit-slide">
		<a href="javascript:void(0);" class="slider-edit-delete-slide" title="' . elgg_echo('slider:edit:deleteslide') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>
		<label>' . elgg_echo('slider:edit:slide') . ' ' . elgg_view($longtext_input, array('name' => 'slides[]', 'value' => $vars['value'])) . '</label>
	</div>';


