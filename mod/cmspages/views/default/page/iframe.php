<?php
/**
 * Elgg iframe pageshell
 * Provides full features without wrapping interface
 * Used for full embed, external use (so we need CSS as well then)
 *
 * @uses $vars['content']       The content to be rendered
 */

// Remove framekiller view (would break out of widgets)
elgg_unextend_view('page/elements/head', 'security/framekiller');

// CMSPage content
$body = elgg_extract('body', $vars);

// Set the content type
header("Content-type: text/html; charset=UTF-8");

$lang = get_current_language();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
	<head>
		<meta>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php echo elgg_view('page/elements/head', $vars); ?>
		<style>
		html, html body { background:#FFFFFF !important; border: 0; margin:0; }
		body { padding: 2px 4px; }
		</style>
	</head>
	<body>
		<div style="padding:0 4px;">
			<?php echo $body; ?>
		</div>
	</body>
</html>

