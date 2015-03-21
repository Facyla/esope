<?php
$float = elgg_get_plugin_setting('alignposition', 'addthis_share');
$button = elgg_get_plugin_setting('buttonstyle', 'addthis_share');
$pubid = elgg_get_plugin_setting('profileID','addthis_share');

$full = elgg_extract('full_view', $vars, FALSE);
$share_url = elgg_extract('share_url', $vars, FALSE);
$context =  elgg_get_context();

if ($full && $context != 'thewire' && $pubid != '' )  {
  echo '<div style="float:'.$float.'">';

  switch ($button) {
    case 'big': ?>
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style addthis_32x32_style" <?php if ($share_url) echo 'addthis:url="'.$share_url.'"'; ?>>
      <a class="addthis_button_preferred_1"></a>
      <a class="addthis_button_preferred_2"></a>
      <a class="addthis_button_preferred_3"></a>
      <a class="addthis_button_preferred_4"></a>
      <a class="addthis_button_compact"></a>
      <a class="addthis_counter addthis_bubble_style"></a>
      </div>
      <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=<?php echo $pubid; ?>"></script>
      <!-- AddThis Button END -->
      <?php
      break; 

    case 'small' : ?>
      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style " <?php if ($share_url) echo 'addthis:url="'.$share_url.'"'; ?>>
      <a class="addthis_button_preferred_1"></a>
      <a class="addthis_button_preferred_2"></a>
      <a class="addthis_button_preferred_3"></a>
      <a class="addthis_button_preferred_4"></a>
      <a class="addthis_button_compact"></a>
      <a class="addthis_counter addthis_bubble_style"></a>
      </div>
      <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=<?php echo $pubid; ?>"></script>
      <!-- AddThis Button END -->
      <?php
      break;

  default: ?>
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style " <?php if ($share_url) echo 'addthis:url="'.$share_url.'"'; ?>>
    <a class="addthis_button_facebook_like" fb:like:layout="button_count" <?php if ($share_url) echo 'fb:like:href="'.$share_url.'"'; ?>></a>
    <a class="addthis_button_tweet" <?php if ($share_url) echo 'tw:url="'.$share_url.'"'; ?>></a>
    <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
    <a class="addthis_counter addthis_pill_style"></a>
    </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=<?php echo $pubid; ?>"></script>
    <!-- AddThis Button END -->
    <?php
    echo '</div>';
  }
  
}

