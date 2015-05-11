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

?>

<script type="text/javascript">
$(document).ready(function() {
	var livePreviewConfig = {
		trigger: 'hover',
		// Note : scale = viewWidth/targetWidth = viewHeight/targetHeight
		// So adjust view and target width and height depending on wanted result
		scale: '0.3', 
		viewWidth: 300, 
		viewHeight: 240, 
		targetWidth: 1000, 
		targetHeight: 800, 
		offset: 50,
		position: 'right'
	};
	
	// Full entity view
	$(".bookmark a").livePreview(livePreviewConfig);
	
	// Links listing view
	$(".elgg-context-bookmarks .elgg-list-entity .elgg-item .elgg-content a").livePreview(livePreviewConfig);
});
	
	// Support for feature anywhere (when explicitely asked)
	$(".livepreview").livePreview(livePreviewConfig);

</script>


