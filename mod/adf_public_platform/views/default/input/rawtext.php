<?php
/**
 * Elgg raw text input
 * Just like input/longtext, except the WYSIWYG editor is not enabled at startup
 */

if (!empty($vars['class'])) $vars['class'] = $vars['class'] . ' elgg-input-rawtext';
else $vars['class'] = 'elgg-input-rawtext';

echo elgg_view('input/longtext', $vars);

