<?php
$title = elgg_extract("title", $vars);
$message = nl2br(elgg_extract("message", $vars));
$language = get_current_language();

// Integrate theme CSS - default wrapper
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform');
$textcolor = elgg_get_plugin_setting('textcolor', 'adf_public_platform');
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');
$font2 = elgg_get_plugin_setting('font2', 'adf_public_platform'); // Title font
$font4 = elgg_get_plugin_setting('font4', 'adf_public_platform'); // Main font
// Or use custom CSS
$notification_css = elgg_get_plugin_setting('notification_css', 'adf_public_platform');

$site_url = elgg_view("output/url", array("href" => $vars["config"]->site->url, "text" => $vars["config"]->site->name));

$settings_url = elgg_get_site_url() . "settings";
if (elgg_is_active_plugin("notifications")) {
	$settings_url = elgg_get_site_url() . "notifications/personal";
}
$notification_link = elgg_echo("html_email_handler:notification:footer:settings", array("<a href='" . $settings_url . "'>", "</a>"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language; ?>" lang="<?php echo $language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base target="_blank" />
		<?php if (!empty($title)) { echo "<title>" . $title . "</title>"; } ?>
	</head>
	<body>
		<?php if (!empty($notification_css)) {
			// Custom CSS
			echo '<style type="text/css">' . $notification_css . '</style>';
		} else {
			// Default CSS (basic integration with theme colors)
			?>
			<style type="text/css">
			body {
				font: 12px/17px <?php echo $font4; ?>;
				color: #333333;
			}
			
			h1, h2, h3, h4, h5, h6 { font-family: <?php echo $font2; ?>; }
			a { color: <?php echo $linkcolor; ?>; }
			a:hover, a:active, a:focus { color: <?php echo $linkhovercolor; ?>; }
			
			#notification_container {
				padding: 20px 0;
				width: 600px;
				margin: 0 auto;
			}
		
			#notification_header {
				text-align: right;
				padding: 0 0 10px;
			}
			
			#notification_header a {
				text-decoration: none;
				font-weight: bold;
				color: <?php echo $titlecolor; ?>;
				font-size: 18px;
			}
		
			#notification_wrapper {
				background: <?php echo $color3; ?>;
				padding: 10px;
			}
			
			#notification_wrapper h2 {
				margin: 5px 0 5px 10px;
				/*
				color: <?php echo $titlecolor; ?>;
				*/
				color:white;
				font-size: 16px;
				line-height: 20px;
			}
			
			#notification_content {
				background: #FFFFFF;
				padding: 10px;
			}
			
			#notification_content p {
				margin: 0px;
			}
			
			#notification_footer {
				margin: 10px 0 0;
				background: <?php echo $color3; ?>;
				padding: 10px;
				text-align: right;
				margin-top: 0;
				padding-top:20px;
				color:white;
			}
			#notification_footer a {
				color:white;
			}
			#notification_footer a:hover, #notification_footer a:active, #notification_footer a:focus {
				color:white;
			}
			
			#notification_footer_logo {
				float: left;
			}
			
			#notification_footer_logo img {
				border: none;
			}
			
			.clearfloat {
				clear:both;
				height:0;
				font-size: 1px;
				line-height: 0px;
			}
			</style>
		<?php } ?>
		
		<div id="notification_container">
			
			<div id="notification_header">
				<?php echo $site_url; ?>
			</div>
			
			<div id="notification_wrapper">
				<?php if (!empty($title)) { echo elgg_view_title($title); } ?>
				<div id="notification_content">
					<?php echo $message; ?>
				</div>
			</div>
			
			<div id="notification_footer">
				<?php
				// Link to notification settings
				echo $notification_link;
				?>
				<div class="clearfloat"></div>
			</div>
			
		</div>
		
	</body>
</html>
