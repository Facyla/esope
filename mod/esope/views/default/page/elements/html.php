<?php
/**
 * Page shell for all HTML pages
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body']        The main content of the page
 */
// Set the content type
elgg_set_http_header("Content-type: text/html; charset=UTF-8");

// Allow external embed (hack) - we want to be able to provide iframe and embed codes
if (function_exists('header_remove')) {
	header_remove('X-Frame-Options');
} else {
	header('X-Frame-Options: GOFORIT');
}

$lang = get_current_language();

$attrs = "";
if (isset($vars['body_attrs'])) {
	$attrs = elgg_format_attributes($vars['body_attrs']);
	if ($attrs) {
		$attrs = " $attrs";
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
	<head>
		<?php echo $vars["head"]; ?>
	</head>
	<body<?php echo $attrs ?>>
		<?php echo $vars["body"]; ?>
	</body>
</html>
