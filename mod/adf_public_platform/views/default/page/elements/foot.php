<?php

echo elgg_view('footer/analytics');

$js = elgg_get_loaded_js('footer');
foreach ($js as $script) { ?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php
}

$analytics = elgg_get_plugin_setting('analytics', 'adf_public_platform');
if (!empty($analytics)) echo '<script type="text/javascript"">' . $analytics . '</script>';


// Pure CSS menu integration : a piece of CSS in header + a deferred JS script for IE6
?>
<!--[if lt IE 7]>
  <script type=text/javascript>
  // Replaces "li:hover" for IE6
  sfHover = function() {
    var sfEls = document.getElementById("menu").getElementsByTagName("li");
    for (var i=0; i<sfEls.length; i++) {
      sfEls[i].onmouseover = function() {
        this.className = this.className.replace(new RegExp(" sfhover"), "");
        this.className += " sfhover";
      }
      sfEls[i].onmouseout = function() {
        this.className = this.className.replace(new RegExp(" sfhover"), "");
      }
    }
  }
  if (window.attachEvent) window.attachEvent("onload", sfHover);
  </script>
<![endif]-->

