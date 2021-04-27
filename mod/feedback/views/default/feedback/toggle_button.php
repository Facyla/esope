<?php
// Feedback button

$imgurl = elgg_get_site_url() . 'mod/feedback/graphics/';

echo '<img src="' . $imgurl . 'slide-button-open.png" alt="' . elgg_echo('feedback:label') . '" title="' . elgg_echo('feedback:label') . '" class="feedback-toggle-link" />';
echo '<img src="' . $imgurl . 'slide-button-close.png" alt="'.elgg_echo('feedback:label').'" title="'.elgg_echo('feedback:label').'" class="feedback-toggle-link hidden" />';
echo '<div class="clearfloat"></div>';

