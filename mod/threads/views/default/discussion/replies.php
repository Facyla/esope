<?php
/**
 * List replies
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['id']
 */

$id = isset($vars['id']) ? " id=\"{$vars['id']}\"" : "";
echo '<div'. $id .' class="mtl replies">';
echo threads_list_replies($vars['entity']->getGUID());
echo '</div>';
