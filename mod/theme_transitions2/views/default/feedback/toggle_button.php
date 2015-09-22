<?php
// Feedback button

$imgurl = elgg_get_site_url() . 'mod/theme_transitions2/graphics/';

echo '<img src="' . $imgurl . 'feedback.png" alt="' . elgg_echo('feedback:label') . '" title="' . elgg_echo('feedback:label') . '" class="feedback-toggle-link" />';
echo '<img src="' . $imgurl . 'feedback.png" alt="' . elgg_echo('feedback:label') . '" title="' . elgg_echo('feedback:label') . '" class="feedback-toggle-link hidden" />';


