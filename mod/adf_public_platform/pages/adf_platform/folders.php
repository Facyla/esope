<?php
/**
 * @TODO : List all files by group then by folder
 * This requires a complete review : list files by group, organise them in folders, 
 * ...dont display any editing tool here...
 * 
 */

global $CONFIG;

$title = "Folders";
$content = '';

$content .= '<style>
.tree li.main-folder { padding-bottom: 1ex; font-size: 18px; line-height:22px; }
.tree li li { font-size: 95%; line-height: normal; }
.tree .last.leaf { padding-bottom: 1ex; }
</style>';

if (elgg_is_active_plugin('file_tools') && (elgg_get_plugin_setting("user_folder_structure", "file_tools") == "yes") ) {
	// It's OK
} else {
	register_error("File tools plugin should be activated + folders enabled to display folders.");
}


// Sort order
elgg_push_context('widgets');
if (empty($sort_by)) { $sort_by = elgg_get_plugin_setting("sort", "file_tools"); }
// Sort direction
if (empty($direction)) { $direction = elgg_get_plugin_setting("sort_direction", "file_tools"); }

// load JS
elgg_load_js("jquery.tree");
elgg_load_css("jquery.tree");

elgg_load_js("jquery.hashchange");

$content .= '<script type="text/javascript">
$(function () {
	$("#folders-all").tree({
		ui : { theme_name : "default" },
		types : {
			"default" : {
				clickable: false,
				renameable: false,
				deletable: false,
				creatable: false,
				draggable: false,
			}
		},
	});
});

$(function() {
	//$("a[href*=\'file_tools/file/new\'], a[href*=\'file_tools/import/zip\']")
	$(".folder-file a").live("click",function(e) {
		window.open($(this).attr(\'href\'));
		e.preventDefault();
	});
});
</script>';


// List folders and files by group
$all_groups = elgg_get_entities(array('type' => 'group', 'limit' => false));
if ($all_groups) {
	$content .= '<div id="folders-all">';
	$content .= '<ul>';
	foreach ($all_groups as $group) {
		//if ($group->file_enable != 'yes') continue;
		elgg_set_page_owner_guid($group->guid);
		$content .= '<li id="folder-' . $group->guid . '" class="main-folder"><strong><i class="fa fa-folder-open-o"></i> <a href="' . $CONFIG->url . 'file/group/' . $group->guid . '/all">' . $group->name . '</a></strong>';
		
		
		// Dossiers et leur contenu
		$folders = false;
		$folder_content = '';
		$folders = file_tools_get_folders($group->guid);
		if ($folders) {
			foreach ($folders as $folder) { $folder_content .= esope_view_folder_content($folder, true); }
		}
		
		// Contenu du dossier principal (non classés)
		$files_content = '';
		$files_content = esope_view_folder_files($group->guid, false);
		
		// Handle empty case
		//if (!$files_content) { $files_content .= '<li>' . elgg_echo('file:none') . '</li>'; }
		
		if (!empty($files_content) || !empty($folder_content)) {
			$content .= '<ul>';
			$content .= $folder_content;
			$content .= $files_content;
			$content .= '</ul>';
		}
		
		//$content .= '<br /><br />';
		$content .= '</li>';
	}
	$content .= '</ul>';
}



// Render page content
$content = '<div class="folders-summary">' . $content . '</div>';
//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Affichage
echo elgg_view_page($title, $body);

