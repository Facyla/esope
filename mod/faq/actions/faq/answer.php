<?php
/**
 * A Frequently Asked Question Plugin
 *
 * @module faq
 * @author ColdTrick
 * @copyright ColdTrick 2009
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @link http://www.coldtrick.com
 *
 * Updated for Elgg 1.8 and newer by iionly
 * iionly@gmx.de
 */

$guid = get_input("guid");
$question = get_input("question");
$orgQuestion = get_input("originalQuestion");
$addFAQ = get_input("add");
$answer = get_input("textanswer".$guid);
$oldCat = get_input("oldCat");
$newCat = get_input("newCat");
$access = (int)get_input("access");

if(!empty($guid) && !empty($question) && !empty($orgQuestion) && !empty($addFAQ) && !empty($answer)) {
	$faq = get_entity($guid);

	if($faq->getSubtype() == "faq") {

		if($addFAQ == "yes") {
			// Add to FAQ and answer to User
			if($oldCat == "newCat" && !empty($newCat)) {
				$cat = ucfirst(strtolower($newCat));
			} else {
				$cat = ucfirst(strtolower($oldCat));
			}
			if(!empty($cat)) {
				// valid category, lets continue
				$user = get_user($faq->owner_guid);

				// Was the question adjusted?
				if($question == $orgQuestion) {
					$same = true;
				} else {
					$same = false;
				}

				if(!$same) {
					$faq->question = $question;
				}

				$faq->answer = $answer;
				$faq->category = $cat;
				$faq->access_id = $access;

				$faq->container_guid = elgg_get_config('site_guid');
				$faq->owner_guid = elgg_get_config('site_guid');

				if(elgg_delete_metadata(array('guid' => $faq->guid, 'metadata_name' => "userQuestion", 'metadata_value' => true, 'limit' => 0))) {
					if($faq->save()) {
						$url = elgg_get_site_url() . "faq/list?categoryId=" . elgg_get_metastring_id($faq->category) . "#qID" . $faq->guid;
						$user_language = ($user->language) ? $user->language : (($site_language = elgg_get_config('language')) ? $site_language : 'en');
						if($same) {
							// notify user, question added and not adjusted
							$subject = elgg_echo("faq:answer:notify:subject", array(), $user_language);
							$body = elgg_echo("faq:answer:notify:message:added:same", array($question, $url), $user_language);
						} else {
							// notify user, question added and adjusted
							$subject = elgg_echo("faq:answer:notify:subject", array(), $user_language);
							$body = elgg_echo("faq:answer:notify:message:added:adjusted", array($orgQuestion, $question, $url), $user_language);
						}
						$result = array();
						$result[$user->guid]['message'] = messages_send($subject, $body, $user->guid, elgg_get_logged_in_user_guid(), 0, false, false);
						$result[] = notify_user($user->guid, elgg_get_logged_in_user_guid(), $subject, $body, array(), 'email');
						if(in_array(true, $result)) {
							system_message(elgg_echo("faq:answer:success:added:send"));
						} else {
							register_error(elgg_echo("faq:answer:error:added:not_send"));
						}
					} else {
						register_error(elgg_echo("faq:answer:error:save"));
					}
				} else {
					register_error(elgg_echo("faq:answer:error:remove"));
				}
			} else {
				register_error(elgg_echo("faq:answer:error:no_cat"));
			}
		} else {
			// Do not add to FAQ, just answer to the User
			$user = get_user($faq->owner_guid);
			$user_language = ($user->language) ? $user->language : (($site_language = elgg_get_config('language')) ? $site_language : 'en');
			if($question == $orgQuestion) {
				$subject = elgg_echo("faq:answer:notify:subject", array(), $user_language);
				$body = elgg_echo("faq:answer:notify:not_added:same", array($question, $answer), $user_language);
			} else {
				$subject = elgg_echo("faq:answer:notify:subject", array(), $user_language);
				$body = elgg_echo("faq:answer:notify:not_added:adjusted", array($orgQuestion, $question, $answer), $user_language);
			}
			$result = array();
			$result[$user->guid]['message'] = messages_send($subject, $body, $user->guid, elgg_get_logged_in_user_guid(), 0, false, false);
			$result[] = notify_user($user->guid, elgg_get_logged_in_user_guid(), $subject, $body, array(), 'email');

			$faq->delete();

			if(in_array(true, $result)) {
				system_message(elgg_echo("faq:answer:success:not_added:send"));
			} else {
				register_error(elgg_echo("faq:answer:error:not_added:not_send"));
			}
		}
	} else {
		register_error(elgg_echo("faq:answer:error:no_faq"));
	}
} else {
	register_error(elgg_echo("faq:answer:error:input"));
}

forward(REFERER);
