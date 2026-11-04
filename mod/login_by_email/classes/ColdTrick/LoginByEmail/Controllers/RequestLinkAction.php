<?php

namespace ColdTrick\LoginByEmail\Controllers;

use Elgg\Controllers\GenericAction;
use Elgg\Exceptions\Http\BadRequestException;
use Elgg\Exceptions\Http\UnauthorizedException;
use Elgg\Http\OkResponse;
use Elgg\Values;

/**
 * Request a login link
 */
class RequestLinkAction extends GenericAction {
	
	protected ?\ElggUser $user = null;
	
	/**
	 * {@inheritdoc}
	 */
	protected function validate(): void {
		$username = $this->request->getParam('username');
		if (empty($username)) {
			throw new BadRequestException(elgg_echo('error:missing_data'));
		}
		
		$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function () use ($username) {
			return elgg_get_user_by_username($username, true);
		});
		if (!$user instanceof \ElggUser) {
			throw new UnauthorizedException(elgg_echo('login:baduser'));
		}
		
		$this->user = $user;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function executeBefore(): void {
		if (!$this->isWhitelisted($this->user)) {
			throw new UnauthorizedException(elgg_echo('login:baduser'));
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(): void {
		$session = elgg_get_session();
		
		$referer = $session->get('last_forward_from');
		if (empty($referer) && !empty($returntoreferer)) {
			$referer = _elgg_services()->request->headers->get('Referer');
		}
		
		$code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
		
		$code_validity = (int) elgg_get_plugin_setting('code_validity', 'login_by_email');
		if ($code_validity < 1) {
			$code_validity = 5;
		}
		
		$session->set('login_by_email_code', $code);
		$session->set('login_by_email_code_expires', Values::normalizeTimestamp("+{$code_validity} minutes"));
		$session->set('login_by_email_referer', $referer);
		$session->set('login_by_email_user_guid', $this->user->guid);
		
		$this->user->notify('request_login_code', $this->user, [
			'code' => $code,
			'referer' => $referer,
		]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function success(): OkResponse {
		return elgg_ok_response('',
			elgg_echo('login_by_email:action:request_link:success'),
			elgg_generate_url('default:login_by_email:code')
		);
	}
	
	/**
	 * Check if a given user is whitelisted to be allowed to use login by email
	 *
	 * @param \ElggUser $user user to check
	 *
	 * @return bool
	 */
	protected function isWhitelisted(\ElggUser $user): bool {
		if ($user->isAdmin()) {
			return true;
		}
		
		$whitelist = elgg_get_plugin_setting('whitelist_users', 'login_by_email');
		if (empty($whitelist)) {
			return true;
		}
		
		$whitelist = json_decode($whitelist, true);
		return in_array($user->guid, $whitelist);
	}
}
