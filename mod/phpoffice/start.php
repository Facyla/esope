<?php
/**
 * phpoffice plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'phpoffice_init');


/**
 * Init phpoffice plugin.
 */
function phpoffice_init() {
	
	elgg_extend_view('css', 'phpoffice/css');
	
	// Register a PHP library
	// Register PHPOffice libs
	$base = elgg_get_plugins_path() . 'phpoffice/vendors/';
	// Elgg additional functions
	$base_lib = elgg_get_plugins_path() . 'phpoffice/lib/phpoffice/';
	// Note : use Composer to install PHPOffice libraries and generate autoload.php file
	elgg_register_library('phpoffice:common', $base . 'Common/vendor/autoload.php');
	elgg_register_library('phpoffice:word', $base . 'PHPWord/vendor/autoload.php');
	elgg_register_library('elgg:phpoffice:word', $base_lib . 'word.php');
	elgg_register_library('phpoffice:presentation', $base . 'PHPPresentation/vendor/autoload.php');
	elgg_register_library('elgg:phpoffice:presentation', $base_lib . 'presentation.php');
	elgg_register_library('phpoffice:excel', $base . 'PHPExcel/vendor/autoload.php');
	elgg_register_library('elgg:phpoffice:excel', $base_lib . 'excel.php');
	elgg_register_library('phpoffice:project', $base . 'PHPProject/src/PhpProject/Autoloader.php');
	elgg_register_library('elgg:phpoffice:project', $base_lib . 'project.php');

	
	/* Some useful elements :
	
	// Register actions
	// Actions should be defined in actions/phpoffice/action_name.php
	$action_base = elgg_get_plugins_path() . 'systems_game/actions/';
	elgg_register_action('systems_game/edit', $action_base . 'edit.php');
	elgg_register_action('systems_game/delete', $action_base . 'delete.php');
	
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/phpoffice');
	$css_url = elgg_get_simplecache_url('css', 'phpoffice');
	
	// Register JS script - use with : elgg_load_js('phpoffice');
	$js_url = elgg_get_plugins_path() . 'phpoffice/vendors/phpoffice.js';
	elgg_register_js('phpoffice', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('phpoffice');
	$css_url = elgg_get_plugins_path() . 'phpoffice/vendors/phpoffice.css';
	elgg_register_css('phpoffice', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'phpoffice');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'phpoffice');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'phpoffice_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','phpoffice_someevent');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "phpoffice_icon_hook");
	
	// override the default url to view a phpoffice object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'phpoffice_set_url');
	
	*/
	
	// Register a page handler on "phpoffice/"
	elgg_register_page_handler('phpoffice', 'phpoffice_page_handler');
	
	
}


// Include page handlers, hooks and events functions
include_once(elgg_get_plugins_path() . 'phpoffice/lib/phpoffice/hooks.php');
include_once(elgg_get_plugins_path() . 'phpoffice/lib/phpoffice/events.php');
include_once(elgg_get_plugins_path() . 'phpoffice/lib/phpoffice/functions.php');


// Page handler
// Loads pages located in phpoffice/pages/phpoffice/
function phpoffice_page_handler($page) {
	$base = elgg_get_plugins_path() . 'phpoffice/pages/phpoffice/';
	$word_base = elgg_get_plugins_path() . 'phpoffice/vendors/PHPWord/';
	$presentation_base = elgg_get_plugins_path() . 'phpoffice/vendors/PHPPresentation/';
	$excel_base = elgg_get_plugins_path() . 'phpoffice/vendors/PHPExcel/';
	$project_base = elgg_get_plugins_path() . 'phpoffice/vendors/PHPProject/';
	
	// Load the PHPOffice libraries (can also be loaded from the page_handler or from specific views)
	elgg_load_library('phpoffice:common');
	//\PhpOffice\PhpPresentation\Autoloader::register();
	
	switch ($page[0]) {
		/*
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		*/
		
		case 'word':
			elgg_load_library('phpoffice:word');
			elgg_load_library('elgg:phpoffice:word');
			if (($page[1] == 'samples') && (include $base . 'word_' . $page[2] . '.php')) {
				// OK
			} else if (empty($page[1]) || !include $word_base . 'samples/' . $page[1]) {
			error_log("T1");
				include $base . 'word.php';
			}
			break;
		
		case 'presentation':
			elgg_load_library('phpoffice:presentation');
			elgg_load_library('elgg:phpoffice:presentation');
			if (empty($page[1]) || !include $presentation_base . 'samples/' . $page[1]) {
				include $base . 'presentation.php';
			}
			break;
		
		case 'excel':
			elgg_load_library('phpoffice:excel');
			elgg_load_library('elgg:phpoffice:excel');
			if (empty($page[1]) || !include $excel_base . 'Examples/' . $page[1]) {
				include $base . 'excel.php';
			}
			break;
		
		case 'project':
			elgg_load_library('phpoffice:project');
			elgg_load_library('elgg:phpoffice:project');
			\PhpOffice\PhpProject\Autoloader::register();
			if (empty($page[1]) || !include $project_base . 'samples/' . $page[1]) {
				include $base . 'project.php';
			}
			break;
		
		default:
			include $base . 'index.php';
	}
	return true;
}


/* Other functions
 * always use plugin prefix : phpoffice_
 * if many, put functions in lib/phpoffice/functions.php
function phpoffice_function() {
	
}
*/


/* DOC : Extension MIME Type
.doc      application/msword
.dot      application/msword

.docx     application/vnd.openxmlformats-officedocument.wordprocessingml.document
.dotx     application/vnd.openxmlformats-officedocument.wordprocessingml.template
.docm     application/vnd.ms-word.document.macroEnabled.12
.dotm     application/vnd.ms-word.template.macroEnabled.12

.xls      application/vnd.ms-excel
.xlt      application/vnd.ms-excel
.xla      application/vnd.ms-excel

.xlsx     application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
.xltx     application/vnd.openxmlformats-officedocument.spreadsheetml.template
.xlsm     application/vnd.ms-excel.sheet.macroEnabled.12
.xltm     application/vnd.ms-excel.template.macroEnabled.12
.xlam     application/vnd.ms-excel.addin.macroEnabled.12
.xlsb     application/vnd.ms-excel.sheet.binary.macroEnabled.12

.ppt      application/vnd.ms-powerpoint
.pot      application/vnd.ms-powerpoint
.pps      application/vnd.ms-powerpoint
.ppa      application/vnd.ms-powerpoint

.pptx     application/vnd.openxmlformats-officedocument.presentationml.presentation
.potx     application/vnd.openxmlformats-officedocument.presentationml.template
.ppsx     application/vnd.openxmlformats-officedocument.presentationml.slideshow
.ppam     application/vnd.ms-powerpoint.addin.macroEnabled.12
.pptm     application/vnd.ms-powerpoint.presentation.macroEnabled.12
.potm     application/vnd.ms-powerpoint.template.macroEnabled.12
.ppsm     application/vnd.ms-powerpoint.slideshow.macroEnabled.12

*/


