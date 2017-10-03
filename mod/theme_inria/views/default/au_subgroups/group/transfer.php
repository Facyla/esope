<?php
namespace AU\SubGroups;

// Iris : admin global seulement
if (!elgg_is_admin_logged_in()) { return; }

$group = elgg_get_page_owner_entity();
$create_page = get_input('au_subgroup', false);

if (elgg_instanceof($group, 'group') && !$create_page) {

	$title = elgg_echo('au_subgroups:move:edit:title');

	$form = elgg_view_form('au_subgroups/transfer');

	echo "<div>";
	// ESOPE : add specific class for better theming
	echo elgg_view_module('info', $title, $form, array('class' => 'au_subgroups-transfer-form'));
	echo "</div>";
}
