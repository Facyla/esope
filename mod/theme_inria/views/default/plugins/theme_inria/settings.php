<?php
// Strip any space so we can explode as an array + also replace ; by ,
$vars['entity']->animators = str_replace(array(' ', ';'), array('', ','), $vars['entity']->animators);

echo elgg_echo('theme_inria:settings:animators:details');
echo "<p>" . elgg_echo('theme_inria:settings:animators:page') . " : <a target=\"blank\" href=\"" . $vars['url'] . 'inria/animation">' . $vars['url'] . "inria/animation</a></p>";
echo "<p>" . elgg_echo('theme_inria:settings:animators:members') . " : <a target=\"blank\" href=\"" . $vars['url'] . 'members">' . $vars['url'] . "members</a></p>";

echo '<p><label style="clear:left;">' . elgg_echo('theme_inria:settings:animators') . '</label>';
echo elgg_view('input/text', array('name' => 'params[animators]', 'value' => $vars['entity']->animators)) . '<br />';
echo '</p>';

