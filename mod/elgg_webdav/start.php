<?php
/* Elgg webDAV server plugin
* 
 * @author : Florian DANIEL aka Facyla
 */

// Initialise log browser
elgg_register_event_handler('init','system','elgg_webdav');


/* Initialise the theme */
function elgg_webdav(){
	
	// CSS et JS
	elgg_extend_view('css', 'elgg_webdav/css');
	
	// Register WebDAV libraries
	elgg_register_library('elgg:webdav:sabreDAV', elgg_get_plugins_path() . 'elgg_webdav/vendors/SabreDAV/vendor/autoload.php');
	
	/*
	// Enable server
	if (elgg_get_plugin_setting('enable_webdav', 'elgg_webdav') == 'yes') 
	*/
	
	// WebDAV page handler
	elgg_register_page_handler('webdav', 'elgg_webdav_page_handler');
	
}


/* WebDAV home page and endpoints */
// Note that virtual is now the best endpoint
function elgg_webdav_page_handler($page) {
	$base = elgg_get_plugins_path() . 'elgg_webdav/pages/elgg_webdav';
	switch($page[0]) {
		case 'endpoint':
		case 'server':
			if (include_once "$base/server.php") return true;
			break;
		
		case 'public':
			//forward('webdav/virtual/public');
			// Read-only filesystem
			if (include_once "$base/server_public.php") return true;
			break;
		
		case 'member':
			//forward('webdav/virtual/users');
			if (include_once "$base/server_member.php") return true;
			break;
		
		case 'user':
			//forward('webdav/virtual/private');
			// GUID is mandatory to provide better security and RESTful URI
			if (!empty($page[1])) set_input($guid, $page[1]);
			if (include_once "$base/server_user.php") return true;
			break;
		
		case 'group':
			//forward('webdav/virtual/groups');
			// GUID is mandatory to provide better security and RESTful URI
			if (!empty($page[1])) set_input($guid, $page[1]);
			if (include_once "$base/server_group.php") return true;
			break;
		
		// NEW Main entry point
		case 'virtual':
			// GUID is mandatory to provide better security and RESTful URI
			if (!empty($page[1])) set_input('type', $page[1]);
			if (!empty($page[2])) set_input('guid', $page[2]);
			if (include_once "$base/server_virtual.php") return true;
			break;
		
		default:
			if (include_once "$base/index.php") return true;
	}
	return false;
}


// Useful function to create a new file from WebDAV
function elgg_webdav_create_file($name, $data, $options = array()) {
	$defaults = array(
			'title' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
			'access_id' => 0,
			'description' => '',
			'container_guid' => elgg_get_logged_in_user_guid(),
			'owner_guid' => elgg_get_logged_in_user_guid(),
			'tags' => '',
			'mime_type' => '',
		);
	$options = array_merge($defaults, $options);

	$file = new FilePluginFile();
	$file->subtype = "file";
	$file->title = $options['title'];
	$file->description = $options['description'];
	$file->access_id = $options['access_id']; // private
	$file->container_guid = $options['container_guid'];
	$file->owner_guid = $options['owner_guid'];
	$file->tags = $options['tags'];
	
	// Save file content
	$prefix = "file/";
	$filestorename = elgg_strtolower(time().$name);
	$file->setFilename($prefix . $filestorename);
	$file->originalfilename = $name;
	
	// Convert data to string if it is a resource (mostly)
	if (is_resource($data)) {
		$data = stream_get_contents($data);
	}
	
	// Open the file to guarantee the directory exists
	$file->open("write");
	$file->write($data);
	$file->close();
	$guid = $file->save();

	// Cannot determine MIME type before the file actually exists on server
	$mime_type = $file->detectMimeType($file->getFilenameOnFilestore(), $options['mime_type']);
	$file->setMimeType($mime_type);
	$file->simpletype = elgg_get_file_simple_type($mime_type);


	// if image, we need to create thumbnails (this should be moved into a function)
	if ($guid && $file->simpletype == "image") {
		$file->icontime = time();

		$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
		if ($thumbnail) {
			$thumb = new ElggFile();
			$thumb->setMimeType($mime_type);
			$thumb->setFilename($prefix."thumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumbnail);
			$thumb->close();
			$file->thumbnail = $prefix."thumb".$filestorename;
			unset($thumbnail);
		}

		$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
		if ($thumbsmall) {
			$thumb->setFilename($prefix."smallthumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumbsmall);
			$thumb->close();
			$file->smallthumb = $prefix."smallthumb".$filestorename;
			unset($thumbsmall);
		}

		$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
		if ($thumblarge) {
			$thumb->setFilename($prefix."largethumb".$filestorename);
			$thumb->open("write");
			$thumb->write($thumblarge);
			$thumb->close();
			$file->largethumb = $prefix."largethumb".$filestorename;
			unset($thumblarge);
		}
	}
	
	// Return the created object
	if ($guid) {
		return $file;
	} else {
		return false;
	}
}


