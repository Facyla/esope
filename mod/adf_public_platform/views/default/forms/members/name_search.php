<?php

$params = array(
	'name' => 'name',
	'class' => 'mbm',
);
echo '<label for="name">' . elgg_echo('members:searchname') . '</label>';
echo elgg_view('input/text', $params);

echo elgg_view('input/submit', array('value' => elgg_echo('searchbyname')));
