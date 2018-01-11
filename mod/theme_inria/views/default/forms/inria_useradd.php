<?php
	/**
	 * Elgg add user form. 
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	
/**
 * Elgg add user form.
 *
 * @package Elgg
 * @subpackage Core
 * 
 */

$emails = get_input('email', '');
$emails = explode(',', $emails);
//$username = get_input('username', '');
$name = get_input('name', '');
$organisation = get_input('organisation', '');
$briefdescription = get_input('briefdescription', '');
$group_guid = get_input('group_guid', '');
$group_invite = get_input('group_invite'); // hide group select if enabled
$message = get_input('message', '');
$reason = get_input('reason', '');
//$password = generate_random_cleartext_password();

if (elgg_is_sticky_form('useradd')) {
	extract(elgg_get_sticky_values('useradd'));
	elgg_clear_sticky_form('useradd');
}



// Groupes : pas de sélecteur si invité depuis un groupe
if ($group_invite == 'yes') {
	$group = get_entity($group_guid);
	if (elgg_instanceof($group, 'group')) {
		echo elgg_view('input/hidden', array('name' => 'group_invite', 'value' => 'yes'));
		echo '<p><strong><img src="' . $group->getIconURL(array('size' => 'tiny')) . '" class="float" />&nbsp;' . elgg_echo('theme_inria:useradd:group', array($group->name)) . '</strong></p>';
		if (empty($reason)) { $reason = elgg_echo('theme_inria:useradd:group', array($group->name)); }
		echo '<br />';
	}
}


// Champs "personnels"
if (sizeof($emails) > 1) {
	echo '<table class="elgg-table">';
		echo '<thead>';
			echo '<tr>';
				echo '<th>' . elgg_echo('theme_inria:useradd:email') . '</th>';
				echo '<th>' . elgg_echo('theme_inria:useradd:name') . '</th>';
				echo '<th>' . elgg_echo('theme_inria:useradd:organisation') . '</th>';
				echo '<th>' . elgg_echo('theme_inria:useradd:fonction') . '</th>';
			echo '</tr>';
		echo '</thead>';

		echo '<tbody>';
			foreach ($emails as $email) {
				echo '<tr>';
					echo '<td>';
						echo '<p>' . elgg_view('input/email', array('name' => 'email[]', 'value' => $email, 'required' => true)) . '</label></p>';
					echo '</td>';

					//echo '<p><label>' . elgg_echo('theme_inria:useradd:username') . '' . elgg_view('input/text', array('name' => 'username[]', 'value' => $username, 'required' => true)) . '</label></p>';

					//echo '<p><label>' . elgg_echo('theme_inria:useradd:password') . '' . elgg_view('input/text', array('name' => 'password[]', 'value' => $password, 'required' => true)) . '</label></p>';

					echo '<td>';
						echo '<p>' . elgg_view('input/text', array('name' => 'name[]', 'value' => $name, 'required' => true)) . '</label></p>';
					echo '</td>';

					echo '<td>';
						echo '<p>' . elgg_view('input/tags', array('name' => 'organisation[]', 'value' => $organisation, 'required' => true, 'placeholder' => elgg_echo('theme_inria:useradd:organisation:placeholder'))) . '</label></p>';
					echo '</td>';

					echo '<td>';
						echo '<p>' . elgg_view('input/text', array('name' => 'briefdescription[]', 'value' => $briefdescription)) . '</label></p>';
					echo '</td>';
				echo '</tr>';
			}
		echo '</tbody>';
	echo '</table>';
	echo '<br />';
	echo '<br />';
	
} else {
	$email = $emails[0];
	echo '<p><label>' . elgg_echo('theme_inria:useradd:email') . '' . elgg_view('input/email', array('name' => 'email', 'value' => $email, 'required' => true)) . '</label></p>';

	//echo '<p><label>' . elgg_echo('theme_inria:useradd:username') . '' . elgg_view('input/text', array('name' => 'username', 'value' => $username, 'required' => true)) . '</label></p>';

	//echo '<p><label>' . elgg_echo('theme_inria:useradd:password') . '' . elgg_view('input/text', array('name' => 'password', 'value' => $password, 'required' => true)) . '</label></p>';

	echo '<p><label>' . elgg_echo('theme_inria:useradd:name') . '' . elgg_view('input/text', array('name' => 'name', 'value' => $name, 'required' => true)) . '</label></p>';

	echo '<p><label>' . elgg_echo('theme_inria:useradd:organisation') . '' . elgg_view('input/tags', array('name' => 'organisation', 'value' => $organisation, 'required' => true, 'placeholder' => elgg_echo('theme_inria:useradd:organisation:placeholder'))) . '</label></p>';

	echo '<p><label>' . elgg_echo('theme_inria:useradd:fonction') . '' . elgg_view('input/text', array('name' => 'briefdescription', 'value' => $briefdescription)) . '</label></p>';
}


// Groupes : sélecteur visible mais placé plus loin si on invite sans passer par un groupe
if ($group_invite != 'yes') {
	// @TODO : use custom, simpler and multiple group select
	$groups = elgg_get_entities(array('type' => 'group', 'limit' => false));
	//$groups_options = array('' => elgg_echo('option:none')); // for select only (not for multiselect)
	$groups_options = array();
	foreach ($groups as $ent) { $groups_options[$ent->guid] = $ent->name; }
	if (elgg_is_admin_logged_in()) {
		// all groups
		//echo '<p><label>' . elgg_echo('theme_inria:useradd:groups') . '<br /><em>' . elgg_echo('theme_inria:useradd:groups:details:admin') . '</em>' . elgg_view('input/groups_select', array('name' => 'group_guid', 'value' => $group_guid, 'scope' => 'all')) . '</label></p>';
		echo '<p><label>' . elgg_echo('theme_inria:useradd:groups') . '<br /><em>' . elgg_echo('theme_inria:useradd:groups:details:admin') . '</em>' . elgg_view('input/multiselect', array('name' => 'group_guid', 'value' => $group_guid, 'options_values' => $groups_options)) . '</label></p>';
	} else {
		/*
		// known groups only
		//echo '<p><label>' . elgg_echo('theme_inria:useradd:groups') . '<br /><em>' . elgg_echo('theme_inria:useradd:groups:details') . '</em>' . elgg_view('input/groups_select', array('name' => 'group_guid', 'value' => $group_guid, 'scope' => 'member')) . '</label></p>';
		echo '<p><label>' . elgg_echo('theme_inria:useradd:groups') . '<br /><em>' . elgg_echo('theme_inria:useradd:groups:details') . '</em>' . elgg_view('input/multiselect', array('name' => 'group_guid', 'value' => $group_guid, 'options_values' => $groups_options)) . '</label></p>';
		*/
	}
}


echo '<p><label>' . elgg_echo('theme_inria:useradd:message') . '<br /><em>' . elgg_echo('theme_inria:useradd:message:details') . '</em>' . elgg_view('input/plaintext', array('name' => 'message', 'value' => $message, 'required' => true)) . '</label></p>';

echo '<p><label>' . elgg_echo('theme_inria:useradd:reason') . '<br /><em>' . elgg_echo('theme_inria:useradd:reason:details') . '</em>' . elgg_view('input/plaintext', array('name' => 'reason', 'value' => $reason, 'required' => true)) . '</label></p>';


echo '<div class="elgg-foot">';
	echo elgg_view('input/submit', array('value' => elgg_echo('theme_inria:useradd:register')));
echo '</div>';

