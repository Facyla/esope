<?php
/**
 * A Frequently Asked Question Plugin
 *
 * @module faq
 * @author ColdTrick
 * @copyright ColdTrick 2009-2015
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @link http://www.coldtrick.com
 *
 * Updated for Elgg 1.8 and newer by iionly
 * iionly@gmx.de
 */

$question = get_input("question");
$guid = (int)get_input("userGuid");

if(!empty($question) && !empty($guid)) {
	$user = get_user($guid);

	if(!empty($user)) {
		$faq = new FAQObject();

		$faq->container_guid = $user->guid;
		$faq->owner_guid = $user->guid;

		$faq->question = $question;
		$faq->userQuestion = true;

		if($faq->save()) {
			$admins = elgg_get_admins(array('order_by' => 'time_created asc'));
			$notify = array();
			$user_language = ($user->language) ? $user->language : (($site_language = elgg_get_config('language')) ? $site_language : 'en');
			$subject = elgg_echo("faq:ask:new_question:subject", array(), $user_language);
			$message = elgg_echo("faq:ask:new_question:message", array($question), $user_language);
			$notify[$user->guid]['message'] = messages_send($subject, $message, $user->guid, $admins[0]->guid, 0, false, false);
			$notify[] = notify_user($user->guid, $admins[0]->guid, $subject, $message, array(), 'email');
			$admins_notified = notifyAdminNewQuestion();

			if(in_array(true, $notify)) {
				system_message(elgg_echo("faq:ask:new_question:send"));
			} else {
				register_error(elgg_echo("faq:ask:error:not_send"));
			}
		} else {
			register_error("faq:ask:error:save");
		}
	} else {
		register_error("faq:ask:error:no_user");
	}
} else {
	register_error("faq:ask:error:input");
}

forward(elgg_get_site_url() . "faq");
