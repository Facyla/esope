<?php

namespace Elgg;

use Elgg\Exceptions\LogicException;
use Elgg\Traits\Loggable;

/**
 * Forms service
 *
 * @internal
 * @since 2.3
 */
class FormsService {

	use Loggable;

	/**
	 * @var EventsService
	 */
	protected $events;
	
	/**
	 * @var ViewsService
	 */
	protected $views;

	/**
	 * @var bool
	 */
	protected $rendering;

	/**
	 * @var string
	 */
	protected $footer = '';

	/**
	 * Constructor
	 *
	 * @param ViewsService  $views  Views service
	 * @param EventsService $events Events service
	 */
	public function __construct(ViewsService $views, EventsService $events) {
		$this->views = $views;
		$this->events = $events;
	}

	/**
	 * Convenience function for generating a form from a view in a standard location.
	 *
	 * This function assumes that the body of the form is located at "forms/$action" and
	 * sets the action by default to "action/$action".  Automatically wraps the forms/$action
	 * view with a <form> tag and inserts the anti-csrf security tokens.
	 *
	 * @tip This automatically appends elgg-form-action-name to the form's class. It replaces any
	 * slashes with dashes (blog/save becomes elgg-form-blog-save)
	 *
	 * @example
	 * <code>echo elgg_view_form('login');</code>
	 *
	 * This would assume a "login" form body to be at "forms/login" and would set the action
	 * of the form to "http://yoursite.com/action/login".
	 *
	 * If elgg_view('forms/login') is:
	 * <input type="text" name="username" />
	 * <input type="password" name="password" />
	 *
	 * Then elgg_view_form('login') generates:
	 * <form action="http://yoursite.com/action/login" method="post">
	 *     ...security tokens...
	 *     <input type="text" name="username" />
	 *     <input type="password" name="password" />
	 * </form>
	 *
	 * @param string $action    The name of the action. An action name does not include
	 *                          the leading "action/". For example, "login" is an action name.
	 * @param array  $form_vars $vars passed to the "input/form" view
	 *                          - 'ajax' bool If true, the form will be submitted with an ajax request
	 * @param array  $body_vars $vars passed to the "forms/<action>" view
	 *
	 * @return string The complete form
	 */
	public function render(string $action, array $form_vars = [], array $body_vars = []): string {

		$defaults = [
			'action' => elgg_generate_action_url($action, [], false),
			'method' => 'post',
			'ajax' => false,
			'sticky_enabled' => false,
			'sticky_form_name' => $action,
			'sticky_ignored_fields' => [],
		];

		// append elgg-form class to any class options set
		$form_vars['class'] = elgg_extract_class($form_vars, [
			'elgg-form-' . preg_replace('/[^a-z0-9]/i', '-', $action)],
		);
		
		$form_vars = array_merge($defaults, $form_vars);

		if (!isset($form_vars['enctype']) && strtolower($form_vars['method']) == 'post') {
			$form_vars['enctype'] = 'multipart/form-data';
		}

		if (elgg_extract('ajax', $form_vars)) {
			$form_vars['class'][] = 'elgg-js-ajax-form';
			unset($form_vars['ajax']);
		}

		$form_vars['action_name'] = $action;
		
		$form_vars['ignore_empty_body'] = (bool) elgg_extract('ignore_empty_body', $form_vars, false);
		
		$form_vars['prevent_double_submit'] = (bool) elgg_extract('prevent_double_submit', $form_vars, true);
		
		if (!isset($form_vars['body'])) {
			// prepare body vars
			$body_vars = (array) $this->events->triggerResults('form:prepare:fields', $action, $form_vars, $body_vars);
			
			$this->rendering = true;
			$this->footer = '';

			// Render form body
			$body = $this->views->renderView("forms/{$action}", $body_vars);

			if (!empty($body)) {
				// Grab the footer if one was set during form rendering
				$body .= $this->views->renderView('elements/forms/footer', [
					'footer' => $this->getFooter(),
					'action_name' => $action,
					'body_vars' => $body_vars,
					'form_vars' => $form_vars,
				]);
			}
			
			$this->rendering = false;

			$form_vars['body'] = $body;
		}

		return elgg_view('input/form', $form_vars);
	}

	/**
	 * Sets form footer and defers its rendering until the form view and extensions have been rendered.
	 * Deferring footer rendering allows plugins to extend the form view while maintaining
	 * logical DOM structure.
	 * Footer will be rendered using 'elements/forms/footer' view after form body has finished rendering
	 *
	 * @param string $footer Footer
	 * @return void
	 * @throws LogicException
	 */
	public function setFooter(string $footer = ''): void {
		if (!$this->rendering) {
			throw new LogicException('Form footer can only be set and retrieved during form rendering, anywhere in elgg_view_form() call stack (e.g. form view, extending views, or view events)');
		}

		$this->footer = $footer;
	}

	/**
	 * Returns currently set footer
	 *
	 * @return string
	 * @throws LogicException
	 */
	public function getFooter(): string {
		if (!$this->rendering) {
			throw new LogicException('Form footer can only be set and retrieved during form rendering, anywhere in elgg_view_form() call stack (e.g. form view, extending views, or view events)');
		}

		return $this->footer;
	}
}
