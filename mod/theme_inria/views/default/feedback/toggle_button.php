<?php
// Feedback button

$imgurl = elgg_get_site_url() . 'mod/theme_inria/graphics/menus/';

// open
echo '<img src="' . $imgurl . 'feedback.png" alt="'.elgg_echo('feedback:label').'" title="'.elgg_echo('feedback:label').'" class="feedback-toggle-link hidden" />';
echo '<div class="clearfloat"></div>';
// close
echo '<img src="' . $imgurl . 'feedback.png" alt="' . elgg_echo('feedback:label') . '" title="' . elgg_echo('feedback:label') . '" class="feedback-toggle-link" />';

