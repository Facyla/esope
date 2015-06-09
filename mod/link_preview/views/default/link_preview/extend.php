<?php
//elgg_load_js('jquery.live-preview');

/*
There are seven optional configurable options on initialization :

$(".livepreview").livePreview({
    trigger: 'hover',
    viewWidth: 300,  
    viewHeight: 200,  
    targetWidth: 1000,  
    targetHeight: 800,  
    scale: '0.5', 
    offset: 50,
    position: 'left'
});

    trigger :: trigger event, 'hover' or 'click', default = 'hover'
    viewWidth :: the preview dialog width, default = 300px
    viewHeight :: the preview dialog height, default = 200px
    targetWidth :: the viewport size width of the site you are previewing, default = 1000px
    targetHeight :: the viewport size height of the site you are previewing, default = 800px
    scale :: the scaling of the viewport size of the site you are previewing (this is the CSS transform scale property), default = calculated automatically. Notes: If no scaling is specified, then the scaling is automatically calculated to provide the best fit to the preview dialog window size.
    offset :: the offset from the target in pixels, default = 50px
    position :: side to which the preview will open, left or right, default = right
*/

$trigger = elgg_get_plugin_setting('trigger', 'link_preview');
if (!in_array($trigger, array('hover', 'click'))) $trigger = 'hover';
$scale = elgg_get_plugin_setting('scale', 'link_preview');
if (!$scale || (10*$scale < 1)) $scale = '0.3';
$targetWidth = elgg_get_plugin_setting('targetwidth', 'link_preview');
if (!$targetWidth || ($targetWidth < 200)) $targetWidth = '200';
$targetHeight = elgg_get_plugin_setting('targetheight', 'link_preview');
if (!$targetHeight || ($targetHeight < 200)) $targetHeight = '200';
$offset = elgg_get_plugin_setting('offset', 'link_preview');
if (!$offset) $offset = '50';
$position = elgg_get_plugin_setting('position', 'link_preview');
if (!$offset) $offset = 'right';

// Compute view dimensions so we get the full page content in it
$viewWidth = $targetWidth * $scale;
$viewHeight = $targetHeight * $scale;

?>

<script type="text/javascript">
$(document).ready(function() {
	var livePreviewConfig = {
		trigger: '<?php echo $trigger; ?>',
		// Note : scale = viewWidth/targetWidth = viewHeight/targetHeight
		// So adjust view and target width and height depending on wanted result
		scale: '<?php echo $scale; ?>', 
		targetWidth: <?php echo $targetWidth; ?>, 
		targetHeight: <?php echo $targetHeight; ?>, 
		viewWidth: <?php echo $viewWidth; ?>, 
		viewHeight: <?php echo $viewHeight; ?>, 
		offset: <?php echo $offset; ?>,
		position: '<?php echo $position; ?>'
	};
	
	
	// @TODO : allow to set selectors on which to apply livePreview
	
	// Full entity view
	$(".bookmark a").livePreview(livePreviewConfig);
	
	// Links listing view
	$(".elgg-context-bookmarks .elgg-list-entity .elgg-item .elgg-content a").livePreview(livePreviewConfig);
});
	
	// Support for feature anywhere (when explicitely asked)
	$(".livepreview").livePreview(livePreviewConfig);

</script>


