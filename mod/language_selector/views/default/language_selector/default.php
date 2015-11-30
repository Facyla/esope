<?php 

$allowed = language_selector_get_allowed_translations();
$current_lang_id = get_current_language();

if (count($allowed) > 1) {
	// show text or flags
	$show_flags = false;
	if (elgg_get_plugin_setting("show_images", "language_selector") != "no") {
		$show_flags = true;
	}
	$result = "";
	
	foreach ($allowed as $lang_id) {
		$lang_name = elgg_echo($lang_id);
		$text = "";
		$action = "";
		
		if (!empty($result)) {
			$result .= " | ";
		}

		if ($current_lang_id != $lang_id) {
			if (elgg_is_logged_in()) {
				$action = elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/language_selector/change?lang_id=" . $lang_id);
			} else {
				
				$action = "javascript:setLanguage(\"" . $lang_id . "\");";
			}				
		} 
		
		if ($show_flags) {
			
			$flag_file = "mod/language_selector/_graphics/flags/" . $lang_id . ".gif";
			
			if (file_exists(elgg_get_root_path() . $flag_file)) {
				$text = "<img src='" . elgg_get_site_url() . $flag_file . "' alt='" . $lang_name . "' title='" . $lang_name . "'>";
			}
		}
		
		if (empty($text)) {
			$text = $lang_id;
		}
		
		if (!empty($action)) {
			$result .= "<a href='" . $action . "' title='" . $lang_name . "'>" . $text . "</a>";
		} else {
			$result .= $text;	
		}				
	}
	
	$result = "<div class='language_selector'>" . $result . "</div>";

	if (!elgg_is_logged_in()) {
		?>
		<script type="text/javascript">
			function setLanguage(lang_id) {
				setCookie("client_language", lang_id, 30);
				document.location.href = document.location.href;			
			}
			function setCookie(c_name,value,expiredays) {
				var exdate = new Date();
				exdate.setDate(exdate.getDate() + expiredays);
				document.cookie = c_name + "=" + escape(value) + ";Path=/" + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
			}
		</script>
		<?php
	}

	echo $result;
}
