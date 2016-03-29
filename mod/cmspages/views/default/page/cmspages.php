<?php
/**
 * CMSPages standard pageshell :
 * Full-width pageshell (from one_column)
 * 
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// Set the content type
header("Content-type: text/html; charset=UTF-8");

// Allow external embed (hack)
if (function_exists('header_remove')) { header_remove('X-Frame-Options'); } else { header('X-Frame-Options: GOFORIT'); }


// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	if (get_input('handler') != 'admin') {
		elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	}
	_elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

$lang = get_current_language();
$loggedin_class = 'elgg-public';
if (elgg_is_logged_in()) $loggedin_class = 'elgg-loggedin';

// render content before head so that JavaScript and CSS can be loaded. See #4032
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('page/elements/topbar', $vars);
$header = elgg_view('page/elements/header', $vars);
$body = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
	<?php echo elgg_view('page/elements/head', $vars); ?>
</head>

<body class="<?php echo $loggedin_class; ?>">
<div class="elgg-page elgg-page-default">
	<div class="elgg-page-messages">
		<?php echo $messages; ?>
	</div>
	
	<!-- Theme Content -->
<?php /*
	<div id="page_container"> 
		<div id="wrapper_header">
*/ ?>
	
		<?php echo $header; ?>
		
		<?php echo $body; ?>
		<div class="clearfloat"></div>
		
		<?php echo $footer; ?>
			
<?php /*
		</div><!-- wrapper_header //-->
	</div><!-- page_container //-->
*/ ?>
	<!-- Theme Content -->
	
</div>
	
	<!-- END -->
	
	<!-- JS deferred scripts -->
	<?php echo elgg_view('page/elements/foot'); ?>
	
</body>
</html>
