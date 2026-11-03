<?php

namespace ColdTrick\LoginByEmail\Notifications;

use Elgg\Notifications\InstantNotificationEventHandler;

/**
 * Send a notification to the user with a unique login code/link
 */
class RequestLoginCodeHandler extends InstantNotificationEventHandler {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		$site = elgg_get_site_entity();
		
		return elgg_echo('login_by_email:notification:request_link:subject', [$site->getDisplayName()]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return $this->getNotificationSubject($recipient, $method);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$site = elgg_get_site_entity();
		
		$code_validity = (int) elgg_get_plugin_setting('code_validity', 'login_by_email');
		if ($code_validity < 1) {
			$code_validity = 5;
		}
		
		$code = $this->getParam('code');
		$referer = $this->getParam('referer');
		
		$link = elgg_generate_url('default:login_by_email:confirm', [
			'guid' => $recipient->guid,
			'r' => $referer,
		]);
		
		return elgg_echo('login_by_email:notification:request_link:message', [
			$site->getDisplayName(),
			elgg_http_get_signed_url($link, "+{$code_validity} minutes"),
			elgg_format_element('span', ['style' => 'font-size: 2rem; line-height: 2rem;'], $code),
		]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationMethods(): array {
		return ['email'];
	}
}
