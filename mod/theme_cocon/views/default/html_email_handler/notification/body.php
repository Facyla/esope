<?php 
	$title = $vars["title"];
	$message = nl2br($vars["message"]);
	$language = get_current_language();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language; ?>" lang="<?php echo $language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base target="_blank" />
		
		<?php 
			if(!empty($title)){ 
				echo "<title>" . $title . "</title>\n";
			}
		?>
	</head>
	<body>
		<style type="text/css">
		body {
				color: #333333;
				font: 80%/1.4 "Lucida Grande",Verdana,sans-serif;
		}
		a {
				color: #6D2D4F;
		}
		#notification_container {
				margin: 0 auto;
				padding: 20px 0;
				width: 600px;
		}
		#notification_header {
				padding: 0 0 10px;
				text-align: right;
		}
		#notification_header a {
				color: #6D2D4F;
				font-size: 1.5em;
				font-weight: bold;
				text-decoration: none;
		}
		#notification_wrapper {
				background: none repeat scroll 0 0 #02658e;
				padding: 10px;
		}
		#notification_wrapper h2 {
				color: #FFF;
				font-size: 1.35em;
				line-height: 1.2em;
				margin: 5px 0 5px 10px;
		}
		#notification_content {
				background: none repeat scroll 0 0 #FFFFFF;
				padding: 10px;
		}
		#notification_footer {
				background: none repeat scroll 0 0 #02658e;
				margin: 10px 0 0;
				padding: 10px;
				text-align: right;
		}
		#notification_footer_logo {
				float: left;
		}
		#notification_footer_logo img {
				border: medium none;
		}
		.clearfloat {
				clear: both;
				font-size: 1px;
				height: 0;
				line-height: 0;
		}
		</style>
	
		<div id="notification_container">
			<div id="notification_header">
				<?php 
					$text = '<img src="' . $vars["config"]->site->url . 'mod/theme_cocon/graphics/email/logo_cocon.png" alt="' . $vars["config"]->site->name . '">';
					$site_url = elgg_view("output/url", array("href" => $vars["config"]->site->url, "text" => $text));
					echo $site_url;
				?>
			</div>
			<div id="notification_wrapper">
				<?php if(!empty($title)) echo elgg_view_title($title); ?>
			
				<div id="notification_content">
					<?php echo $message; ?>
				</div>
			</div>
			
			<div id="notification_footer">
				
				<?php 
					if(elgg_is_logged_in()){
						$settings_url = $vars["url"] . "settings";
						if(elgg_is_active_plugin("notifications")){
							$settings_url = $vars["url"] . "notifications/personal";
						}
						echo elgg_echo("html_email_handler:notification:footer:settings", array("<a href='" . $settings_url . "'>", "</a>"));
					}
				?>
				<div class="clearfloat"></div>
			</div>
		</div>
	</body>
</html>
