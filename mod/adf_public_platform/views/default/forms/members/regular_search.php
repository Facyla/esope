<?php
/**
 * Simple members search form
 */
$params = array('name' => 'q', 'class' => 'mbm');
echo '<label for="q">' . elgg_echo('members:search') . '</label>';
echo elgg_view('input/text', $params);
echo elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'user'));
echo elgg_view('input/submit', array('value' => elgg_echo('search')));

