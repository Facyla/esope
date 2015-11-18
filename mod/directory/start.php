<?php
/**
 * Directory plugin : manage people and organisations contacts
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'directory_init');


/**
 * Init directory plugin.
 */
function directory_init() {
	
	elgg_extend_view('css', 'directory/css');
	
	/*
	// Register PHP library - use with : elgg_load_library('elgg:directory');
	elgg_register_library('elgg:directory', elgg_get_plugins_path() . 'directory/lib/directory.php');
	
	// Register JS script - use with : elgg_load_js('directory');
	elgg_register_js('directory', '/mod/directory/vendors/directory.js', 'head');
	
	// Register CSS - use with : elgg_load_css('directory');
	elgg_register_simplecache_view('css/directory');
	$directory_css = elgg_get_simplecache_url('css', 'directory');
	elgg_register_css('directory', $directory_css);
	*/
	
		// register the JavaScript (autoloaded in 1.10)
	$js = elgg_get_simplecache_url('js', 'directory/directory');
	elgg_register_js('elgg.directory.directory', $js, 'footer');
	
	// Register a URL handler for directory
	elgg_register_plugin_hook_handler('entity:url', 'object', 'directory_url');
	
	// Register for search.
	elgg_register_entity_type('object', 'directory');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "directory_icon_hook");
	
	// Register actions
	$actions_path = elgg_get_plugins_path() . 'directory/actions/directory/';
	elgg_register_action("directory/edit", $actions_path . 'edit.php');
	elgg_register_action("directory/delete", $actions_path . 'delete.php');
	elgg_register_action("directory/add_relation", $actions_path . 'add_relation.php');
	//elgg_register_action("directory/addentity", $actions_path . 'addentity.php');
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'directory');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'directory');
	}
	*/
	
	// Register a page handler on "directory/"
	elgg_register_page_handler('directory', 'directory_page_handler');
	
	
}


// Page handler
// Loads pages located in directory/pages/directory/
function directory_page_handler($page) {
	$base = elgg_get_plugins_path() . 'directory/pages/directory';
	switch ($page[0]) {
		case 'icon':
			set_input('guid', $page[1]);
			set_input('size', $page[2]);
			include "$base/icon.php";
			break;
		case 'embed':
			set_input('display', true);
			set_input('id', $page[1]);
			set_input('subtype', $page[2]);
			include "$base/embed.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base/edit.php";
			break;
		case 'add':
			set_input('subtype', $page[1]);
			include "$base/edit.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		case 'person':
		case 'organisation':
		case 'directory':
		default:
			set_input('subtype', $page[0]);
			include "$base/index.php";
	}
	return true;
}


/* Populates the ->getUrl() method for directory objects */
function directory_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'directory')) {
		return elgg_get_site_url() . 'directory/view/' . $entity->guid . '/' . elgg_get_friendly_title($entity->title);
	} else if (elgg_instanceof($entity, 'object', 'person')) {
		return elgg_get_site_url() . 'directory/view/' . $entity->guid . '/' . elgg_get_friendly_title($entity->title);
	} else if (elgg_instanceof($entity, 'object', 'organisation')) {
		return elgg_get_site_url() . 'directory/view/' . $entity->guid . '/' . elgg_get_friendly_title($entity->title);
	}
}


// Define object icon : custom or default
function directory_icon_hook($hook, $entity_type, $returnvalue, $params) {
	if (!empty($params) && is_array($params)) {
		$entity = $params["entity"];
		$size = $params["size"];
		if(elgg_instanceof($entity, "object", "directory")){
			if (!empty($entity->icontime)) {
				$icontime = "{$entity->icontime}";
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getOwnerGUID();
				$filehandler->setFilename("directory/" . $entity->getGUID() . $size . ".jpg");
				if ($filehandler->exists()) {
					//return elgg_get_site_url() . "directory/icon/{$entity->getGUID()}/$size/" . elgg_get_friendly_title($entity->title) . ".jpg";
					return elgg_get_site_url() . "directory/icon/{$entity->getGUID()}/$size/$icontime.jpg";
				}
			}
			return elgg_get_site_url() . "mod/directory/graphics/directory.png";
			//return false;
		} else if (elgg_instanceof($entity, "object", "person")){
			if (!empty($entity->icontime)) {
				$icontime = "{$entity->icontime}";
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getOwnerGUID();
				$filehandler->setFilename("directory/" . $entity->getGUID() . $size . ".jpg");
				if ($filehandler->exists()) {
					return elgg_get_site_url() . "directory/icon/{$entity->getGUID()}/$size/$icontime.jpg";
				}
			}
			return elgg_get_site_url() . "mod/directory/graphics/person.png";
			//return false;
		} else if (elgg_instanceof($entity, "object", "organisation")){
			if (!empty($entity->icontime)) {
				$icontime = "{$entity->icontime}";
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getOwnerGUID();
				$filehandler->setFilename("directory/" . $entity->getGUID() . $size . ".jpg");
				if ($filehandler->exists()) {
					return elgg_get_site_url() . "directory/icon/{$entity->getGUID()}/$size/$icontime.jpg";
				}
			}
			return elgg_get_site_url() . "mod/directory/graphics/organisation.png";
			//return false;
		}
	}
}



// Define the default data structure for Person
// https://schema.org/Person
function directory_data_person() {
	return array(
			'name' => 'text',
			'fname' => 'text',
			'lname' => 'text',
			'email' => 'text',
			'telephone' => 'text',
			'mobile' => 'text',
			'fax' => 'text',
			'address' => 'text',
			'postalcode' => 'text',
			'city' => 'text',
			'country' => 'text',
		);
}


// Define the default data structure for Organisation
// https://schema.org/Organization
function directory_data_organisation() {
	return array(
			'name' => 'text',
			'email' => 'text',
			'telephone' => 'text',
			'mobile' => 'text',
			'fax' => 'text',
			'address' => 'text',
			'postalcode' => 'text',
			'city' => 'text',
			'country' => 'text',
		);
}



