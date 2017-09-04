<?php

$list = elgg_extract('list', $vars);

if (empty($list)) {
	echo elgg_echo('site_notifications:empty');
	return true;
}

// Toggle all
echo '<p class="select-all"><label><input type="checkbox" id="checkAll" onClick="javascript: $(\'.elgg-item-object-site_notification:not(.hidden) input[type=checkbox]\').not(this).prop(\'checked\', this.checked);" />' . elgg_echo('theme_inria:selectall') . '</label></p>';

echo "<div class='site-notifications-container'>";
echo $list;
echo "</div>";

echo '<div class="elgg-foot site-notifications-buttonbank">';

echo elgg_view('input/submit', array(
	'value' => elgg_echo('delete'),
	'name' => 'delete',
	'class' => 'elgg-button-delete',
	'title' => elgg_echo('deleteconfirm:plural'),
	'data-confirm' => elgg_echo('deleteconfirm:plural')
));

echo elgg_view('input/button', array(
	'value' => elgg_echo('site_notifications:toggle_all'),
	'class' => 'elgg-button elgg-button-cancel',
	'id' => 'site-notifications-toggle',
));

echo '</div>';
