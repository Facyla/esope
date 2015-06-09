<?php
// Only required parameter
$imp = (int) $vars['value'];

// Bar colors
$colors = (isset($vars['colors'])) ? $vars['colors'] : "green";
$textcolor = 'white';
switch($colors) {
  case 'redtoblue':
    $cr = (int) ($imp); $cg = 0; $cb = 100-$cr; // From red to blue
    break;
  case 'redtogreen':
    $cr = (int) (100-$imp); $cg = (int) $imp; $cb = 0; // From red to green
    break;
  case 'green':
  default:
    $cr = 0; $cg = 100; $cb = 0; // Green bar
    $textcolor = 'black';
}

// These are for customization (optional)
//$position = (isset($vars['position'])) ? $vars['position'] : "float:right;";
$position = (isset($vars['position'])) ? $vars['position'] : "";
$width = (isset($vars['width'])) ? $vars['width'] : "300px";
$wrapperstyle = (isset($vars['wrapperstyle'])) ? $vars['wrapperstyle'] : "height:12px; border:1px solid black; background:darkgrey;";
$barstyle = (isset($vars['barstyle'])) ? $vars['barstyle'] : "width:$imp%; background-color:rgb($cr%, $cg%, $cb%);";; // bar style
$contentstyle = (isset($vars['contentstyle'])) ? $vars['contentstyle'] : "width:$width; font-size:10px; font-weight:bold; color:'.$textcolor.';"; // bar content style
$text = (isset($vars['text'])) ? $vars['text'] : "$imp&nbsp;%";

// Render view
?>
<span style="<?php echo $position; ?>">
  <div style="<?php echo $wrapperstyle; ?> width:<?php echo $width; ?>;">
    <div style="position:relative; left: 0; top:0; height:100%; <?php echo $barstyle; ?>">
      <div style="position:relative; left:0.5ex; top:0; <?php echo $contentstyle; ?>"><?php echo $text; ?></div>
    </div>
  </div>
</span>
