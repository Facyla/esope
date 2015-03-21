<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']       The page title
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// render content before head so that JavaScript and CSS can be loaded. See #4032
$topbar = elgg_view('page/elements/topbar', $vars);
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('page/elements/header', $vars);
$body = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

// Set the content type
header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
  <?php echo elgg_view('page/elements/head', $vars); ?>
</head>
<body>
<div class="elgg-page elgg-page-default">
	<div class="elgg-page-messages">
		<?php echo $messages; ?>
	</div>
	
	<?php if (elgg_is_logged_in()): ?>
	<div class="elgg-page-topbar">
		<div class="elgg-inner">
			<?php echo $topbar; ?>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="elgg-page-header">
		<div class="elgg-inner">
			<?php echo $header; ?>
		</div>
	</div>
	<div class="elgg-page-body">
		<div class="elgg-inner">
      <div class="<?php echo $class; ?>">
	      <div class="elgg-sidebar">
		      <?php echo elgg_view('page/elements/sidebar', $vars); ?>
	      </div>

	      <div class="elgg-main elgg-body">
		      <?php
			      echo $nav;
			      if (isset($vars['title'])) { echo elgg_view_title($vars['title']); }
			      if (isset($vars['area1'])) { echo $vars['area1']; }
			      if (isset($vars['content'])) { echo $vars['content']; }
		      ?>
	      </div>
      </div>
		</div>
	</div>
	<div class="elgg-page-footer">
		<div class="elgg-inner">
			<?php echo $footer; ?>
		</div>
	</div>
</div>
<?php echo elgg_view('page/elements/foot'); ?>
</body>
</html>


