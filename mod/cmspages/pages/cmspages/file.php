<?php
$guid = (int) get_input("guid");
$metadata = strtolower(get_input("metadata"));
$size = strtolower(get_input("size"));

$success = false;
$is_image = false;

// Pre-requisisites
$cmspage = get_entity($guid);
if (!elgg_instanceof($cmspage, 'object', 'cmspage')) {
	register_error(elgg_echo("cmspages:downloadfailed:invalidentity"));
	forward();
	exit;
}

// Determines how to handle the file
switch($metadata) {
	case 'featured_image':
		$is_image = true;
		$icon_sizes = elgg_get_config("icon_sizes");
		if (!isset($icon_sizes[$size])) { $size = 'original'; }
		if ($size != 'original') {
			$filepath = "featured_image/" . $cmspage->guid . $size . ".jpg";
		} else {
			$filepath = $cmspage->featured_image;
		}
		// Get the file
		$fh = new ElggFile();
		$fh->owner_guid = $cmspage->guid;
		$fh->setFilename($filepath);
		
		if ($fh->exists()) {
			$contents = $fh->grabFile();
			if ($contents) {
				// Set MIME type
				$imagetype = exif_imagetype($fh->getFilenameOnFilestore());
				$mimetype = image_type_to_mime_type($imagetype);
			} else {
				if ($size == 'original') { $size = 'master'; }
				$contents = @file_get_contents(elgg_get_plugins_path(). "mod/cmspages/graphics/icons/{$size}.png");
				$mimetype = "image/png";
			}
			$filename = "{$cmspage->guid}-{$cmspage->pagetype}." . explode('/', $mimetype)[1];
		}
		break;
	
	default:
		// Get the file
		$fh = new ElggFile();
		$fh->owner_guid = $cmspage->guid;
		$fh->setFilename($cmspage->{$metadata});
		if ($fh->exists()) {
			$contents = $fh->grabFile();
			// Try to determine file readable name (if known)
			$filename = $cmspage->{$metadata.'_name'};
			if (empty($filename)) { $filename = "{$cmspage->guid}-{$cmspage->pagetype}.$metadata"; }
		} else {
			register_error(elgg_echo("cmspages:downloadfailed:invalidmetadata"));
			forward();
			exit;
		}
}


//echo "$guid / $metadata / $size / $filepath / $imagetype / $mimetype / ".strlen($contents) . ' / ' . $fh->getFilenameOnFilestore(); exit;

if ($is_image) {
	// Render content
	header("Content-type: $mimetype");
	// fix for IE https issue
	header("Pragma: public");
	header("Expires: " . date("r", time() + 864000));
	header("Cache-Control: public");
	//header("Content-Disposition: inline; filename=\"$filename\"");
	header("Content-Length: " . strlen($contents));
	echo $contents;
	exit;
}


// Other/unknown MIME types
$mimetype = "application/octet-stream";

// Render content
header("Content-type: $mimetype");
// fix for IE https issue
header("Pragma: public");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . strlen($contents));
echo $contents;
exit;

