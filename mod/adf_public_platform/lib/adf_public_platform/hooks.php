<?php



/* Filtrage via le page_handler
 * 
 * Principes de conception : 
 * - ne filtre que si on l'a explicitement demandé quelque part (pas de modification du comportement par défaut
 * 
*/
function adf_platform_route($hook_name, $entity_type, $return_value, $parameters) {
	global $CONFIG;
	$home = $CONFIG->url;
	
	// Page handler et segments de l'URL
	// Note : les segments commencent après le page_handler (ex.: URL: groups/all donne 0 => 'all')
	$handler = $return_value['handler'];
	$segments = $return_value['segments'];
	//echo print_r($segments, true); // debug
	//register_error($handler . ' => ' . print_r($segments, true));
	//error_log('DEBUG externalmembers ROUTE : ' . $handler . ' => ' . print_r($segments, true));
	
	if (!elgg_is_logged_in()) {
		// Il n'y a verrouillage du profil que si cette option est explicitement activée (pour ne pas modifier le comportement par défaut)
		$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');
		if ($public_profiles == 'yes') {
			if ($handler == 'profile') {
				$username = $segments[0];
				if ($user = get_user_by_username($username)) {
					// Le profil n'est accessible que si l'user en a décidé ainsi, sinon => forward
					if ($user->public_profile != 'yes') {
						register_error("Profil inexistant ou non public.");
						forward($home);
					} else {
						//system_messages("Profil visible de l'extérieur.");
					}
				}
			}
		}
	}
	
	//	@todo : Pour tous les autres cas => déterminer le handler et ajuster le comportement
	//register_error("L'accès à ces pages n'est pas encore déterminé : " . $handler . ' / ' . print_r($segments, true));
	//error_log("L'accès à ces pages n'est pas encore déterminé : " . $handler . ' / ' . print_r($segments, true));
	
	/* Valeurs de retour :
	 * return false; // Interrompt la gestion des handlers
	 * return $parameters; // Laisse le fonctionnement habituel se poursuivre
	*/
	// Par défaut on ne fait rien du tout
	return $parameters;
}

function adf_platform_public_profile_hook($hook_name, $entity_type, $return_value, $parameters){
	$user_guid = (int) get_input('guid');
	$public_profile = get_input('public_profile');
	// On ne modifie que si le réglage global est actif
	// Attention : modifier l'access_id de l'user directement est une *fausse bonne idée* : ça pose de nombreux problème pour s'identifier, etc.
	// Si différent de 2 on ne s'identifie plus...
	$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');
	if ($public_profiles == 'yes') {
		if (!empty($user_guid) && !empty($public_profile)) {
			if ($user = get_user($user_guid)) {
				if ($user->canEdit()) {
					$user->public_profile = $public_profile;
					if ($user->save()) {
						system_message(elgg_echo('adf_platform:action:public_profile:saved'));
						if ($public_profile == 'yes') {
							system_message(elgg_echo('adf_platform:usersettings:public_profile:public'));
						} else {
							system_message(elgg_echo('adf_platform:usersettings:public_profile:private'));
						}
					} else {
						register_error(elgg_echo('adf_platform:action:public_profile:error'));
					}
				}
			}
		}
	}
}


/**
 * htmLawed filtering of data
 *
 * Called on the 'validate', 'input' plugin hook
 *
 * Triggers the 'config', 'htmlawed' plugin hook so that plugins can change
 * htmlawed's configuration. For information on configuraton options, see
 * http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s2.2
 *
 * @param string $hook	 Hook name
 * @param string $type	 The type of hook
 * @param mixed	$result Data to filter
 * @param array	$params Not used
 * @return mixed
 */
function adf_platform_htmlawed_filter_tags($hook, $type, $result, $params) {
	$var = $result;
	elgg_load_library('htmlawed');
	$htmlawed_config = array(
			// seems to handle about everything we need.
			// /!\ Liste blanche des balises autorisées
			//'elements' => 'iframe,embed,object,param,video,script,style',
			'safe' => false, // true est trop radical, à moins de lister toutes les balises autorisées ci-dessus
			// Attributs interdits
			'deny_attribute' => 'on*',
			// Filtrage supplémentaires des attributs autorisés (cf. start de htmLawed) : 
			// bloque tous les styles non explicitement autorisé
			//'hook_tag' => 'htmlawed_tag_post_processor',
			
			'schemes' => '*:http,https,ftp,news,mailto,rtsp,teamspeak,gopher,mms,callto',
			// apparent this doesn't work.
			// 'style:color,cursor,text-align,font-size,font-weight,font-style,border,margin,padding,float'
		);
	// add nofollow to all links on output
	if (!elgg_in_context('input')) { $htmlawed_config['anti_link_spam'] = array('/./', ''); }
	$htmlawed_config = elgg_trigger_plugin_hook('config', 'htmlawed', null, $htmlawed_config);
	if (!is_array($var)) {
		$result = htmLawed($var, $htmlawed_config);
	} else {
		array_walk_recursive($var, 'htmLawedArray', $htmlawed_config);
		$result = $var;
	}
	return $result;
}




// Permet l'accès à diverses pages en mode "walled garden"
function adf_public_platform_public_pages($hook, $type, $return_value, $params) {
	// Get and prepare valid domain config array from plugin settings
	$publicpages = elgg_get_plugin_setting('publicpages', 'adf_public_platform');
	$publicpages = preg_replace('/\r\n|\r/', "\n", $publicpages);
	// Add csv support - cut also on ";" and ","
	$publicpages = str_replace(array(' ', '<p>', '</p>'), '', $publicpages); // Delete all white spaces
	$publicpages = str_replace(array(';', ','), "\n", $publicpages);
	$publicpages = explode("\n",$publicpages);
	foreach ($publicpages as $publicpage) {
		if (!empty($publicpage)) $return_value[] = $publicpage;
	}
	/* Pages publiques ADF au 27 juillet 2012
	$return_value[] = 'pages/view/3792/charte-de-dpartements-en-rseaux';
	$return_value[] = 'pages/view/3819/mentions-lgales';
	$return_value[] = 'pages/view/3827/a-propos-de-dpartements-en-rseaux';
	$return_value[] = 'pages/group/3519/all';
	*/
	/* Les pages à rendre accessibles doivent correspondre	à l'URL complète
	$return_value[] = '';
	*/
	return $return_value;
}



function adf_platform_threads_topic_menu_setup($hook, $type, $return, $params){
	//return $return; // Pas besoin d'ajouter le form si on l'affiche d'entrée de jeu
	
	$entity = $params['entity'];
	
	elgg_load_library('elgg:threads');
	elgg_load_js('jquery.plugins.parsequery');
	elgg_load_js('elgg.threads');
	
	$group = $entity->getContainerEntity();
	$topic = threads_top($entity->guid);
	
	// Facyla : on limite ça aux objets : n'a pas de sens pour groupes et membres
	if(elgg_instanceof($entity, 'object') 
		&& ($group && $group->canWriteToContainer() || elgg_is_admin_logged_in()) 
		&& $topic 
		&& $topic->status != 'closed'
		) {
		$url = elgg_http_add_url_query_elements($topic->getURL(), array(
			'box' => 'reply',
			'guid' => $entity->guid,
		));
		//$url .= '#elgg_add_comment_' . $entity->guid;

		$options = array('name' => 'reply', 'href' => $url, 'text' => elgg_echo('reply'),'text_encode' => false, 'priority' => 200);
		$return[] = ElggMenuItem::factory($options);
	}
	return $return;
}


/* Modifications des menus de l'owner_block : sélectionne l'outil utilisé
 * Et supprime certains éléments de menu choisis du menu du membre, si demandé dans la config
 */
function adf_platform_owner_block_menu($hook, $type, $return, $params) {
	// Menu user
	if (elgg_instanceof(elgg_get_page_owner_entity(), 'user')) {
		$remove_user_tools = elgg_get_plugin_setting('remove_user_menutools', 'adf_public_platform');
		if (!empty($remove_user_tools)) $remove_user_tools = explode(',', $remove_user_tools);
		foreach ($return as $key => $item) {
			$name = $item->getName();
			//echo $name . ","; // debug: helps finding name if you don't want to look into each plugin hook
			if (in_array($name, $remove_user_tools)) unset($return[$key]);
			else if (elgg_in_context($name)) $item->setSelected();
		}
	} else {
		foreach ($return as $key => $item) {
			if (elgg_in_context($item->getName())) $item->setSelected();
		}
	}
	
	return $return;
}

/* Boutons des widgets */
function adf_platform_elgg_widget_menu_setup($hook, $type, $return, $params) {
	global $CONFIG;
	$urlicon = $CONFIG->url . 'mod/adf_public_platform/img/theme/';
	
	$widget = $params['entity'];
	$show_edit = elgg_extract('show_edit', $params, true);
	
	$widget_title = $widget->getTitle();
	$collapse = array(
			'name' => 'collapse',
			'text' => '<img src="' . $urlicon . 'masquer.png" alt="' . elgg_echo('widget:toggle', array($widget_title)) . '" />',
			'href' => "#elgg-widget-content-$widget->guid",
			'class' => 'masquer',
			'rel' => 'toggle',
			'priority' => 900
		);
	$return[] = ElggMenuItem::factory($collapse);
	
	if ($widget->canEdit()) {
		$delete = array(
				'name' => 'delete',
				'text' => '<img src="' . $urlicon . 'suppr.png" alt="' . elgg_echo('widget:delete', array($widget_title)) . '" />',
				'href' => "action/widgets/delete?widget_guid=" . $widget->guid,
				'is_action' => true,
				'class' => 'elgg-widget-delete-button suppr',
				'id' => "elgg-widget-delete-button-$widget->guid",
				'priority' => 900
			);
		$return[] = ElggMenuItem::factory($delete);

		if ($show_edit) {
			$edit = array(
					'name' => 'settings',
					'text' => '<img src="' . $urlicon . 'config.png" alt="' . elgg_echo('widget:editmodule', array($widget_title)) . '" />',
					'href' => "#widget-edit-$widget->guid",
					'class' => "elgg-widget-edit-button config",
					'rel' => 'toggle',
					'priority' => 800,
				);
			$return[] = ElggMenuItem::factory($edit);
		}
	}
	
	return $return;
}


if (elgg_is_active_plugin('au_subgroups')) {
		/**
	 * re/routes some urls that go through the groups handler
	 */
	function adf_platform_subgroups_groups_router($hook, $type, $return, $params) {
		au_subgroups_breadcrumb_override($return);
		
		// subgroup options
		if ($return['segments'][0] == 'subgroups') {
			elgg_load_library('elgg:groups');
			$group = get_entity($return['segments'][2]);
			if (!elgg_instanceof($group, 'group') || ($group->subgroups_enable == 'no')) {
				return $return;
			}
	
			elgg_set_context('groups');
			elgg_set_page_owner_guid($group->guid);
			
			switch ($return['segments'][1]) {
				case 'add':
					set_input('au_subgroup', true);
					set_input('au_subgroup_parent_guid', $group->guid);
					if (include(elgg_get_plugins_path() . 'au_subgroups/pages/add.php')) {
						return true;
					}
					break;
					
				case 'delete':
					if (include(elgg_get_plugins_path() . 'au_subgroups/pages/delete.php')) {
						return true;
					}
					break;
		
			case 'list':
			if (include(elgg_get_plugins_path() . 'adf_public_platform/pages/au_subgroups/list.php')) {
				return true;
			}
			break;
			}
		}
		
		// need to redo closed/open tabs provided by group_tools - if it's installed
		if ($return['segments'][0] == 'all' && elgg_is_active_plugin('group_tools')) {
			$filter = get_input('filter', false);
			
			if(empty($filter) && ($default_filter = elgg_get_plugin_setting("group_listing", "group_tools"))){
				$filter = $default_filter;
				set_input("filter", $default_filter);
			}
			
			if(in_array($filter, array("open", "closed", "alpha"))){
				au_subgroups_handle_openclosed_tabs();
				return true;
			}
		}
	}
}


