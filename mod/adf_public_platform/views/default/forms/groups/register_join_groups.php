<?php
/**
* Elgg register form : extend with join groups
*/

if (elgg_get_plugin_setting('register_joingroups', 'adf_public_platform') != 'yes') { return; }

$group_guids = get_input('join_groups', false);
if (!$group_guids) {
	// Make it an array if not already (array only if form was already sent)
	if (!is_array($group_guids) || strpos($group_guids, ',')) {
		$group_guids = explode(',', $group_guids);
	}
}

// Choix des groupes
$groups = esope_get_joingroups('featured', 'open');
$content .= '<div class="clearfloat"></div>';
$content .= '<div id="register_joingroups">';
$content .= '<fieldset style="border:1px solid #333; padding:1ex; margin:2ex 0;">';
	$content .= '<legend style="padding:0 1ex;">' . elgg_echo('esope:register:joingroups') . '</legend>';
	$content .= '<p><em>' . elgg_echo('esope:register:joingroups:help') . '</em></p>';
	// Featured (open & public) groups
	$content .= '<div id="register_groups_featured">';
		foreach ($groups as $ent) {
			$content .= '<label><input type="checkbox" name="join_groups[]" value="' . $ent->guid . '" />';
			$content .= '<img src="' . $ent->getIcon('tiny') . '" /> ' . $ent->name . '</label><br />';
		}
		// Toggle more groups
		$content .= '<div class="clearfloat"></div><br />';
		$content .= '<p><a href="javascript:void(0);" onclick="$(\'#register_groups_featured\').toggle();$(\'#register_groups_full\').toggle();">' . elgg_echo('esope:register:morejoingroups') . '</a></p>';
	$content .= '</div>';
	// All open & public groups
	$content .= '<div id="register_groups_full" style="display:none;">';
		$groups = esope_get_joingroups('', 'open');
		//$content .= '<p>' . elgg_view('friends/picker',array('entities' => $groups, 'internalname' => 'groups', 'highlight' => 'all', 'value' => $group_guids)) . '</p>';
		foreach ($groups as $ent) {
			$content .= '<label><input type="checkbox" name="join_groups[]" value="' . $ent->guid . '" />';
			$content .= '<img src="' . $ent->getIcon('tiny') . '" /> ' . $ent->name . '</label><br />';
		}
	$content .= '</div>';
$content .= '</div>';

echo $content;

