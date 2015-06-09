<?php

elgg_load_js('profileiconaccess.js');

$user = elgg_get_logged_in_user_entity();

$accesslist = get_write_access_array();
$access = ($user->iconaccess === NULL) ? ACCESS_PUBLIC : $user->iconaccess;

?>

<div class="profileiconaccess clearfix">
  <div class="profileiconaccess-throbber">
    <?php echo elgg_view('graphics/ajax_loader'); ?>
  </div>
  
  <div class="profileiconaccess-form">
  <label for="profileiconaccess-select"><?php echo elgg_echo('profileiconaccess:label'); ?></label><br>
  <?php
    echo elgg_view('input/dropdown', array(
        'name' => 'profileaccessicon',
        'value' => $access,
        'id' => 'profileiconaccess-select',
        'options_values' => $accesslist
        ));
  ?>
  </div>
</div>
