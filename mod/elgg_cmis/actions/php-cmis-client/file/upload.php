<?php
/* CMIS : upload to CMIS repository
 *
 * Note : this file is used both for single and multiple upload
 */


// Check that all conditions are met to use CMIS
$use_cmis = true;

// Load libraries (and get base page handler include path)
$vendor = elgg_cmis_vendor();
$base = elgg_cmis_libraries();

if (!elgg_cmis_is_valid_repo() || !elgg_cmis_get_session()) { $use_cmis = false; }

// CMIS config
$base_path = elgg_get_plugin_setting('filestore_path', 'elgg_cmis', "/");
// Should we also store in Elgg filestore (double storage for latest version)
$always_use_elggfilestore = elgg_get_plugin_setting('always_use_elggfilestore', 'elgg_cmis', true);
if ($always_use_elggfilestore != 'no') { $always_use_elggfilestore = true; } else { $always_use_elggfilestore = false; }

/**
 * Elgg file uploader/edit action
 *
 * @package ElggFile
 */

// Get variables
$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8');
$desc = get_input("description");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('file_guid');
$tags = get_input("tags");

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('file');

// check if upload attempted and failed
if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] != 0) {
	$error = elgg_get_friendly_upload_error($_FILES['upload']['error']);
	register_error($error);
	forward(REFERER);
}

// check whether this is a new file or an edit
$new_file = true;
if ($guid > 0) {
	$new_file = false;
}

if ($new_file) {
	// must have a file if a new file upload
	if (empty($_FILES['upload']['name'])) {
		$error = elgg_echo('file:nofile');
		register_error($error);
		forward(REFERER);
	}

	$file = new FilePluginFile();
	$file->subtype = "file";

	// if no title on new upload, grab filename
	if (empty($title)) {
		$title = htmlspecialchars($_FILES['upload']['name'], ENT_QUOTES, 'UTF-8');
	}

} else {
	// load original file object
	$file = new FilePluginFile($guid);
	if (!$file) {
		register_error(elgg_echo('file:cannotload'));
		forward(REFERER);
	}

	// user must be able to edit file
	if (!$file->canEdit()) {
		register_error(elgg_echo('file:noaccess'));
		forward(REFERER);
	}

	if (!$title) {
		// user blanked title, but we need one
		$title = $file->title;
	}
}

$file->title = $title;
$file->description = $desc;
$file->access_id = $access_id;
$file->container_guid = $container_guid;
$file->tags = string_to_tag_array($tags);

// we have a file upload, so process it
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

	$prefix = "file/";

	// CMIS : handle new version instead of removing file
	// if previous file in Elgg filestore, delete it
	if (!$new_file) {
		// CMIS : keep original file name (for versionning)
		$file_name = substr($file->getFilename(), strlen($prefix));
		$filename = $file->getFilenameOnFilestore();
		if (file_exists($filename)) {
			unlink($filename);
		}
	}
	
	$filestorename = elgg_strtolower(time().$_FILES['upload']['name']);

	$file->setFilename($prefix . $filestorename);
	$file->originalfilename = $_FILES['upload']['name'];
	$mime_type = $file->detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);

	$file->setMimeType($mime_type);
	$file->simpletype = elgg_get_file_simple_type($mime_type);
	// Latest used filestore
	$latest_filestore = array();
	
	
	// Try using CMIS filestore first, if unavailable fallback to Elgg method
	// Note : unless thumbnails support is implemented, avoid storing images on CMIS filestore
	if ($use_cmis && $file->simpletype != "image") {
		// Save first file object to database, because we need the GUID to forge the CMIS filepath (has to be unique and should not change)
		$file->save();
		$guid = $file->guid;
		
		// CMIS method
		if ($vendor == 'php-cmis-client') {
			// dkd PHP CMIS Client
			// Relative path in CMIS filestore (similar to Elgg filestore structure)
			$file_path = new \Elgg\EntityDirLocator($file->owner_guid);
			$file_path = $base_path . $file_path . 'file/';
			// File name on filestore should never change, but file name, content and type can change afterwards
			// So use a content-agnostic naming, so we can reuse existing file if already stored
			if ($new_file) {
				//$filestorename = $guid . '_' . time(); // do we need ts ?
				$filestorename = "$guid"; // Important : must be a string
				$file_name = $filestorename;
			} else if (!empty($file->cmis_path)) {
				// Get old file name on CMIS filestore
				$cmis_path = explode('/', $file->cmis_path);
				$file_name = array_pop($cmis_path);
				// If owner changes, file path will change so we should move CMIS file first
				// Note: however, owner is not supposed to change
				$old_file_path = implode('/', $cmis_path) . '/';
			}
			
			$file_content = file_get_contents($_FILES['upload']['tmp_name']);
			$file_content = \GuzzleHttp\Stream\Stream::factory($file_content);
			// Create new version for file
			$file_version = true;
			$file_params = array('mime_type' => $mime_type);
			// Avoid Fatal error screen and fallback gently to Elgg filestore if any failure
			try{
				if ($new_file || empty($file->cmis_path)) {
					$return = elgg_cmis_create_document($file_path, $file_name, $file_content, $file_version, $file_params);
				} else if ($file_path == $old_file_path) {
					// Create new version of document
					//$return = elgg_cmis_create_document($file_path, $file_name, $file_content, $file_version, $file_params);
					$return = elgg_cmis_version_document($file_path . $file_name, true, $file_content, $file_params);
				} else {
					// Path has changed in filestore : move first to new path, then create new version
					//error_log("$file_name, $old_file_path, $file_path"); // debug
					$old_file = elgg_cmis_get_document($old_file_path . $file_name, true);
					$moved_file = elgg_cmis_move_document($old_file, $old_file_path, $file_path);
					// Then update version
					//$return = elgg_cmis_create_document($file_path, $file_name, $file_content, $file_version, $file_params);
					$return = elgg_cmis_version_document($file_path . $file_name, true, $file_content, $file_params);
				}
			} catch(Exception $e){
				//error_log(print_r($e->getMessage(), true));
				register_error(print_r($e->getMessage(), true));
			}
			if ($return) {
				$file->cmis_id = $return->getId();
				$file->cmis_path = $file_path . $file_name;
				$latest_filestore[] = 'cmis';
				//error_log("CMIS upload : {$file->guid} / {$file->cmis_id} {$file->cmis_path}");
			}
			
		} else {
			// Apache Chemistry library
			// Avoid Fatal error screen and fallback gently to Elgg filestore if any failure
			try{
				//elgg_cmis_create_document($path, $name = '', $content = null, $version = false, $params = array());
				$return = elgg_cmis_upload_file($file->getFilenameOnFilestore(), $filestorename, '', $mime_type);
				if ($return) {
					$file->cmis_id = $return->id;
					$file->cmis_path = $file->getFilenameOnFilestore() . $filestorename;
					$latest_filestore[] = 'cmis';
				}
			} catch(Exception $e){
				//error_log(print_r($e->message, true));
				register_error(print_r($e->message, true));
			}
		}
		// Warn if CMIS filestore could not be used
		if (!$return) {
			system_message(elgg_echo('elgg_cmis:filestore:elgg:fallback'));
		}
	}
	
	// Use Elgg filestore if not using CMIS, or if CMIS upload failed
	// Or if we want to store file both on CMIS an Elgg
	if (!$use_cmis || !$return || $always_use_elggfilestore) {
		// Open the file to guarantee the directory exists
		$file->open("write");
		$file->close();
		if (move_uploaded_file($_FILES['upload']['tmp_name'], $file->getFilenameOnFilestore())) {
			$latest_filestore[] = 'elgg';
		}
		
		// Save file object to database
		$guid = $file->save();
	}
	
	// Store latest used filestore(s)
	$file->latest_filestore = $latest_filestore;
	
	
	
	// THUMBNAILS
	// Note on thumbnails: while CMIS is not used for image files (yet), a given image file can become a document and then change filestore between Elgg and CMIS
	// So removing old thumbnails can happen even if current file is stored in CMIS filestore
	// Also even images that would be stored in CMIS should have its thumbnails in Elgg filestore (at least until we support storing images on CMIS)	
	$thumb = new ElggFile();
	$thumb->owner_guid = $file->owner_guid;

	$sizes = [
		'small' => [
			'w' => 60,
			'h' => 60,
			'square' => true,
			'metadata_name' => 'thumbnail',
			'filename_prefix' => 'thumb',
		],
		'medium' => [
			'w' => 153,
			'h' => 153,
			'square' => true,
			'metadata_name' => 'smallthumb',
			'filename_prefix' => 'smallthumb',
		],
		'large' => [
			'w' => 600,
			'h' => 600,
			'square' => false,
			'metadata_name' => 'largethumb',
			'filename_prefix' => 'largethumb',
		],
	];
	
	// Remove old thumbs
	$remove_thumbs = function () use ($file, $sizes, $thumb) {
		if (!$file->guid) { return; }
		unset($file->icontime);
		foreach ($sizes as $size => $data) {
			$filename = $file->{$data['metadata_name']};
			if ($filename !== null) {
				// @TODO CMIS : remove thumbnails from CMIS filestore
				$thumb->setFilename($filename);
				$thumb->delete();
				unset($file->{$data['metadata_name']});
			}
		}
	};
	$remove_thumbs();
	
	$jpg_filename = pathinfo($filestorename, PATHINFO_FILENAME) . '.jpg';
	
	// @TODO CMIS Generate image thumbnails ?
	if ($guid && $file->simpletype == "image") {
		$file->icontime = time();
		foreach ($sizes as $size => $data) {
			// @TODO enable to get image from both Elgg and CMIS filestore
			$image_bytes = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), $data['w'], $data['h'], $data['square']);
			if (!$image_bytes) {
				// bail and remove any thumbs
				$remove_thumbs();
				break;
			}
			$filename = "{$prefix}{$data['filename_prefix']}{$jpg_filename}";
			$thumb->setFilename($filename);
			$thumb->open("write");
			$thumb->write($image_bytes);
			$thumb->close();
			unset($image_bytes);
			$file->{$data['metadata_name']} = $filename;
		}
	}
	
} else {
	// not saving a file but still need to save the entity to push attributes to database
	$file->save();
}

// file saved so clear sticky form
elgg_clear_sticky_form('file');


// handle results differently for new files and file updates
if ($new_file) {
	if ($guid) {
		$message = elgg_echo("file:saved");
		system_message($message);
		elgg_create_river_item(array(
			'view' => 'river/object/file/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $file->guid,
		));
	} else {
		// failed to save file object - nothing we can do about this
		$error = elgg_echo("file:uploadfailed");
		register_error($error);
	}

	$container = get_entity($container_guid);
	if (elgg_instanceof($container, 'group')) {
		forward("file/group/$container->guid/all");
	} else {
		forward("file/owner/$container->username");
	}

} else {
	if ($guid) {
		system_message(elgg_echo("file:saved"));
	} else {
		register_error(elgg_echo("file:uploadfailed"));
	}

	forward($file->getURL());
}

