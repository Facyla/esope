<?php
// Only required parameter
$color = $vars['value'];


// These are for customization (optional)
//$position = (isset($vars['position'])) ? $vars['position'] : "float:right;";
$position = (isset($vars['position'])) ? $vars['position'] : "";
$width = (isset($vars['width'])) ? $vars['width'] : "300px";
$wrapperstyle = (isset($vars['wrapperstyle'])) ? $vars['wrapperstyle'] : "height:12px; border:1px solid black; background:darkgrey;";
$barstyle = (isset($vars['barstyle'])) ? $vars['barstyle'] : "width:100%; background-color:$color;"; // bar style

// Render view
?>
<span style="<?php echo $position; ?>">
	<div style="<?php echo $wrapperstyle; ?> width:<?php echo $width; ?>;">
		<div style="position:relative; left: 0; top:0; height:100%; <?php echo $barstyle; ?>"></div>
	</div>
</span>
