<?php
if (elgg_is_logged_in()) { return; }

echo '<div class="theme_transitions2-public-comment-form"><blockquote>' . elgg_echo('transitions:accountrequired') . '</blockquote></div>';

