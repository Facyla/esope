<?php

namespace Facyla\Survey;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
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
		// Extend CSS with custom styles
		elgg_extend_view('elgg.css', 'survey/main.css', 900);
		//elgg_extend_view('admin.css', 'survey/admin.css', 900);
		
		// Set up menu
		elgg_register_menu_item('site', array('name' => 'survey', 'href' => 'survey', 'text' => elgg_echo('survey')));
		
		// Extend hover-over menu
		elgg_extend_view('profile/menu/links','survey/menu');


		// notifications
		$send_notification = elgg_get_plugin_setting('send_notification', 'survey');
		if (!$send_notification || $send_notification != 'no') {
			elgg_register_notification_event('object', 'survey', array('create'));
			elgg_register_plugin_hook_handler('prepare', 'notification:publish:object:survey', 'survey_prepare_notification');
		}



		// register the JavaScript (must be registered because php file...)
		/*
		$js = elgg_get_simplecache_url('js', 'survey/survey');
		elgg_register_simplecache_view('js/survey/survey');
		elgg_register_js('elgg.survey.survey', $js);
		*/
		//elgg_require_js('survey/survey');
		elgg_define_js('survey/survey', ['src' => elgg_get_simplecache_url('js/survey/survey.js')]);
		
		/*
		$js = elgg_get_simplecache_url('js', 'survey/edit');
		elgg_register_simplecache_view('js/survey/edit');
		elgg_register_js('elgg.survey.edit', $js);
		*/
		elgg_define_js('survey/edit', ['src' => elgg_get_simplecache_url('js/survey/edit.js')]);

		// add group widget
		$group_survey = elgg_get_plugin_setting('group_survey', 'survey');
		if (!$group_survey || $group_survey != 'no') {
			elgg_extend_view('groups/tool_latest', 'survey/group_module');
		}

		if (!$group_survey || ($group_survey == 'yes_default')) {
			elgg()->group_tools->register('survey', ['label' => elgg_echo('survey:enable_survey'), 'default_on' => true]);
		} else if ($group_survey == 'yes_not_default') {
			elgg()->group_tools->register('survey', ['label' => elgg_echo('survey:enable_survey'), 'default_on' => false]);
		}
		
		
		//add widgets
		// @TODO
		/*
		elgg_register_widget_type('survey', elgg_echo('survey:my_widget_title'), elgg_echo('survey:my_widget_description'));
		elgg_register_widget_type('latestsurvey', elgg_echo('survey:latest_widget_title'), elgg_echo('survey:latest_widget_description'), array("dashboard"));
		$survey_front_page = elgg_get_plugin_setting('front_page','survey');
		if ($survey_front_page == 'yes') {
			elgg_register_widget_type('survey_individual', elgg_echo('survey:individual'), elgg_echo('survey_individual:widget:description'), array("dashboard"));
		}
		if (elgg_is_active_plugin('widget_manager')) {
			elgg_register_widget_type('latestsurvey_index', elgg_echo('survey:latest_widget_title'), elgg_echo('survey:latest_widget_description'), array("index"));
			if (!$group_survey || $group_survey != 'no') {
				elgg_register_widget_type('latestgroupsurvey', elgg_echo('survey:latestgroup_widget_title'), elgg_echo('survey:latestgroup_widget_description'), array("groups"));
			}
			if ($survey_front_page == 'yes') {
				elgg_register_widget_type('survey_individual_index', elgg_echo('survey:individual'), elgg_echo('survey_individual:widget:description'), array("index"));
			}

			//register title urls for widgets
			elgg_register_plugin_hook_handler('widget_url', 'widget_manager', "survey_widget_urls", 499);
			//elgg_register_plugin_hook_handler("entity:url", "object", "survey_widget_urls"); // Elgg 1.10
		}
		*/

		
		
	}
	
	public function activate() {
		elgg_set_entity_class('object', 'survey', 'ElggSurvey');
		elgg_set_entity_class('object', 'survey_question', 'ElggSurveyQuestion');
	}
	
	public function desactivate() {
	}
	
	
}
