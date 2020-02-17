// <script>

/**
 * Javascript for the notifier plugin
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	/**
	 * Repositions the notifier popup
	 *
	 * @param {String} hook    'getOptions'
	 * @param {String} type    'ui.popup'
	 * @param {Object} params  An array of info about the target and source.
	 * @param {Object} options Options to pass to
	 *
	 * @return {Object}
	 */
	function popupHandler(hook, type, params, options) {
		if (!params.target.hasClass('elgg-notifier-popup')) {
			return;
		}

		// Due to elgg.ui.popup's design, there's no way to verify in a click handler whether the
		// click will actually be closing the popup after this hook. This is the only chance to verify
		// whether the popup is visible or not.
		if (params.target.is(':visible')) {
			// user clicked the icon to close, we're just letting it close
			return;
		}

		populatePopup();

		options.my = 'left top';
		options.at = 'left bottom';
		options.collision = 'fit none';
		return options;
	}

	/**
	 * Dismiss all unread notifications and then hide related UI elements.
	 *
	 * @return void
	 */
	function dismissAll() {
		// start delete on server but don't block
		elgg.action(this.href);

		// Hide notification count from topbar icon
		$('#notifier-new').addClass('hidden').html('');

		// Remove highlighting from the unread notifications one by one
		function dismiss() {
			var $unread = $('.elgg-notifier-unread:first');
			if ($unread.length) {
				$unread.removeClass('elgg-notifier-unread');
			} else {
				clearInterval(dismissing);
				// close popup
				$('body').trigger('click');
			}
		}

		var dismissing = setInterval(dismiss, 100);
		dismiss();

		// Hide the "Dismiss all" button
		$('#notifier-dismiss-all').addClass('hidden');

		return false;
	}

	/**
	 * Fetch notifications and display them in the popup module.
	 *
	 * @return void
	 */
	function populatePopup() {
		$('#notifier-popup > .elgg-body > ul').html('<li><div class="elgg-ajax-loader mtm mbm"></div></li>');

		elgg.get('notifier/popup', {
			success: function(output) {
				if (output) {
					// Add the received <li> elements into the list
					$('#notifier-popup > .elgg-body > ul').html(output);

					// Hide the "No notifications" texts
					$('.notifier-none').addClass('hidden');

					// Display the "View all" link
					$('#notifier-view-all').removeClass('hidden');

					// Check if there are unread notifications
					if ($('.elgg-notifier-unread').length) {
						// Display the "Dismiss all" icon
						$('#notifier-dismiss-all').removeClass('hidden');
					}
				} else {
					// remove the spinner
					$('#notifier-popup > .elgg-body > ul').html('');

					// Hide the "Dismiss all" icon & the "View all" link
					$('#notifier-dismiss-all, #notifier-view-all').addClass('hidden');

					// Display the "No notifications" text
					$('.notifier-none').removeClass('hidden');
				}
			}
		});
	}

	/**
	 * Dismiss single notification on click
	 * @returns {void}
	 */
	function dismissOne() {
		var id = $(this).closest('.elgg-item-object-notification').attr('id');
		var guid = id.substr(id.indexOf('elgg-object-') + "elgg-object-".length);
		elgg.action('action/notifier/dismiss_one', {
			data: {
				guid: guid,
			}
		});
	};

	$('#notifier-dismiss-all').on('click', dismissAll);

	$(document).on('click', '.elgg-item-object-notification:has(.elgg-notifier-unread) a', dismissOne);
	
	elgg.register_hook_handler('getOptions', 'ui.popup', popupHandler);
});
