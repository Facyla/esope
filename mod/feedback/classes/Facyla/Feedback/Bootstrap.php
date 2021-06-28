<?php

namespace Facyla\Feedback;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::boot()
	 */
	public function upgrade() {
		
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::boot()
	 */
	public function boot() {
		
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		// extend the site CSS
		elgg_extend_view('elgg.css', 'feedback/main.css');
		elgg_extend_view('admin.css', 'feedback/admin.css');
		
		//elgg_require_js('feedback/feedback');
		
		// extend the view
		if (elgg_get_plugin_setting("publicAvailable_feedback", "feedback") == "yes" || elgg_is_logged_in()) {
			elgg_extend_view('page/elements/footer', 'feedback/footer');
		}
		
		// create feedback page in admin section
		//elgg_register_admin_menu_item('administer', 'feedback', 'administer_utilities');
		elgg_register_menu_item('page', [
			'name' => 'administer_utilities:feedback',
			'href' => 'admin/administer_utilities/feedback',
			'text' => elgg_echo('admin:administer_utilities:feedback'),
			'section' => 'administer',
			'parent_name' => 'administer_utilities',
			'context' => 'admin',
		]);
		
		
		// Give access to feedbacks in groups
		$feedbackgroup = elgg_get_plugin_setting("feedbackgroup", "feedback");
		//if (!empty($feedbackgroup) && ($feedbackgroup != 'no') && elgg_is_logged_in()) {
		if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
			//gatekeeper();
			//group_gatekeeper();
			// Add group menu option if no feedback group specified (default = disabled)
			if ($feedbackgroup == 'grouptool') { add_group_tool_option('feedback', elgg_echo('feedback:enablefeedback'), false); }
			elgg_extend_view('groups/tool_latest','feedback/grouplisting', 100);
		}
		
		// Interception des commentaires
		// Set core notifications system to track the creation of new comments (might also have been enabled by other plugins)
		elgg_register_notification_event('object', 'comment', ['create']);
	}
	
}

