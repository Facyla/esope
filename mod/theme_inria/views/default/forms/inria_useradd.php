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

$name = $username = $email = $password = $reason = '';
$password = generate_random_cleartext_password();

if (elgg_is_sticky_form('useradd')) {
	extract(elgg_get_sticky_values('useradd'));
	elgg_clear_sticky_form('useradd');
}


echo '<p><label>' . elgg_echo('theme_inria:useradd:email') . '' . elgg_view('input/email', array('name' => 'email', 'value' => $email, 'required' => true)) . '</label></p>';

//echo '<p><label>' . elgg_echo('theme_inria:useradd:username') . '' . elgg_view('input/text', array('name' => 'username', 'value' => $username)) . '</label></p>';

//echo '<p><label>' . elgg_echo('theme_inria:useradd:password') . '' . elgg_view('input/text', array('name' => 'password', 'value' => $password)) . '</label></p>';

echo '<p><label>' . elgg_echo('theme_inria:useradd:name') . '' . elgg_view('input/text', array('name' => 'name', 'value' => $name)) . '</label></p>';

echo '<p><label>' . elgg_echo('theme_inria:useradd:organisation') . '' . elgg_view('input/tags', array('name' => 'organisation', 'value' => $organisation)) . '</label></p>';

echo '<p><label>' . elgg_echo('theme_inria:useradd:fonction') . '' . elgg_view('input/text', array('name' => 'fonction', 'value' => $fonction)) . '</label></p>';

if (elgg_is_admin_logged_in()) {
	echo '<p><label>' . elgg_echo('theme_inria:useradd:groups') . '<br /><em>' . elgg_echo('theme_inria:useradd:groups:details:admin') . '</em>' . elgg_view('input/groups_select', array('name' => 'group_guid', 'value' => $group_guid, 'scope' => 'all')) . '</label></p>';
} else {
	echo '<p><label>' . elgg_echo('theme_inria:useradd:groups') . '<br /><em>' . elgg_echo('theme_inria:useradd:groups:details') . '</em>' . elgg_view('input/groups_select', array('name' => 'group_guid', 'value' => $group_guid, 'scope' => 'member')) . '</label></p>';
}


echo '<p><label>' . elgg_echo('theme_inria:useradd:message') . '<br /><em>' . elgg_echo('theme_inria:useradd:message:details') . '</em>' . elgg_view('input/plaintext', array('name' => 'message', 'value' => $message)) . '</label></p>';

echo '<p><label>' . elgg_echo('theme_inria:useradd:reason') . '<br /><em>' . elgg_echo('theme_inria:useradd:reason:details') . '</em>' . elgg_view('input/plaintext', array('name' => 'reason', 'value' => $reason)) . '</label></p>';


echo '<div class="elgg-foot">';
	echo elgg_view('input/submit', array('value' => elgg_echo('theme_inria:useradd:register')));
echo '</div>';

